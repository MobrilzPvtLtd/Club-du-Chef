<?php
// Initialize the necessary variables
$booking_type = isset($booking_type) ? $booking_type : null;

 // Create a value set for each day
 $update_queries = [];
 $insert_queries = [];
 $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

 foreach ($days as $day) {
     $is_available = isset($_POST[$day]) && !empty($_POST[$day]) ? 1 : 0;

     if ($is_available == 1) {  
        $start_time = $_POST['start_time_' . $day];  
        $end_time = $_POST['end_time_' . $day];  
        $start_time_2 = $_POST['start_time_2_' . $day];  
        $end_time_2 = $_POST['end_time_2_' . $day];  
 
         // Check if the record for the day already exists
         $check_query = "SELECT * FROM " . TBL . "booking_availability WHERE booking_type_id = '$booking_type_id' AND day = '$day' AND booking_type = '$booking_type'";
         $result = mysqli_query($conn, $check_query);
 
         if (mysqli_num_rows($result) > 0) {
             // If the day already exists, update the availability
             $update_queries[] = "UPDATE " . TBL . "booking_availability SET start_time = '$start_time', end_time = '$end_time', start_time_2 = '$start_time_2', end_time_2 = '$end_time_2', is_available = 1, created_at = '$curDate' WHERE booking_type_id = '$booking_type_id' AND day = '$day' AND booking_type = '$booking_type'";
         } else {
             // If the day does not exist, insert a new record
             $insert_queries[] = "INSERT INTO " . TBL . "booking_availability (booking_type_id, day, booking_type,start_time, end_time, start_time_2, end_time_2, is_available, created_at) VALUES ('$booking_type_id', '$day', '$booking_type', '$start_time', '$end_time', '$start_time_2', '$end_time_2', 1, '$curDate')";
         }
     } else {
         // If the checkbox is not checked, set is_available to 0
         $update_queries[] = "UPDATE " . TBL . "booking_availability SET is_available = 0 WHERE booking_type_id = '$booking_type_id' AND day = '$day' AND booking_type = '$booking_type'";
     }
 }

 // Execute all update queries
 foreach ($update_queries as $query) {
     mysqli_query($conn, $query);
 }

 // Execute all insert queries
 foreach ($insert_queries as $query) {
     mysqli_query($conn, $query);
 }
?>
