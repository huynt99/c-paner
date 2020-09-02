<?php
include_once('db/connect.php');
include('function.php');
include('views/header.php');
include('views/sidebar-a.php');

function getPageById($cid)
{
    $que = " SELECT p.page_id, p.page_name, LEFT(p.content, 400) AS content, ";
    $que .= " DATE_FORMAT(post_on, '%b %d, %y') AS date, ";
    $que .= " CONCAT_WS(' ' , u.first_name, u.last_name) AS name, user_id, ";
    $que .= " COUNT(c.comment_id) AS count ";
    $que .= " FROM users AS u ";
    $que .= " INNER JOIN pages AS p ";
    $que .= " USING(user_id) ";
    $que .= " LEFT JOIN comments AS c ";
    $que .= " USING(page_id) ";
    $que .= " WHERE p.cat_id = {$cid} ";
    $que .= " GROUP BY page_id ";
    $que .= " ORDER BY `content` ASC LIMIT 0, 10 ";
    return resultQuery($que);
}

?>

<div id="content">
    <?php
    if (isset($_GET['cid'])) {
        $cid = validateId($_GET['cid']);
        if (empty($cid)) {
            $cid = 1;
        }
    } else {
        $cid = 1;
    }

    $res = getPageById($cid);
    if (mysqli_num_rows($res)) {
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            postTemplate($row['page_id'], $row['page_name'], $row['content'], $row['count'], $row['user_id'], $row['name'], $row['date']);
        }
    }

    ?>
</div>
<?php
include('views/sidebar-b.php');
include('views/footer.php');
?>