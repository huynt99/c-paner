<?php
include_once('../db/connect.php');
include('header-admin.php');
include('sidebar-a.php');
?>
<?php
    if(isset($_GET['catename'], $_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range' => 1))){
        $cid = $_GET['cid'];
        $cate_name = $_GET['catename'];

        if($_SERVER['REQUEST_METHOD'] == "POST" ){
            if(isset($_POST['delete']) && $_POST['delete'] == 'yes'){
                $que = "DELETE FROM categories WHERE cat_id = {$cid} LIMIT 1";
                $res = mysqli_query($con, $que);
                confirm_query($res, $que);
                if (mysqli_affected_rows($con) == 1){
                    $messages = "<p class='success'>The categories was deleted successfully</p>";
                } else {
                    $messages = "<p class='warning'>The categories was not deleted</p>";
                }
            } else {
                $messages = "<p class='warning'>The categories delete has been canceled</p>";
            }
        }
    } else {
        redirect_to('admin/view_categories.php');
    }
?>
<div id="content">
    <h2>Delete categories:</h2><span><?php if(isset($cate_name)) echo $cate_name;?></span>
    <?php 
    if(isset($messages)) echo $messages;
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
<?php
include('sidebar-b.php');
include('footer-admin.php');
?>