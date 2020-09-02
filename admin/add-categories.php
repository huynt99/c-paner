<?php
session_start();
include_once('../db/connect.php');
include('header-admin.php');
include('sidebar-a.php');


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $error = array();
    if (empty($_GET['category'])) {
        $error[] = 'category';
    } else {
        $cate_name = $_GET['category'];
    }
    if (empty($_GET['position'])) {
        $error[] = 'position';
    } else {
        $position = $_GET['position'];
    }

    if (empty($error)) {
        $que = "INSERT INTO `categories`(`user_id`, `cate_name`, `position`)
                VALUES (1, '" . $cate_name . "', '" . $position . "');";
        $res = resultQuery($que);
        $nr = mysqli_affected_rows($con);
        if ($nr == 1) {
            $messages =  "<p class='success'>The categories was added successfully</p>";
        } else {
            $messages = "<p class='warning'>Can not added to the database</p>";
        }
    } else {
        $messages = "<p class='warning'>Please fill all required fields</p>";
    }
}
?>

<div id="content">
    <h2>Create a categories</h2>
    <?php
    if (!empty($messages)) {
        echo $messages;
    }
    ?>
    <form action="" method="GET" id="login">
        <fieldset>
            <div style="padding: 10px;">
                <lable for="category">Categories name: </lable>
                <input type="text" name="category" value="<?php echo (isset($_GET['category'])) ? strip_tags($_GET['category']) : ''; ?>">
            </div>
            <div style="padding: 10px;">
                <lable for="position">Position: </lable>
                <select name="position" id="">
                    <?php
                    $que = "SELECT COUNT(cat_id) AS count FROM categories";
                    $res = resultQuery($que);
                    if (mysqli_num_rows($res) == 1) {
                        list($num) = mysqli_fetch_array($res, MYSQLI_NUM);
                        for ($i = 1; $i <= $num + 1; $i++) {
                            echo "<option value ='{$i}' ";
                            if (isset($_GET['position']) && $_GET['position'] == $i)
                                echo "selected='selected";
                            echo ">" . $i . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div style="padding: 10px;"><input type="submit" name="submit" value="submit"></div>
        </fieldset>
    </form>
</div>
<?php
include('sidebar-b.php');
include('footer-admin.php');
?>