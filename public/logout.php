<?php
session_start();

require_once  '../includes/init.php';

$myLogout = new Logout();

$myLogout->logoutUser();