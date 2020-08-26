<?php
include_once('db/connect.php');
include('function.php');
include('views/header.php');
include('views/sidebar-a.php');
?>


<div id="content">
    <?php
    if (isset($_GET['cid'])) {
        $cid = validateId($_GET['cid']);
        if(empty($cid)){
            $cid = 1;
        }
    } else {
        $cid = 1;
    }

    $que = "SELECT p.page_name, p.page_id, LEFT(p.content, 400) as content, ";
    $que .= " DATE_FORMAT(p.post_on, '%b %d %y') AS date, ";
    $que .= " CONCAT_WS(' ' , u.first_name, u.last_name) AS name, u.user_id ";
    $que .= " FROM pages AS p ";
    $que .= " INNER JOIN users AS u ";
    $que .= " USING (user_id) ";
    $que .= " WHERE p.cat_id = {$cid} ";
    $que .= " ORDER BY date LIMIT 0, 10";
    $res = resultQuery($que);
    if (mysqli_num_rows($res)) {
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            echo "<div class='post'>
                            <h2><a href='single.php?pid={$row['page_id']}'>{$row['page_name']}</a></h2>
                            <p>" . beautifyText($row['content']) . " ... <a href='single.php?pid={$row['page_id']}'>Read more</a></p>
                            <p class='meta'><strong>Post by</strong>: {$row['name']} <strong>On</strong>: {$row['date']}</p>
                        </div>
                        ";
        }
    }

    ?>
</div>
<?php
include('views/sidebar-b.php');
include('views/footer.php');
?>