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

function get_page_by_id($pid){
    global $con;
    $que = "SELECT p.page_name, p.page_id, LEFT(p.content, 400) as content, ";
    $que .= " DATE_FORMAT(p.post_on, '%b %d %y') AS date, ";
    $que .= " CONCAT_WS(' ' , u.first_name, u.last_name) AS name, u.user_id ";
    $que .= " FROM pages AS p ";
    $que .= " INNER JOIN users AS u ";
    $que .= " USING (user_id) ";
    $que .= " WHERE p.cat_id = {$pid} ";
    $que .= " ORDER BY date LIMIT 0, 10";
    $res = mysqli_query($con, $que);
    confirm_query($res, $que);
    return $res;
}