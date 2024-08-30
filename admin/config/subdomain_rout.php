<?php
if(file_exists('admin/config/db-config.php'))
{
  include('admin/config/db-config.php');
}
if(file_exists('../admin/config/db-config.php'))
{
  include('../admin/config/db-config.php');
}

if (session_status() === PHP_SESSION_NONE) {
  session_name("city");
  if($_SERVER['SERVER_NAME'] == 'localhost') {
    session_set_cookie_params(0, '/', 'localhost');
  }else{
    session_set_cookie_params(0, '/', '.truewebservice.com');
  }
session_start();
}

if (!isset($conn) || !$conn) {
  die('Database connection is not established.');
}

// Use the TBL constant
$sql = "SELECT * FROM " . TBL . "cities GROUP BY city_name ORDER BY city_id DESC";
$citys = mysqli_query($conn, $sql);

if (!$citys) {
  die('Error: ' . mysqli_error($conn));
}

$CityList['All Cities'] = 'www';
foreach ($citys as $city) {
  $CityList[$city['city_name']] = $city['city_slug'];
}
// $CityList['Noida'] = 'noida';
// $CityList['Delhi'] = 'delhi';
// $CityList['Ghaziabad'] = 'ghaziabad';


if (isset($_SESSION['city'])) {
$CurrentCity = $_SESSION['city'];
} else {
$CurrentCity = 'www';
}

function normalizeCity($city) {
  $city = strtolower($city);
  
  $city = preg_replace('/\s+/', '', $city); 
  $city = str_replace('-', '', $city);
  
  return $city;
}

$CurrentCityNormalized = normalizeCity($CurrentCity);

$DomainPrefix = 'www';

foreach ($CityList as $City => $CitySlug) {
  // $City = strtolower(preg_replace('/\s*/', '', $City));
  $CityNormalized = normalizeCity($City);
  if ($CurrentCityNormalized == $CityNormalized) {
      $DomainPrefix = $CitySlug;
      break; 
  }
// if ($CurrentCity == $City) {
//     $DomainPrefix = $CitySlug;
//     break;
// } else {
//     $DomainPrefix = 'www';
// }
}

if($_SERVER['SERVER_NAME'] == 'localhost') {
  $FullHostname = 'localhost';
}else{
  $FullHostname = $DomainPrefix . '.truewebservice.com';
}

//echo $_SERVER['HTTP_HOST'];

// Check if its diffent then redirect to that sub domian

if($_SERVER['SERVER_NAME'] == 'localhost') {
  $webpage_full_link_url = "http://" . $FullHostname.'/';
}else{
  $webpage_full_link_url = "https://" . $FullHostname.'/';
}


// Full url with uri

$FullUri = $webpage_full_link_url.$_SERVER['REQUEST_URI'];

//URL fixing removing extra shlases

$FullUri = removeabunchofslashes($FullUri);


$_SESSION['webpage_full_link_url'] = $FullUri;

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
