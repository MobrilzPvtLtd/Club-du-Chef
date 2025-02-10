<?php
// Initialize the necessary variables
$booking_type = isset($booking_type) ? $booking_type : null;

// Create a value set for each day
$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
$is_available = 1;
foreach ($days as $day) {
if (isset($_POST[$day]) && !empty($_POST[$day])) {
    $start_time = $_POST['start_time_' . $day];  
    $start_time_1 = $_POST['start_time_1_' . $day];  
    $start_time_2 = $_POST['start_time_2_' . $day];  
    $start_time_3 = $_POST['start_time_3_' . $day];  
    $end_time = $_POST['end_time_' . $day];  
    $end_time_1 = $_POST['end_time_1_' . $day];  
    $end_time_2 = $_POST['end_time_2_' . $day];  
    $end_time_3 = $_POST['end_time_3_' . $day];  

    $values[] = "('$listlastID', '$booking_type', '$day', '$is_available', '$start_time', '$end_time', '$start_time_1', '$end_time_1', '$start_time_2', '$end_time_2', '$start_time_3', '$end_time_3', '$curDate')";
}
}

if (!empty($values)) {
    $values_str = implode(', ', $values);

    $booking_availability_qry = "INSERT INTO " . TBL . "booking_availability 
    (booking_type_id, booking_type, day, is_available, start_time, end_time, start_time_1, end_time_1,start_time_2, end_time_2, start_time_3, end_time_3, created_at) 
    VALUES $values_str";

    $listing_res = mysqli_query($conn, $booking_availability_qry);
}
?>
