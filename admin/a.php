<?php
// include('../db/connect.php');
// include('../function.php');


$con = mysqli_connect('127.0.0.1', 'root', '', 'izcms');

if (!$con){
    echo "Database is not connect" . mysqli_connect_error($con);
} else {
    mysqli_set_charset($con, 'utf-8');
    var_dump($con);
}
