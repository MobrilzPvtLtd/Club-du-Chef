<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name("city");
    session_set_cookie_params(0, '/', '.truewebservice.com');
    session_start();
}

$city = $_REQUEST['city'];

$_SESSION['city'] = $city;

$Data = array();

$Data['url'] = "https://" . $_SESSION['city'] . ".truewebservice.com/";

$Data['cityname'] = $_SESSION['city'];

if ($_SESSION['city'] == $city) {
    $Data['status'] = 1;

} else {
    $Data['status'] = 0;

}


echo json_encode($Data);