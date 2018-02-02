<?php
session_start();

if(isset($_SESSION['account_id']))
{
    session_unset();
}
header("Location: /iimages/");
exit;
