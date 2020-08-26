<?php
include_once('../db/connect.php');
include('header-admin.php');
include('sidebar-a.php');
?>
<?php
if (isset($_GET['cid'], $_GET['catename'])) {
    list($cid, $cate_name) = validateIDName($_GET['cid'], $_GET['catename']);

    if (!empty($cid)) {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['delete']) && $_POST['delete'] == 'yes') {
                $que = "DELETE FROM categories WHERE cat_id = {$cid} LIMIT 1";
                $res = resultQuery($que);
                if (mysqli_affected_rows($con) == 1) {
                    $messages = "<p class='success'>The categories was deleted successfully</p>";
                } else {
                    $messages = "<p class='warning'>The categories was not deleted</p>";
                }
            } else {
                $messages = "<p class='warning'>The categories delete has been canceled</p>";
            }
        }
    } else {
        redirectTo('admin/view-categories.php');
    }
} else {
    redirectTo('admin/view-categories.php');
}
?>
<div id="content">
    <h2>Delete categories:</h2><span><?php if (isset($cate_name)) echo $cate_name; ?></span>
    <?php
    $messagesdie = checkID($_GET['cid'], 'cat_id', 'categories');
    if (!empty($messagesdie)) {
        echo $messagesdie;
        die;
    } else {
        if (!empty($messages)) echo $messages;
    ?>
        <form method="POST" id="add_cat">
            <fieldset>
                <lable for="delete">Are you sure?</lable>
                <div>
                    <input type="radio" name="delete" value="no" checked="checked"> No
                    <input type="radio" name="delete" value="yes"> Yes
                </div>
                <div><input type="submit" name="submit" value="Delete"></div>
            </fieldset>
        </form>
</div>
<?php } ?>
<?php
include('sidebar-b.php');
include('footer-admin.php');
?>