<?php
include('../db/connect.php');
include('../function.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = array();

    if (empty($POST['category'])) {
        $error[] = 'category';
    } else {
        $cate_name = mysqli_real_escape_string($con, strip_tags($POST['category']));
    }

    if (empty($POST['position'])) {
        $error[] = 'position';
    } else {
        $position = $POST['position'];
    }

    if (empty($error)) {
        $que = "UPDATE `categories` SET cate_name = '{$cate_name}', position = $position
                WHERE cat_id = {$cid} LIMIT 1";
        $res = mysqli_query($con, $que);
        confirm_query($res, $que);
        confirm_query($que, $res);

        if ($mysqli_affected_rows($con) == 1) {
            $messages =  "<p class='success'>The categories was edited successfully</p>";
        } else {
            $messages = "<p class='warning'>Could not edit to the categories</p>";
        }
    } else {
        $messages = "<p class='warning'>Please fill all required fields</p>";
    }
}
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
            <input type="text" name="category" value="<?php //echo $cn; 
                                                        ?>">
        </div>
        <div style="padding: 10px;">
            <?php
            if (isset($error) && in_array('position', $error)) {
                echo "<p class='warning'>Please pick a position</p>";
            }
            ?>
            <lable for="position">Position: </lable>
            <select name="position" id="">
                <option value="1">1</option>
                <option value="1">2</option>
            </select>
        </div>
        <div style="padding: 10px;"><input type="submit" name="submit" value="submit"></div>
    </fieldset>
</form>