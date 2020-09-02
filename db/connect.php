<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$con = mysqli_connect('127.0.0.1', 'dkmmysql', 'root', 'huy_izcms');

if (!$con) {
	include('createdb.php');
	echo "Database has just been created! Please reload the page to continue" . mysqli_connect_error($con);
} else {
	mysqli_set_charset($con, 'utf-8');
	return $con;
}
