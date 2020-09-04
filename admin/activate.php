<?php
include('header-admin.php');
include('sidebar-a.php');

if (isset($_GET['k']) && isset($_GET['em'])) {
	$key = validateId($_GET['k']);
	$email = mysqli_real_escape_string($con, trim($_GET['em']));
	if ($key) {
		$que = "UPDATE `users` SET active = NULL WHERE active = {$key} AND email = '{$email}';";
		$res = resultQuery($que);
		if (mysqli_affected_rows($con) == 1) {
			echo "<p class='success'>Your acccount has been activated successfully.<a href='../login.php'>Login</a>now.</p>";
		} else {
			echo "<p class='warning'>Your acccount could not be activated. Please try again!</p>";
		}
	}
} else {
	redirectTo('../register.php');
}

include('sidebar-b.php');
include('footer-admin.php');