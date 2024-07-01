<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$CityName['www'] = 'All Cities';
$CityName['noida'] = 'Noida';
$CityName['delhi'] = 'Delhi';
$CityName['ghaziabad'] = 'Ghaziabad';


if (isset($_SESSION['city'])) {
    $cityCode = $_SESSION['city'];
} else {

    $cityCode = 'www';
}

$webpage_full_link_url = "https://" . $cityCode . ".truewebservice.com/";