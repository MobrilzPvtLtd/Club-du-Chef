<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!exit($_SESSION['city'])) {
    $cityCode = 'www';
} else {

    $cityCode = $_SESSION['city'];
}

$webpage_full_link_url = "https://".$cityCode.".truewebservice.com/";