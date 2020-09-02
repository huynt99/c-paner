<?php
include_once('db/connect.php');
include('function.php');
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
	return resultQuery($que);
}

if ($pid = validateId($_GET['pid'])) {
	$res = getPageById($pid);

	$aPosts = [];
	$title = '';
	if (!empty($res)) {
		if (mysqli_num_rows($res) == 1) {
			while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
				$title = $row['page_name'];
				$aPosts[] = [
					'pageName'   => $row['page_name'],
					'content'    => $row['content'],
					'authorName' => $row['name'],
					'date'       => $row['date'],
					'authorId'   => $row['user_id']
				];
			}
		}
	} else {
		redirectTo();
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
			fullTemplate($post['pageName'], $post['content'], $post['authorName'], $post['authorId'], $post['date']);
		}
		?>
		<?php include('views/comment-form.php'); ?>
    </div>
<?php
include('views/sidebar-b.php');
include('views/footer.php');
?>