<?php
include_once('../db/connect.php');
include('header-admin.php');
include('sidebar-a.php');
?>
<?php
// xác nhận biến $_GET trên đường base có hợp lệ không
if (isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
    $cid = $_GET['cid'];
} else {
    redirect_to('admin/view-categories.php');
}

// edit categories
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = array();

    if (empty($_POST['category'])) {
        $error[] = 'category';
    } else {
        $cate_name = mysqli_real_escape_string($con, strip_tags($_POST['category']));
    }

    if (empty($_POST['position'])) {
        $error[] = 'position';
    } else {
        $position = $_POST['position'];
    }

    if (empty($error)) {
        $que = "UPDATE `categories` SET cate_name = '{$cate_name}', position = $position
                WHERE cat_id = {$cid} LIMIT 1";
        $res = mysqli_query($con, $que);
        confirm_query($res, $que);

        if (mysqli_affected_rows($con) == 1) {
            $messages =  "<p class='success'>The categories was edited successfully</p>";
        } else {
            $messages = "<p class='warning'>Could not edit to the categories</p>";
        }
    } else {
        $messages = "<p class='warning'>Please fill all required fields</p>";
    }
}
?>

<div id="content">

    <?php
    $que = "SELECT cat_id, cate_name FROM categories";
    $que .= " WHERE cat_id = {$_GET['cid']}";
    $res = mysqli_query($con, $que);
    confirm_query($res, $que);
    if (mysqli_num_rows($res) == 1) {
        while ($r = mysqli_fetch_assoc($res)) {
            //lấy duy nhất 1 cate_name được select
            $cn = $r['cate_name'];
        }
    } else {
        // $cid ko hợp lệ sẽ thông báo 
        $messagesdie = "<p class='warning'>The categories does not exists</p>";
    }
    ?>
    <h2>Edit Categories: <span>id = <?php echo $cid; ?></span></h2>

    <?php
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
                    if (isset($error) && in_array('category', $error)) {
                        echo "<p class='warning'>Please pick a categories</p>";
                    }
                    ?>
                    <lable for="category">Categories name: </lable>
                    <input type="text" name="category" value="<?php echo (isset($cn)) ? $cn : ''; ?>">
                </div>
                <div style="padding: 10px;">
                    <?php
                    if (isset($error) && in_array('position', $error)) {
                        echo "<p class='warning'>Please pick a position</p>";
                    }
                    ?>
                    <lable for="position">Position: </lable>
                    <select name="position" id="">
                        <?php
                        $que = "SELECT COUNT(cat_id) FROM categories";
                        $res = mysqli_query($con, $que);
                        confirm_query($res, $que);
                        if (mysqli_num_rows($res) == 1) {
                            list($num) = mysqli_fetch_array($res, MYSQLI_NUM);
                            for ($i = 1; $i <= $num; $i++) {
                                echo "<option value='{$i}'>" . $i . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div style="padding: 10px;"><input type="submit" name="submit" value="submit"></div>
            </fieldset>
        </form>
    <?php } ?>
</div>
<?php
include('sidebar-b.php');
include('footer-admin.php');
?>