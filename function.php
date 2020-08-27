<?php

define('base', 'http://localhost:8080/PHPBasic/izcms/');

//dieu huong trang
function redirectTo($page = 'index.php')
{
    $url = base . $page;
    header("Location: $url");
    die();
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
    if (filter_var($id, FILTER_VALIDATE_INT, array('min_range' => 1))) {
        return $id;
    } else {
        return NULL;
    }
}

// kiem tra $_GET['id'] cung voi $_GET['name']
function validateIDName($id, $name)
{
    if (filter_var($id, FILTER_VALIDATE_INT, array('min_range' => 1))) {
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

//tao the <p> khi xuat CSDL
function theContent($text)
{
    $cText = htmlentities($text, ENT_COMPAT, 'UTF-8');
    return str_replace(array("\r\n", "\n"), array("<p>", "</p>"), $cText);
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
function fullTemplate($pageName, $text, $authorName, $authorID, $date)
{
    echo "<div class='post'>
                <h2>{$pageName}</h2>
                <p>" . theContent($text) . "</p>
                <p class='meta'><strong>Post by</strong>: <a href=author.php?aid={$authorID}>{$authorName}</a> <strong>On</strong>: {$date}</p>
            </div>";
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
