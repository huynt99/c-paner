<?php
    $con = mysqli_connect('localhost', 'root', '', 'huy_izcms');

    if (!$con){
        include('createdb.php');
        echo "Database has just been created! Please reload the page to continue" . mysqli_connect_error($con);
    } else {
        mysqli_set_charset($con, 'utf-8');
        return $con;
    }