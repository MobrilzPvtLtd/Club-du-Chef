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


if (isset($_SESSION['city'])) {

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


// Full url with uri

$FullUri = $webpage_full_link_url.$_SERVER['REQUEST_URI'];

//URL fixing removing extra shlases

$FullUri = removeabunchofslashes($FullUri);

if ($FullHostname !== $_SERVER['HTTP_HOST']) {
header('Location: ' . $FullUri);
// exit;
}



function removeabunchofslashes($url){
    $explode = explode('://',$url);
    while(strpos($explode[1],'//'))
      $explode[1] = str_replace('//','/',$explode[1]);
    return implode('://',$explode);
  }