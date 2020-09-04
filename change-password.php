<?php
include_once('db/connect.php');
include('function.php');
$title = 'Change password';
include('views/header.php');
include('views/sidebar-a.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$error = [];

	if (preg_match('/^[\w\'.-]{4,32}$/', trim($_POST['currentPass']))) {
		$cp = mysqli_real_escape_string($con, trim($_POST['currentPass']));
	} else {
		$error[] = 'currentPass';
	}

	if (preg_match('/^[\w\'.-]{4,32}$/', trim($_POST['newPass']))) {
		if ($_POST['newPass'] === $_POST['confirmPass']) {
			$np = mysqli_real_escape_string($con, trim($_POST['newPass']));
		} else {
			$error[] = 'confirmPass';
		}
	} else {
		$error[] = 'newPass';
	}

	if (empty($error)) {
		$que = "SELECT * FROM users where user_id = {$_SESSION['uid']} AND pass = '{$cp}'";
		$res = resultQuery($que);
		if (mysqli_affected_rows($con) == 1){
		    $que = "UPDATE users SET pass = '{$np}' WHERE user_id = {$_SESSION['uid']}";
            $res = resultQuery($que);
			if (mysqli_affected_rows($con) == 1) {
			    $messages = "<p class='success'>Password has been changed</p>";
			} else {
			    $messages = "<p class='warning'>Password has not been changed! Please re-enter</p>";
            }
        } else {
		    $messages = "<p class='warning'>Current password is not correct</p>";
        }
    } else {
	    $messages = "<p class='warning'>Please fill all require fields</p>";
    }
}
?>
    <div id="content">
        <form method="post">
	        <?php echo (isset($messages)) ? $messages : ''; ?>
            <fieldset>
                <legend>Change password</legend>
				<?php
				if (!isset($error)) {
					templateInputPass('currentPass', 'Current Password');
					templateInputPass('newPass', 'New Password');
					templateInputPass('confirmPass', 'Confirm Password');
					templateInputSubmit('Change');
				} else {
					templateInputPass('currentPass', 'Current Password', $_POST['currentPass'], $error);
					templateInputPass('newPass', 'New Password', $_POST['newPass'], $error);
					templateInputPass('confirmPass', 'Confirm Password', $_POST['confirmPass'], $error);
					templateInputSubmit('Change');
				}
				?>
            </fieldset>
        </form>
    </div>
<?php
include('views/sidebar-b.php');
include('views/footer.php');
?>