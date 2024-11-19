<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name("city");
    if($_SERVER['SERVER_NAME'] == 'localhost') {
        session_set_cookie_params(0, '/', 'localhost');
    }else{
        session_set_cookie_params(0, '/', '.zitiziti.com');
    }
    session_start();
}

$city = $_REQUEST['city'];

$_SESSION['city'] = $city;

$Data = array();

if($_SERVER['SERVER_NAME'] == 'localhost') {
    $Data['url'] = "http://" . $_SESSION['city'] . "localhost/";
}else{
    $Data['url'] = "https://" . $_SESSION['city'] . ".zitiziti.com/";
}

$Data['cityname'] = $_SESSION['city'];

if ($_SESSION['city'] == $city) {
    $Data['status'] = 1;

} else {
    $Data['status'] = 0;

}


echo json_encode($Data);