<?php
if (file_exists('config/info.php')) {
    include('config/info.php');
}
$_SESSION['status_msg'] = $Zitiziti['PAYPAL_POINT_PAYMENT_FAILURE_MESSAGE'];

header('Location: buy-points');
exit;
?>