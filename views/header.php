<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
?>
<!DOCTYPE html>
<html style="background-color: #e2e2e2">

<head>
    <meta charset='UTF-8'/>

    <title><?php echo "izCMS - " . ((isset($title)) ? $title : ''); ?></title>

    <link rel='stylesheet' href='assets/style.css'/>
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
            <li><a href='contact.php'>Contact us</a></li>
        </ul>

        <p class="greeting">Xin chào <?php echo isset($_SESSION['fname']) ? $_SESSION['fname'] : 'bạn hiền!'; ?></p>
    </div><!-- end navigation-->