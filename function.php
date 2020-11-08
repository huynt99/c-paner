<?php
define('base', 'http://izcms.huy.com/');

//dieu huong trang
function redirectTo($page = 'index.php')
{
	$url = base . $page;
	header("Location: $url");
	die();
}

// dieu huong trang kem theo thong bao alert message
function redirectAlert($message, $page = 'index.php')
{
	$url = base . $page;
	echo "<script type='text/javascript'>
           alert('" . $message . "');;
           window.location = '$url';
        </script>";
}

//xac nhan truy van co so du lieu 
function confirmQuery($res, $que)
{
	global $con;
	if (empty($res)) {
		die("Query: {$que} \n<br/>  Error: " . mysqli_error($con));
	}
}

//truy van co so du lieu, xac nhan lenh truy van co thuc hien khong -> roi tra ve ket qua
function resultQuery($que)
{
	global $con;
	$res = mysqli_query($con, $que);
	confirmQuery($res, $que);
	return $res;
}

//lam dep van ban hien thi tren trang 
function beautifyText($text)
{
	return substr($text, 0, strrpos($text, ' '));
}

//kiem tra $_GET['id'] tren url
function validateId($id)
{
	if (filter_var($id, FILTER_VALIDATE_INT, ['min_range' => 1])) {
		return $id;
	} else {
		return NULL;
	}
}

// kiem tra $_GET['id'] cung voi $_GET['name']
function validateIDName($id, $name)
{
	if (filter_var($id, FILTER_VALIDATE_INT, ['min_range' => 1])) {
		$aIdAndName = [
			$id,
			$name
		];
		return $aIdAndName;
	} else {
		return NULL;
	}
}

//kiem tra id co trong csdl khong
function checkID($getId, $idSelect, $tableSelect)
{
	$que = "SELECT $idSelect FROM $tableSelect";
	$que .= " WHERE cat_id = {$getId}";
	$res = resultQuery($que);
	if (mysqli_num_rows($res) == 0) {
		// $cid ko hợp lệ sẽ thông báo
		return "<p class='warning'>The categories does not exists</p>";
	} else {
		return NULL;
	}
}

//captcha
function captcha()
{
	$capt = [
		1 => ['question' => "mot cong mot", 'answer' => 2],
		2 => ['question' => "mot cong hai", 'answer' => 3],
		3 => ['question' => "mot cong ba", 'answer' => 4],
		4 => ['question' => "mot cong bon", 'answer' => 5],
		5 => ['question' => "mot cong nam", 'answer' => 6]
	];
	$ran_key = array_rand($capt);
	$_SESSION['ques'] = $capt[$ran_key];    // luu lai cau hoi de doi chieu voi ket qua
	return $ques = $capt[$ran_key]['question'];
}

// ham su dung de loai bo nhung ki tu dac biet tránh spam mail
function cleanEmail($value)
{
	$sub = ['to:', 'bcc:', 'content-type:', 'mine-version:', 'multipart-mixed', 'content-transfer-encoding:'];
	foreach ($sub as $s) {
		if (strpos($value, $s) !== FALSE) {
			return '';
		}
		$value = str_replace(['\n', '\r', '%0a', '%0d'], '', $value);
		return trim($value);
	}
}

// file admin
function isAdmin()
{
	return isset($_SESSION['level']) && ($_SESSION['level'] == 0);
}

function adminAccess()
{
	if (!isAdmin()) {
		redirectTo();
	}
}

//count page views
function counterView($pageId)
{
	$ip = $_SERVER['REMOTE_ADDR'];
	global $con;

	//truy van de kiem tra page co ton tai trong page_views chua
	$que = "SELECT num_views, user_ip FROM page_views WHERE page_id=$pageId";
	$res = resultQuery($que);

	if (mysqli_num_rows($res) > 0) {
		// neu da ton tai va user_ip bang voi $ip nguoi dang su dung thi them luot xem vao csdl
		list($numViews, $userIp) = mysqli_fetch_row($res);
		if ($userIp !== $ip) {
			$que = "UPDATE page_views SET num_views=num_views+1 WHERE page_id=$pageId LIMIT 1;";
			$res = resultQuery($que);
		}
	} else {
		//neu chua thi them page vao page_views
		$que = "INSERT INTO page_views(page_id, user_ip) VALUES ($pageId, '{$ip}');";
		$res = resultQuery($que);
	}
}


