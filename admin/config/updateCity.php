<?php
$city = $_REQUEST['city'];

echo $city;

if (isset($_SESSION['city'])) {
    $_SESSION['city'] = $city;
} else {

    $_SESSION['city'] = $city;
}
?>