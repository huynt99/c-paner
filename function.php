<?php

define('base', 'http://localhost:8080/PHPBasic/izcms/');

function redirect_to($page = 'index.php')
{
    $url = base . $page;
    header("Location: $url");
    die();
}

function confirm_query($res, $que)
{
    global $con;
    if (empty($res)) {
        die("Query: {$que} \n<br/>  Error: " . mysqli_error($con));
    }
}
