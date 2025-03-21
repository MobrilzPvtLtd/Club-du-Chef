<?php
/**
 * Created by Vignesh.
 * User: Vignesh
 */

//database configuration
if (file_exists('config/info.php')) {
    include('config/info.php');
}
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include "recaptcha.php";

    if (intval($responseKeys["success"]) !== 1) {

        echo '<div style="color: red;font-size: 20px;margin: 10px;">' . $Zitiziti['PLEASE_COMPLETE_CAPTCHA_VERIFICATION'] . '</div>';

    } else {
        
        if ($_POST["user_id"] != null) {
            $user_id = $_POST["user_id"];
        } else {
            header('Location: login.php');
            exit;
        }
    
        $booking_date = $_POST["booking_date"];
        $booking_time = $_POST["booking_time"];
        $comment = $_POST["comment"];
        $city = $_POST["city"];
    
        $booking_datetime = $booking_date . ' ' . $booking_time;
        $timestamp = strtotime($booking_datetime);
        $formatted_datetime = date('Y-m-d H:i:s', $timestamp);
    
        $booking_type = $_POST["booking_type"];
        $booking_type_id = $_POST["booking_type_id"];
        $seller_id = $_POST["seller_id"];
                
        $booking_qry = "INSERT INTO " . TBL . "bookings
                        (user_id,date_time,booking_type,booking_type_id,seller_id, comment,city, booking_cdt)
                        VALUES ('$user_id', '$formatted_datetime', '$booking_type', '$booking_type_id','$seller_id','$comment', '$city', '$curDate')";
    
        $res = mysqli_query($conn,$booking_qry);
        $LID = mysqli_insert_id($conn);
    
        $_SESSION['status_msg'] = "Booking has been created Successfully!!!";
    
        // header('Location: ' . $_SERVER['HTTP_REFERER']);
        header('Location: thank_you.php');
        exit;
    }

} else {

    header('Location: index');
    exit;
}

