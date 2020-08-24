<?php
    $con = mysqli_connect('localhost', 'root', '', 'izcms');

    if (!$con){
        echo "Database is not connect" . mysqli_connect_error($con);
    } else {
        mysqli_set_charset($con, 'utf-8');
        return $con;
    }