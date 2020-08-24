<?php
session_start();


if (isset($_GET['submit']) && $_GET['submit'] == 'submit') {
    $cate_name = $_GET['categories'];
    $position = $_GET['position'];

    $sql = "INSERT INTO `categories`(`user_id`, `cate_name`, `position`)
                VALUES (1, '" . $cate_name . "', '" . $position . "');";
    $que = mysqli_query($con, $sql);
    $nr = mysqli_affected_rows($con);
    if ($nr == 1) {
        $messages =  "<p>The categories was added successfully</p>";
    } else {
        $messages = "<p>Can not added to the database</p>";
    }
}
?>

<div id="content">
    <h2>Create a categories</h2>
    <?php
        if (!empty($messages)) {echo $messages;}
    ?>
    <form action="" method="GET">
        <div style="padding: 10px;">
            <lable for="categories">Categories name: </lable>
            <input type="text" name="categories" value="">
        </div>
        <div style="padding: 10px;">
            <lable for="position">Position: </lable>
            <select name="position" id="">
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>
        <div style="padding: 10px;"><input type="submit" name="submit" value="submit"></div>
    </form>
</div>
<?php
include('sidebar-b.php');
include('footer-admin.php');
?>