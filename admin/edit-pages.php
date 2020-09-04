<?php
include_once('../db/connect.php');
include('header-admin.php');
include('sidebar-a.php');
?>
<?php
// xác nhận biến $_GET trên đường base có hợp lệ không
if (isset($_GET['pid'])) {
	$pid = validateId($_GET['pid']);
	if (empty($pid)) {
		redirectTo('admin/view-pages.php');
	}
} else {
	redirectTo('admin/view-pages.php');
}
// edit categories
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$error = [];

	if (empty($_POST['page_name'])) {
		$error[] = 'page_name';
	} else {
		$page_name = mysqli_real_escape_string($con, strip_tags($_POST['page_name']));
	}

	if (empty($_POST['category'])) {
		$error[] = 'category';
	} else {
		$category = $_POST['category'];
	}

	if (empty($_POST['position'])) {
		$error[] = 'position';
	} else {
		$position = $_POST['position'];
	}

	if (empty($_POST['content'])) {
		$error[] = 'content';
	} else {
		$content = mysqli_real_escape_string($con, $_POST['content']);
	}

	if (empty($error)) {
		//code
		$que
			= "UPDATE `pages` SET page_name = '{$page_name}', cat_id = $category, position = $position, content = '{$content}'";
		$que .= " WHERE page_id = {$pid} LIMIT 1";
		$res = resultQuery($que);
		if (mysqli_affected_rows($con) == 1) {
			$messages = "<p class='success'>The page was edit successfully</p>";
		} else {
			$messages = "<p class='warning'>The page cannot edited a database</p>";
		}
	} else {
		$messages = "<p class='warning'>Please fill all required fields</p>";
	}
}

?>

    <div id="content">

    <h2>Edit Page: <span>id = <?php echo (isset($pid)) ? $pid : ''; ?></span></h2>

<?php
$messagesdie = checkID($_GET['pid'], 'page_id', 'pages');
// hien thi loi khi sua pages trong csdl
if (!empty($messagesdie)) {
	echo $messagesdie;
	die;
} else {
	if (!empty($messages)) echo $messages;
	?>

    <form action="" method="post" id="add_cat">
        <fieldset>

            <div style="padding: 10px;">
				<?php
				// hien thong bao loi khi chua nhap du lieu
				?>
                <lable for="page_name">Page name:</lable>
				<?php
				$que = "SELECT page_name FROM pages WHERE page_id = {$pid}";
				$res = resultQuery($que);
				if (mysqli_num_rows($res) == 1) {
					list($pg_name) = mysqli_fetch_array($res);
				}
				?>
                <input type="text" name="page_name" value="<?php echo (isset($pg_name)) ? $pg_name : ''; ?>">
            </div>

            <div style="padding: 10px;">
				<?php
				// hien thong bao loi khi chua nhap du lieu
				?>
                <lable for="category">Categories name:</lable>
                <select name="category">
					<?php
					$que = "SELECT cat_id, cate_name FROM categories";
					$res = resultQuery($que);
					if (mysqli_num_rows($res) > 0) {
						while ($row = mysqli_fetch_array($res)) {
							echo "<option value='{$row['cat_id']}'>" . $row['cate_name'] . "</option>";
						}
					}
					?>
                </select>
            </div>

            <div style="padding: 10px;">
				<?php
				// hien thong bao loi khi chua nhap
				?>
                <lable for="position">Position:</lable>
                <select name="position" id="">
                    <!-- php hien thi ra position trong db -->
					<?php
					$que = "SELECT DISTINCT(position) FROM categories";
					$res = resultQuery($que);
					if (mysqli_num_rows($res) > 0) {
						while ($row = mysqli_fetch_array($res)) {
							echo "<option value='{$row['position']}'>" . $row['position'] . "</option>";
						}
					}
					?>
                </select>
            </div>

            <div style="padding: 10px;">
				<?php
				// hien thong bao loi khi chua nhap
				?>
                <lable for="content">Content:</lable>
                <textarea name="content" cols="30" rows="5" style="width: 350px; height: 100px;">
                <?php
                $que = "SELECT content FROM pages WHERE page_id = {$pid}";
                $res = resultQuery($que);
                if (mysqli_num_rows($res) == 1) {
	                list($cont) = mysqli_fetch_array($res);
	                echo $cont;
                }
                ?>
                </textarea>
            </div>

            <div style="padding: 10px;">
                <input type="submit" name="submit" value="Edit page">
            </div>

        </fieldset>
    </form>
    </div>
	<?php
}
?>
<?php
include('sidebar-b.php');
include('footer-admin.php');
?>