<?php
$city = $_REQUEST['city'];

echo $city;

if (!exit($_SESSION['city'])) {
    $_SESSION['city'] = $city;
} else {

    $_SESSION['city'] = $city;
}
?>