<?php
include_once('db/connect.php');
include('function.php');


include('views/header.php');
include('views/sidebar-a.php');

function PostTemplate($title, $text, $author_name, $date) {
    return "<div class='post'>
        <h2>{$title}</h2>
        <p>{$text}</a></p>
        <p class='meta'><strong>Post by</strong>: {$author_name} <strong>On</strong>: {$date}</p>
    </div>";
}

?>
<div id="content">
    <?php
    if ($pid = validate_id($_GET['pid'])) {
        $res = get_page_by_id($pid);
        if (mysqli_num_rows($res)) {

            while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                $page_name = $row['page_name'];
                $text = $row['content'];
                $author_name = $row['name'];
                $date = $row['date'];
                echo PostTemplate($title, $text, $author_name, $date);
            }
        }
    } else {
        redirect_to();
    }
    ?>
</div>
<?php
include('views/sidebar-b.php');
include('views/footer.php');
?>