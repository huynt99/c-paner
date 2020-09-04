<?php
include_once('db/connect.php');
include('function.php');
include('views/header.php');
include('views/sidebar-a.php');
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$error = [];

	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$em = mysqli_real_escape_string($con, trim($_POST['email']));
	} else {
		$error = 'email';
	}

	if (empty($error)) {
		$que = "SELECT user_id FROM users WHERE email = '{$em}' LIMIT 1";
		$res = resultQuery($que);
		if (mysqli_affected_rows($con) == 1) {
			list($uid) = mysqli_fetch_array($res, MYSQLI_NUM);
			$pw = rand();
			$que = "UPDATE users SET pass = {$pw} WHERE user_id = {$uid}";
			$res = resultQuery($que);
			if (mysqli_affected_rows($con)) {
				$messages
					= "<p class='success'>Password has been changed to: $pw ! Please login and change password</p>";
			} else {
				$messages = "<p class='warning'>Please re-enter your email</p>";
			}
		} else {
			$messages = "<p class='warning'>Email does not exists</p>";
		}
	} else {
		$messages = "<p class='warning'>Please fill all required fields</p>";
	}
}
?>
<div id="content">
    <form method="post">
		<?php echo (isset($messages)) ? $messages : ''; ?>
        <fieldset>
            <legend>Forgot password</legend>
			<?php
			templateInputEmail('email', 'Email');
			templateInputSubmit('Sent mail');
			?>
        </fieldset>
    </form>
</div>

<?php
include('views/sidebar-b.php');
include('views/footer.php');
?>
