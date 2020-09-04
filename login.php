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
		$error[] = 'email';
	}

	if (!empty($_POST['pass'])) {
		$pw = mysqli_real_escape_string($con, trim($_POST['pass']));
	} else {
		$error[] = 'pass';
	}

	if (!$error) {
		$que
			= "SELECT user_id, first_name, user_lever FROM users WhERE (email = '{$em}' AND pass = '{$pw}') AND active IS NULL LIMIT 1; ";
		$res = resultQuery($que);
		if (mysqli_num_rows($res) == 1) {
			// Luu lai gia tri login
			list($uid, $fname, $level) = mysqli_fetch_array($res, MYSQLI_NUM);
			$_SESSION['uid'] = $uid;
			$_SESSION['fname'] = $fname;
			$_SESSION['level'] = $level;

			redirectAlert('Your account login successfully!');
		} else {
			$messages = "<p class='warning'>Wrong Email or Password is</p>";
		}
	} else {
		$messages = "<p class='warning'>Please fill all required fields</p>";
	}
}
?>
<div id="content">
    <form id="" method="POST">
		<?php echo (isset($messages)) ? $messages : ''; ?>
        <fieldset>
            <legend>Login</legend>
            <div>
                <label for="email">Email</label>
				<?php if (isset($error) &&
					in_array('pass', $error)) echo "<p class='warning'>Please enter your password</p>" ?>
                <input type="text" name="email" id="email" required
                       value="<?php echo isset($_POST['email']) ? htmlentities($_POST['email'], ENT_QUOTES, 'utf-8') :
					       '' ?>">
            </div>
            <div>
                <label for="pass">Password</label>
				<?php if (isset($error) &&
					in_array('pass', $error)) echo "<p class='warning'>Please enter your password</p>" ?>
                <input type="password" name="pass" id="pass" required
                       value="<?php echo isset($_POST['pass']) ? htmlentities($_POST['pass'], ENT_QUOTES, 'utf-8') :
					       '' ?>">
            </div>
        </fieldset>
        <input type="submit" name="submit" value="Login" style="width: 100px; height: 25px;">
        <br>
        <a href="forgot-password.php">Forgot Password?</a>
    </form>
</div>

<?php
include('views/sidebar-b.php');
include('views/footer.php');
?>
