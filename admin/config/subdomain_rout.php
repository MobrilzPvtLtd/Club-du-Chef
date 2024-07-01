<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$CityList['All Cities'] = 'www';
$CityList['Noida'] = 'noida';
$CityList['Delhi'] = 'delhi';
$CityList['Ghaziabad'] = 'ghaziabad';


if (isset($_SESSION['city'])) {
    $cityCode = $_SESSION['city'];
} else {

    $cityCode = 'www';
}

$webpage_full_link_url = "https://" . $cityCode . ".truewebservice.com/";