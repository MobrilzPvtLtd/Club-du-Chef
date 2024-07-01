<?php
$city = $_REQUEST['city'];

if (isset($_SESSION['city'])) {
    $_SESSION['city'] = $city;
    $cityCode = $city;
} else {

    $_SESSION['city'] = $city;

    $cityCode = 'www';
}


$webpage_full_link_url = "https://" . $cityCode . ".truewebservice.com/";

echo $webpage_full_link_url;