<?php
/**
 * Created by Vignesh.
 * User: Vignesh
 */

//database configuration
if (file_exists('config/info.php')) {
    include('config/info.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $status = $_POST["status"];
    $booking_id = $_POST["booking_id"];
    
    $booking_qry = "UPDATE  " . TBL . "bookings SET
            status='" . $status . "',
            booking_cdt ='" . $curDate . "'
            where booking_id='" . $booking_id . "'";

    $res = mysqli_query($conn,$booking_qry);
    $LID = mysqli_insert_id($conn);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;

}

