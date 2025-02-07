<?php
include "header.php";

$booking_id = $_GET['row'];
$booking_details = mysqli_query($conn, "SELECT * FROM  " . TBL . "bookings where booking_id='" . $booking_id . "'");
$booking_details_row = mysqli_fetch_array($booking_details);
$booking_type_id = $booking_details_row['booking_type_id'];

$user_row = getUser($booking_details_row['user_id']);

$seller_row = getUser($booking_details_row['seller_id']);

$date_time = $booking_details_row['date_time'];
$date = date('d-m-Y', strtotime($date_time));
$time = date('g:i:s A', strtotime($date_time));

if ($booking_details_row['booking_type'] == 'event') {
    $event_row = getEvent($booking_type_id);
} elseif ($booking_details_row['booking_type'] == 'job') {
    $job_row = getIdJob($booking_type_id); 
} elseif ($booking_details_row['booking_type'] == 'service_expert') {
    $expert_row = getIdExpert($booking_type_id); 
} elseif ($booking_details_row['booking_type'] == 'product') {
    $product_row = getIdProduct($booking_type_id); 
} elseif ($booking_details_row['booking_type'] == 'listing') {
    $listing_row = getIdListing($booking_type_id); 
} elseif ($booking_details_row['booking_type'] == 'place') {
    $place_row = getIdPlaces($booking_type_id); 
}
?>
<section>
    <div class="ad-com">
        <div class="ad-dash leftpadd">
            <div class="ud-cen">
                <div class="log-bor">&nbsp;</div>
                <span class="udb-inst">Booking Enquiry Details</span>
                <div class="ud-cen-s2">
                    <h2>Booking Enquiry Details</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Seller Name</th>
                                <td><?PHP echo $seller_row['first_name'] ?></td>
                            </tr>
                            <tr>
                                <th scope="row">City</th>
                                <td><?PHP echo $booking_details_row['city'] ?></td>
                            </tr>
                            <tr>
                                <th scope="row">User Name</th>
                                <td><?PHP echo $user_row['first_name'] ?></td>
                            </tr>
                            <tr>
                                <th scope="row">User Email</th>
                                <td><?PHP echo $user_row['email_id'] ?></td>
                            </tr>
                            <tr>
                                <th scope="row">User Mobile</th>
                                <td><?PHP echo $user_row['mobile_number'] ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Date</th>
                                <td><?PHP echo dateFormatconverter($date); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Time</th>
                                <td><?PHP echo $time; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Booking Type</th>
                                <td><?PHP echo $booking_details_row['booking_type']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Booking Type Name</th>
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
                            <tr>
                                <th scope="row">Status</th>
                                <td>
                                    <p style="color: white; border:none;" class="btn btn-sm <?php echo ($booking_details_row['status'] == 'disapproved') ? 'bg-danger' : 'bg-success'; ?>">
                                        <?php echo ($booking_details_row['status'] == 'disapproved') ? 'Disapproved' : 'Approved'; ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Comment</th>
                                <td><?PHP echo $booking_details_row['comment']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- END -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="../js/jquery.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<script src="../js/select-opt.js"></script>
<script src="../js/select-opt.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="js/admin-custom.js"></script>
</body>

</html>