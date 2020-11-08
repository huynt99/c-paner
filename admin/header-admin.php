<?php
session_start();
include_once('../db/connect.php');
include_once('../function.php');
adminAccess();
?>
<!DOCTYPE html>
<html style="background-color: #e2e2e2">

<head>
    <meta charset='UTF-8'/>

    <title></title>

    <link rel='stylesheet' href='style.css'/>
</head>

<body>
<div id="container">
    <div id="header">
        <h1><a href="">izCMS</a></h1>
        <p class="slogan">The iz Content Management System</p>
    </div>
    <div id="navigation">
        <ul>
            <li><a href='#'>Home</a></li>
            <li><a href='#'>About</a></li>
            <li><a href='#'>Services</a></li>
            <li><a href='#!'>Contact us</a></li>
        </ul>

        <p class="greeting">Xin chào <?php echo isset($_SESSION['fname']) ? $_SESSION['fname'] : 'bạn hiền!'; ?></p>
    </div><!-- end navigation-->