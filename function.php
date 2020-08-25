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

function beauty_text($text){
    return substr($text, 0, strrpos($text, ' '));
}

function validate_id($cid){
    if(isset($cid) && filter_var($cid, FILTER_VALIDATE_INT, array('min_range' => 1))){
        return $val = $cid;
    } else {
        return NULL;
    }
}