<?php
$city = $_REQUEST['city'];

if (isset($_SESSION['city'])) {
    $_SESSION['city'] = $city;
} else {

    $_SESSION['city'] = $city;
}


echo $webpage_full_link_url;