<?php
include_once('db/connect.php');
include('function.php');

include('views/header.php');
include('views/sidebar-a.php');

// hien thi page qua page id trong $_GET['pid']
function getPageById($pid)
{
    $que = "SELECT p.page_name, p.page_id, p.content, ";
    $que .= " DATE_FORMAT(p.post_on, '%b %d %y') AS date, ";
    $que .= " CONCAT_WS(' ' , u.first_name, u.last_name) AS name, u.user_id ";
    $que .= " FROM pages AS p ";
    $que .= " INNER JOIN users AS u ";
    $que .= " USING (user_id) ";
    $que .= " WHERE p.page_id = {$pid} ";
    $que .= " ORDER BY date LIMIT 1";
    $res = resultQuery($que);
    return $res;
}

function postTemplate($title, $text, $author_name, $date)
{
    echo "<div class='post'>
                <h2>{$title}</h2>
                <p>{$text}</a></p>
                <p class='meta'><strong>Post by</strong>: {$author_name} <strong>On</strong>: {$date}</p>
            </div>";
}
?>

<div id="content">

    <?php
    if ($pid = validateId($_GET['pid'])) {
        $res = getPageById($pid);
        if (!empty($res)) {
            if (mysqli_num_rows($res) == 1) {
                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                    $page_name = $row['page_name'];
                    $text = $row['content'];
                    $author_name = $row['name'];
                    $date = $row['date'];
                    postTemplate($page_name, $text, $author_name, $date);
                }
            }
        } else {
            redirectTo();
        }
    } else {
        redirectTo();
    }
    ?>
</div>
<?php
include('views/sidebar-b.php');
include('views/footer.php');
?>