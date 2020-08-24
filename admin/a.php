<?php
session_start();
include('../db/connect.php');
include('../function.php');

?>
<?php

$cid = $_GET['cid'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['category'])) {
        $cate_name = mysqli_real_escape_string($con, strip_tags($_POST['category']));
    }
    if (isset($_POST['position'])) {
        $position = $_POST['position'];
    }

    if (isset($cate_name) && isset($position)) {
        //neu khong co loi xay ra thi them vao csdl
        $que = "UPDATE `categories` SET cate_name = '{$cate_name}', position = $position";
        $que .= " WHERE cat_id = {$cid} LIMIT 1";
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

<?php
if (isset($messages)) echo $messages;
?>
<form method="POST">
    <div>
        <label for="category">Categories name: </label>
        <input type="text" name="category">
    </div>
    <hr>
    <div>
        <label for="position">Position: </label>
        <select name="position">
            <option value="1">1</option>
            <option value="1" selected>2</option>
        </select>
    </div>
    <hr>
    <input type="submit" name="submit" value="Edit">
</form>