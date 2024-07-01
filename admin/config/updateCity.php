<?php

$city = $_REQUEST['city'];

$_SESSION['city'] = $city;

$Data = array();

$Data['url'] = "https://" . $_SESSION['city'] . ".truewebservice.com/";

$Data['cityname'] = $_SESSION['city'];

echo json_encode($Data);