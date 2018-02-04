<?php
/*
$tab = array('a','b','c');

//unset($tab[0]);
array_splice($tab,0,1);

print_r($tab);
*/

session_start();

echo $_SESSION['winner'];

unset($_SESSION['winner']);

unset($_SESSION['images_id']);

echo $_SESSION['winner'];
