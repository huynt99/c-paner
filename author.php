<?php
include_once('db/connect.php');
include('function.php');

// hien thi page qua page id trong $_GET['pid']
function getPageById($aid)
{
    $que = "SELECT p.page_name, p.page_id, LEFT(p.content, 400) AS content, ";
    $que .= " DATE_FORMAT(p.post_on, '%b %d %y') AS date, ";
    $que .= " CONCAT_WS(' ' , u.first_name, u.last_name) AS name, u.user_id, ";
    $que .= " COUNT(c.comment_id) AS count ";
    $que .= " FROM pages AS p ";
    $que .= " INNER JOIN users AS u ";
    $que .= " USING (user_id) ";
    $que .= " LEFT JOIN comments AS c ";
    $que .= " USING(page_id) ";
    $que .= " WHERE u.user_id = {$aid} ";
    $que .= " GROUP BY page_id ";
    $que .= " ORDER BY date ASC LIMIT 0, 10";
    $res = resultQuery($que);
    return $res;
}

if ($aid = validateId($_GET['aid'])) {
    $res = getPageById($aid);
    $aPosts = array();
    $title = '';
    if (!empty($res)) {
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                $title = $row['page_name'];
                $aPosts[] = array(
                    'pageId' => $row['page_id'],
                    'pageName' => $row['page_name'],
                    'content' => $row['content'],
                    'count' => $row['count'],
                    'authorName' => $row['name'],
                    'date' => $row['date'],
                    'authorId' => $row['user_id']
                );
            }
        }
    } else {
        echo "<p>Error Error Error</p>";
    }
} else {
    redirectTo();
}

include('views/header.php');
include('views/sidebar-a.php');
?>

<div id="content">

    <?php
    foreach ($aPosts as $post) {
        postTemplate($post['pageId'], $post['pageName'], $post['content'], $post['count'], $post['authorId'], $post['authorName'], $post['date']);
    }
    ?>
</div>
<?php
include('views/sidebar-b.php');
include('views/footer.php');
?>