<?php
include "header.php";

if (file_exists('config/user_authentication.php')) {
    include('config/user_authentication.php');
}

if (file_exists('config/listing_page_authentication.php')) {
    include('config/listing_page_authentication.php');
}

include "dashboard_left_pane.php";

function getAllbooking()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "bookings ORDER BY booking_id DESC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}
?>

    <!--CENTER SECTION-->
    <div class="ud-main">
   <div class="ud-main-inn ud-no-rhs">
    <div class="ud-cen">
        <div class="log-bor">&nbsp;</div>
        <span class="udb-inst"><?php echo $Zitiziti['LEADS']; ?></span>
        <?php include('config/user_activation_checker.php'); ?>
        <div class="ud-cen-s2">
            <h2><?php echo $Zitiziti['ENQUIRY_DETAILS']; ?></h2>
            <?php include "page_level_message.php"; ?>
            <table class="responsive-table bordered">
                <thead>
                <tr>
                    <tr>
                        <th>No</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>User Mobile</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Booking Type</th>
                        <th>Booking Type Name</th>
                    </tr>
                </tr>
                </thead>
                <tbody>

                <?php
                    $si = 1;
                    $session_user_id = $_SESSION['user_id'];

                    foreach (getAllbooking() as $bookingrow) {
                        $booking_id = $bookingrow['booking_id'];
                        $booking_type_id = $bookingrow['booking_type_id'];

                        $date_time = $bookingrow['date_time'];
                        $date = date('d-m-Y', strtotime($date_time));
                        $time = date('g:i:s A', strtotime($date_time));
                    
                        $user_id = $bookingrow['user_id'];
                        $user_row = getUser($user_id);
                    
                        $event_row = $job_row = $expert_row = $product_row = $listing_row = $place_row = null;
                    
                        if ($bookingrow['booking_type'] == 'event') {
                            $event_row = getEvent($booking_type_id);
                        } elseif ($bookingrow['booking_type'] == 'job') {
                            $job_row = getIdJob($booking_type_id); 
                        } elseif ($bookingrow['booking_type'] == 'service_expert') {
                            $expert_row = getIdExpert($booking_type_id); 
                        } elseif ($bookingrow['booking_type'] == 'product') {
                            $product_row = getIdProduct($booking_type_id); 
                        } elseif ($bookingrow['booking_type'] == 'listing') {
                            $listing_row = getIdListing($booking_type_id); 
                        } elseif ($bookingrow['booking_type'] == 'place') {
                            $place_row = getIdPlaces($booking_type_id); 
                        }
                        
                        if ($bookingrow['seller_id'] == $session_user_id) {
                            ?>
                            <tr>
                                <td><?php echo $si; ?></td>
                                <td><?php echo $user_row['first_name']; ?></td>
                                <td><?php echo $user_row['email_id']; ?></td>
                                <td><?php echo $user_row['mobile_number']; ?></td>
                                <td><span><?php echo dateFormatconverter($date); ?></span></td>
                                <td><?php echo $time; ?></td>
                                <td><?php echo $bookingrow['booking_type']; ?></td>
                    
                                <?php
                                if ($event_row) {
                                    ?>
                                    <td><?php echo $event_row['event_name']; ?></td>
                                    <?php
                                } elseif ($job_row) {
                                    ?>
                                    <td><?php echo $job_row['job_title']; ?></td>
                                    <?php
                                } elseif ($expert_row) {
                                    ?>
                                    <td><?php echo $expert_row['profile_name']; ?></td>
                                    <?php
                                } elseif ($product_row) {
                                    ?>
                                    <td><?php echo $product_row['product_name']; ?></td>
                                    <?php
                                } elseif ($listing_row) {
                                    ?>
                                    <td><?php echo $listing_row['listing_name']; ?></td>
                                    <?php
                                } elseif ($place_row) {
                                    ?>
                                    <td><?php echo $place_row['place_name']; ?></td>
                                    <?php
                                } else {
                                    ?>
                                    <td><?php echo 'Unknown'; ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                        }
                    
                        $si++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
if (isset($_GET['ledname_1'])) {
    trashFolderNew($_GET['ledname_1']);
}
include "dashboard_right_pane.php";
?>