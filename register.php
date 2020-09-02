<?php
include_once('db/connect.php');
include('function.php');
include('views/header.php');
include('views/sidebar-a.php');
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$error = [];
	$fn = $ln = $em = $pw = FALSE;

	if (preg_match('/^[\w\'.-]{2,20}$/i', trim('fname'))) {
		$fn = mysqli_real_escape_string($con, trim($_POST['fname']));
	} else {
		$error[] = 'fname';
	}

	if (preg_match('/^[\w\'.-]{2,20}$/i', trim('lname'))) {
		$ln = mysqli_real_escape_string($con, trim($_POST['lname']));
	} else {
		$error[] = 'lname';
	}

	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$em = mysqli_real_escape_string($con, trim($_POST['email']));
	} else {
		$error[] = 'email';
	}

	if (preg_match('/^[\w\'.-]{4,32}$/', trim($_POST['pass']))) {
		if ($_POST['pass'] == $_POST['cpass']) {
			$pw = mysqli_real_escape_string($con, trim($_POST['pass']));
		} else {
			$error[] = "cpass";
		}
	} else {
		$error[] = 'pass';
	}

	if ($fn && $ln && $em && $pw) {
		$que = "SELECT user_id FROM users WhERE email = '{$em}'";
		$res = resultQuery($que);
		if (mysqli_num_rows($res) == 0) {
			// neu khong co email bi trung lap trong csdl thi tao ra 1 key luu lai su dung cho viec kich hoat tai khoan
			$k = rand();

			$que = "INSERT INTO `users`(`first_name`, `last_name`, `email`, `pass`, `active`) ";
			$que .= " VALUES ('{$fn}', '{$ln}', '{$em}', '{$pw}', '{$k}'); ";
			$res = resultQuery($que);

			if (mysqli_affected_rows($con) == 1) {
				// neu sql thanh cong thi bat nguoi dung kich hoat tai khoan
				$messages
					= "<p class='success'>Click <a href='./admin/activate.php?k={$k}&em='{$em}'>here</a> to continue!</p>";
			} else {
				$messages = "<p class='warning'>Oop! There's a bit of an error here. Please re-register!</p>";
			}
		} else {
			$messages = "<p class='warning'>Email was already. Please use another email address</p>";
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
            <legend>Register</legend>
            <div>
                <label for="fname">First name</label>
				<?php if (isset($error) &&
					in_array('fname', $error)) echo "<p class='warning'>Please enter your fname</p>" ?>
                <input type="text" name="fname" id="fname" required
                       value="<?php echo isset($_POST['fname']) ? htmlentities($_POST['fname'], ENT_QUOTES, 'utf-8') :
					       '' ?>">
            </div>
            <div>
                <label for="lname">Last name</label>
				<?php if (isset($error) &&
					in_array('lname', $error)) echo "<p class='warning'>Please enter your lname</p>" ?>
                <input type="text" name="lname" id="lname" required
                       value="<?php echo isset($_POST['lname']) ? htmlentities($_POST['lname'], ENT_QUOTES, 'utf-8') :
					       '' ?>">
            </div>
            <div>
                <label for="email">Email</label>
				<?php if (isset($error) &&
					in_array('email', $error)) echo "<p class='warning'>Please enter your email</p>" ?>
                <input type="email" name="email" id="email" required
                       value="<?php echo isset($_POST['email']) ? htmlentities($_POST['email'], ENT_QUOTES, 'utf-8') :
					       '' ?>">
            </div>
            <div>
                <label for="pass">Password</label>
				<?php if (isset($error) &&
					in_array('pass', $error)) echo "<p class='warning'>Please enter your password</p>" ?>
                <input type="password" name="pass" id="pass" required>
            </div>
            <div>
                <label for="cpass">Confirm password</label>
				<?php if (isset($error) &&
					in_array('cpass', $error)) echo "<p class='warning'>Please enter your confirm password</p>" ?>
                <input type="password" name="cpass" id="cpass" required>
            </div>
        </fieldset>
        <input type="submit" name="submit" value="Register" style="width: 100px; height: 25px;">
    </form>
</div>

<?php
include('views/sidebar-b.php');
include('views/footer.php');
?>
