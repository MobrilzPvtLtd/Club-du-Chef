<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (isset($_SESSION['city'])) {
    $cityCode = $_SESSION['city'];
} else {

    $cityCode = 'www';
}

$webpage_full_link_url = "https://" . $cityCode . ".truewebservice.com/";