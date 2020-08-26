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

    if (empty($_GET['content'])) {
        $error[] = 'content';
    } else {
        $content = mysqli_real_escape_string($con, $_GET['content']);
    }

    if (empty($_GET['page_name'])) {
        $error[] = 'page_name';
    } else {
        $page_name = $_GET['page_name'];
    }

    if (empty($error)) {
        $que = "INSERT INTO `pages`(`user_id`, `cat_id`, `page_name`, `content`, `position`)
                VALUES (1, {$cate_name}, '{$page_name}','{$content}' , {$position});";
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
    if (isset($messages)) echo $messages;
    ?>
    <form action="" method="GET" id="login">
        <fieldset>
            <legend>Add a pages</legend>
            <?php
            if (isset($error) && in_array('page_name', $error)) {
                echo "<p class='warning'>Page name is not import</p>";
            }
            ?>
            <div style="padding: 10px;">
                <lable for="page_name">Page name: </lable>
                <input type="text" name="page_name" value="">
            </div>
            <?php
            if (isset($error) && in_array('category', $error)) {
                echo "<p class='warning'>Category is not select</p>";
            }
            ?>
            <div style="padding: 10px;">
                <lable for="category">Categories: </lable>
                <select name="category" id="">
                    <?php
                    $que = "SELECT COUNT(cat_id) FROM categories";
                    $res = resultQuery($que);
                    if (mysqli_num_rows($res) == 1) {
                        list($num) = mysqli_fetch_array($res, MYSQLI_NUM);
                        for ($i = 1; $i <= $num; $i++) {
                            echo "<option value ='{$i}' ";
                            if (isset($_GET['position']) && $_GET['position'] == $i)
                                echo "selected='selected";
                            echo ">" . $i . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <?php
            if (isset($error) && in_array('position', $error)) {
                echo "<p class='warning'>Position is not select</p>";
            }
            ?>
            <div style="padding: 10px;">
                <lable for="position">Position: </lable>
                <select name="position" id="">
                    <?php
                    $que = "SELECT COUNT(position) FROM categories";
                    $res = resultQuery($que);
                    if (mysqli_num_rows($res) == 1) {
                        list($num) = mysqli_fetch_array($res, MYSQLI_NUM);
                        for ($i = 1; $i <= $num; $i++) {
                            echo "<option value ='{$i}' ";
                            if (isset($_GET['position']) && $_GET['position'] == $i)
                                echo "selected='selected";
                            echo ">" . $i . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <?php
            if (isset($error) && in_array('content', $error)) {
                echo "<p class='warning'>Content is not import</p>";
            }
            ?>
            <div style="padding: 10px;">
                <lable for="content">Content: </lable>
                <textarea name="content" id="" cols="30" rows="10" style="margin: 0px; width: 350px; height: 100px;"></textarea>
            </div>
            <div style="padding: 10px;"><input type="submit" name="submit" value="Add page"></div>
        </fieldset>
    </form>
</div>
<?php
include('sidebar-b.php');
include('footer-admin.php');
?>