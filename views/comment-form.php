<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($_POST['submit'] == 'Post comment') {
		$error = [];

		if (empty($_POST['name'])) {
			$error[] = 'name';
		} else {
			$author = $_POST['name'];
		}

		if (empty($_POST['email'])) {
			$error[] = 'email';
		} else {
			$email = mysqli_real_escape_string($con, $_POST['email']);
		}

		if (empty($_POST['comment'])) {
			$error[] = 'comment';
		} else {
			$comment = mysqli_real_escape_string($con, $_POST['comment']);
		}

		if (isset($_POST['captcha']) && trim($_POST['captcha']) != $_SESSION['ques']['answer']) {
			$error[] = 'captcha';
		}

		if (empty($error)) {
			$que = "INSERT INTO `comments`(`page_id`, `author`, `email`, `comment`)";
			$que .= " VALUES ({$pid}, '{$author}', '{$email}', '{$comment}');";
			$res = resultQuery($que);
			if (mysqli_affected_rows($con) == 1) {
				$messages = "<p class='success'>Your comment has been posted</p>";
			} else {
				$messages = "<p class='warning'>Your comment has not been posted</p>";
			}
		} else {
			$messages = "<p class='warning'>Please fill all required fields</p>";
		}
	}
}
?>
<?php
// hien thi comment
$que = "SELECT comment_id, author, comment, DATE_FORMAT(comment_date, '%b %d %y') AS date FROM `comments` WHERE page_id = {$pid}";
$res = resultQuery($que);
if (mysqli_num_rows($res) > 0) {
	echo "<ol id='disscuss'>";
	while (list($cmtId, $author, $comment, $date) = mysqli_fetch_row($res)) {
		echo "<li class='comment-wrap'>
                <p class='author'>{$author}</p>
                <p>{$comment}</p>";
		if (isAdmin()) echo "<a id='{$cmtId}' class='remove'>Delete</a>";

		echo    "<p class='date'>{$date}</p>
                </li>";
	}
	echo "</ol>";
} else {
	echo "You are the first to comment on this post";
}
?>
<form action="" method="POST">
    <fieldset>
        <legend>Add a comment</legend>
		<?php
		if (isset($messages)) echo $messages;

		if (isset($error) && in_array('name', $error)) {
			echo "<p class='warning'>Name is required</p>";
		}
		?>
        <div style="padding: 10px;">
            <lable for="name">Name:</lable>
            <input type="text" name="name" value="<?php echo (isset($_POST['name'])) ? $_POST['name'] : ''; ?>">
        </div>
		<?php
		if (isset($error) && in_array('email', $error)) {
			echo "<p class='warning'>Email is required</p>";
		}
		?>
        <div style="padding: 10px;">
            <lable for="email">Email:</lable>
            <input type="email" name="email" value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : ''; ?>">
        </div>
		<?php
		if (isset($error) && in_array('comment', $error)) {
			echo "<p class='warning'>Comment is required</p>";
		}
		?>
        <div style="padding: 10px;">
            <lable for="comment">Comment:</lable>
            <textarea name="comment" id="" cols="30" rows="10" style="margin: 0px; width: 350px; height: 100px;">
            <?php echo (isset($_POST['comment'])) ? htmlentities($_POST['comment'], ENT_QUOTES, 'UTF-8') : ''; ?>
            </textarea>
        </div>
		<?php
		if (isset($error) && in_array('captcha', $error)) {
			echo "<p class='warning'>Answer the question correctly</p>";
		}
		?>
        <div style="padding: 10px;">
            <lable for="captcha">Answer question: <?php echo captcha(); ?></lable>
            <input type="number" name="captcha" value="">
        </div>

        <div style="padding: 10px;"><input type="submit" name="submit" value="Post comment"></div>
    </fieldset>
</form>