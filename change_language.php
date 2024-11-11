<?php

if (file_exists('config/info.php')) {
    include('config/info.php');
}

session_start();

$_SESSION['lang'] = $_POST['lang'];

echo $_SESSION['lang'];
// print_r($_SESSION['lang']);
// die();
?>
