<?php
include('../db/connect.php');
include('../function.php');

if (isset($_POST['cmtId']) && filter_var($_POST['cmtId'], FILTER_VALIDATE_INT)) {
	$cmtId = mysqli_real_escape_string($con, trim($_POST['cmtId']));
	$que = "DELETE FROM `comments` WHERE comment_id = {$cmtId} LIMIT 1;";
	$res = resultQuery($que);
}
