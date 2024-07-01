<?php

if (session_status() === PHP_SESSION_NONE) {
session_name("city");
session_set_cookie_params(0, '/', '.truewebservice.com');
session_start();
}

$CityList['All Cities'] = 'www';
$CityList['Noida'] = 'noida';
$CityList['Delhi'] = 'delhi';
$CityList['Ghaziabad'] = 'ghaziabad';


if ($_SESSION['city']) {

$CurrentCity = $_SESSION['city'];
} else {

$CurrentCity = 'www';
}


foreach ($CityList as $City => $CitySlug) {


$City = strtolower(preg_replace('/\s*/', '', $City));

if ($CurrentCity == $City) {

    $DomainPrefix = $CitySlug;

    break;

} else {

    $DomainPrefix = 'www';

}

}

$FullHostname = $DomainPrefix . '.truewebservice.com';

//echo $_SERVER['HTTP_HOST'];


// Check if its diffent then redirect to that sub domian

$webpage_full_link_url = "https://" . $FullHostname.'/';

if ($FullHostname !== $_SERVER['HTTP_HOST']) {
header('Location: ' . $webpage_full_link_url);
// exit;
}