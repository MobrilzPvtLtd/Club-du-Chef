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

    if ($_POST["user_id"] != null) {
        $user_id = $_POST["user_id"];
    } else {
        header('Location: login.php');
        exit;
    }

    $booking_date = $_POST["booking_date"];
    $booking_time = $_POST["booking_time"];

    $booking_datetime = $booking_date . ' ' . $booking_time;
    $timestamp = strtotime($booking_datetime);
    $formatted_datetime = date('Y-m-d H:i:s', $timestamp);

    $booking_type = $_POST["booking_type"];
            
    $booking_qry = "INSERT INTO " . TBL . "bookings
					(user_id,date_time,booking_type, booking_cdt)
					VALUES ('$user_id', '$formatted_datetime', '$booking_type', '$curDate')";

    $res = mysqli_query($conn,$booking_qry);
    $LID = mysqli_insert_id($conn);

    $_SESSION['status_msg'] = "Booking has been created Successfully!!!";

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;

} else {

    header('Location: index');
    exit;
}

