<?php
include('function.php');
include('db/connect.php');

$que = "UPDATE `users` SET active = NULL WHERE active = NULL AND email = 'vitchin@gmail.com';";
$res = resultQuery($que);
echo mysqli_affected_rows($con);