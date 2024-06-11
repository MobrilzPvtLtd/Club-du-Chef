<?php

$CurrentCity = file_get_contents('https://ipapi.co/' . get_client_ip() . '/city/');

echo $CurrentCity;

$CityList = array();

$CityList['Noida'] = 'noida';
$CityList['New Delhi'] = 'newdelhi';
$CityList['Ghaziabad'] = 'ghaziabad';

foreach ($CityList as $City => $CitySlug) {

    echo $City;

    if ($CurrentCity == $City) {

        $DomainPrefix = $CitySlug;

    } else {

        $DomainPrefix = 'www';

    }

}

// Now make full hostname name

echo $FullHostname = $DomainPrefix . '.truewebservice.com';

echo $_SERVER['HTTP_HOST'];

// Check if its diffent then redirect to that sub domian

$webpage_full_link_url = "https://www.truewebservice.com/";


function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}