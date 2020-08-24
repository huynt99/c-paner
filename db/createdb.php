<?php
require_once('connect.php');

//categories
$categ = "  CREATE TABLE IF NOT EXISTS `categories`(
            `cat_id` int(11) PRIMARY KEY AUTO_INCREMENT ,
            `user_id` int(11) NOT NULL,
            `cate_name`varchar(100) NOT NULL,
            `position` TINYINT NOT NULL
    );
";
$con->query($categ);

$pages = "  CREATE TABLE IF NOT EXISTS `pages`(
            `page_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `user_id` INT(11) NOT NULL,
            `cat_id` INT(11) NOT NULL,
            `page_name` VARCHAR(150) NOT NULL,
            `content` TEXT NOT NULL,
            `position` TINYINT NOT NULL,
            `post_on` DATETIME NOT NULL,
            INDEX(`user_id`, `cat_id`, `position`, `post_on`)
    );
";
$con->query($pages);

$users = "  CREATE TABLE IF NOT EXISTS `users`(
            `user_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `first_name` VARCHAR(30) NOT NULL,
            `last_name` VARCHAR(30) NOT NULL,
            `email` VARCHAR(80) NOT NULL UNIQUE, 
            `pass` VARCHAR(32) NOT NULL,
            `website` VARCHAR(60),
            `yahoo` VARCHAR(80),
            `bio` TEXT,
            `avatar` VARCHAR(30),
            `user_lever` TINYINT NOT NULL,
            `active` VARCHAR(60),
            `registrantion_date` DATETIME NOT NULL,
            INDEX(`registrantion_date`)
    );
";
$con->query($users);

$comments = "   CREATE TABLE IF NOT EXISTS `comments`(
            `comment_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `page_id` INT(11) NOT NULL,
            `author` VARCHAR(80) NOT NULL,
            `email` VARCHAR(80) NOT NULL,
            `comment` TEXT NOT NULL,
            `comment_date` TIMESTAMP,
            INDEX(`page_id`)
    );
";
$con->query($comments);
