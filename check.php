<?php
include('db/connect.php');
include('function.php');

if (isset($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
	$em = mysqli_real_escape_string($con, trim($_GET['email']));

	$que = "SELECT user_id FROM users WhERE email = '{$em}'";
	$res = resultQuery($que);
	if (mysqli_num_rows($res) == 1) {
		echo 'yes';
	} else {
		echo 'no';
	}
}
