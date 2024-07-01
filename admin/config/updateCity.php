<?php

$CityName = [];

$city = $_REQUEST['city'];

$_SESSION['city'] = $city;

$webpage_full_link_url = "https://" . $city . ".truewebservice.com/";

echo $webpage_full_link_url;