<?php

$CurrentCity = file_get_contents('https://ipapi.co/' . get_client_ip() . '/city/');

//echo $CurrentCity;
if(file_exists('admin/config/db-config.php'))
{
  include('admin/config/db-config.php');
}

$CityList = array();

if (!isset($conn) || !$conn) {
die('Database connection is not established.');
}

// Use the TBL constant
$sql = "SELECT * FROM " . TBL . "cities GROUP BY city_name ORDER BY city_id DESC";
$citys = mysqli_query($conn, $sql);

if (!$citys) {
die('Error: ' . mysqli_error($conn));
}

foreach ($citys as $city) {
$CityList[$city['city_name']] = $city['city_slug'];
}

// $CityList['Noida'] = 'noida';
// $CityList['New Delhi'] = 'newdelhi';
// $CityList['Ghaziabad'] = 'ghaziabad';
// $CityList['Delhi'] = 'delhi';

$CurrentCity = strtolower(preg_replace('/\s*/', '', $CurrentCity));

//echo $CurrentCity.'<br/>=============<br/>';

foreach ($CityList as $City => $CitySlug) {


    $City = strtolower(preg_replace('/\s*/', '', $City));

    if ($CurrentCity == $City) {

        $DomainPrefix = $CitySlug;

        break;

    } else {

        $DomainPrefix = 'www';

    }

}

// Now make full hostname name
//echo '<br/>=============<br/>';
$FullHostname = $DomainPrefix . '.truewebservice.com';

//echo $_SERVER['HTTP_HOST'];


// Check if its diffent then redirect to that sub domian

$webpage_full_link_url = "https://" . $FullHostname.'/';

if ($FullHostname !== $_SERVER['HTTP_HOST']) {
    header('Location: ' . $webpage_full_link_url);
    exit;
}




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