<?php
session_start();
include('function.php');
unset($_SESSION);
session_destroy();
redirectTo();