//****************** Template ********************//
//tao the <p> khi xuat CSDL
function theContent($text)
{
	$cText = htmlentities($text, ENT_COMPAT, 'UTF-8');
	return str_replace(["\r\n", "\n"], ["<p>", "</p>"], $cText);
}

// hien thi bai viet duoi dang ngan gon
function postTemplate($pageId, $pageName, $pageContent, $count, $userId, $author, $date)
{
	echo "<div class='post'>
	            <h2><a href='single.php?pid={$pageId}'>{$pageName}</a></h2>
	            <p class='comments'><a href='single.php?pid={$pageId}#disscuss'>{$count}</a></p>
	            <p>" . beautifyText($pageContent) . " ... <a href='single.php?pid={$pageId}'>Read more</a></p>
	            <p class='meta'><strong>Post by</strong>: <a href='author.php?aid={$userId}'>{$author}</a> 
	            <strong>On</strong>: {$date}</p>
	        </div>";
}

// hien thi bai viet duoi dang day du
function fullTemplate($pageName, $text, $authorName, $authorID, $date, $page_views)
{
	echo "<div class='post'>
	                <h2>{$pageName}</h2>
	                <p>" . theContent($text) . "</p>
	                <p class='meta'><strong>Post by</strong>: <a href=author.php?aid={$authorID}>{$authorName}</a> 
	                    <strong>On</strong>: {$date}| <strong>Views</strong>:{$page_views}
	                </p>
	            </div>";
}

// input text cho form
function templateInputText($name, $label, $postName = null, $error = [])
{
	echo "<div>
	            <label for='$name'>$label</label>";
	echo (isset($error) && in_array($name, $error)) ? "<p class='warning'>Please enter your $label</p>" : '';
	echo "<input type='text' name='$name'' id='$name' required value=";
	echo (isset($postName)) ? htmlentities($postName, ENT_QUOTES, 'utf-8') : '';
	echo "> 
	          </div>";
}

// input email cho form
function templateInputEmail($name, $label, $postName = null, $error = [])
{
	echo "<div>
	            <label for='$name'>$label</label>";
	echo (isset($error) && in_array($name, $error)) ? "<p class='warning'>Please enter your $label</p>" : '';
	echo "<input type='email' name='$name'' id='$name' required value=";
	echo (isset($postName)) ? htmlentities($postName, ENT_QUOTES, 'utf-8') : '';
	echo ">
		      </div>";
}

// input pass cho form
function templateInputPass($name, $label, $postName = null, $error = [])
{
	echo "<div>
	            <label for='$name'>$label</label>";
	echo (isset($error) && in_array($name, $error)) ? "<p class='warning'>Please enter your $label</p>" : '';
	echo "<input type='password' name='$name' id='$name' required value=";
	echo (isset($postName)) ? htmlentities($postName, ENT_QUOTES, 'utf-8') : '';
	echo ">
			  </div>";
}

// textarea cho form
function templateInputTextarea($name, $label, $postName = null, $error = [])
{
	echo "<div>
	            <label for='$name'>$label</label>";
	echo (isset($error) && in_array($name, $error)) ? "<p class='warning'>Please enter your $label</p>" : '';
	echo "<div>
	                <textarea id='$name' name='$name' cols='30' rows='10' style='width: 350px; height: 100px;'>";
	echo (isset($postName)) ? htmlentities($postName, ENT_QUOTES, 'utf-8') : '';
	echo "</textarea>
				</div>
			 </div>";
}

// Input submit
function templateInputSubmit($name)
{
	echo "<input type=\"submit\" name=\"submit\" value=\"$name\" style=\"width: 150px; height: 25px; margin: 10px;\">";
}
//************************** end ***********************//