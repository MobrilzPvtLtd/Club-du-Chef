<?php
/**
 * Created by Vignesh.
 * User: Vignesh
 */

//database configuration
if (file_exists('config/info.php')) {
    include('config/info.php');
}

// status change method functionality
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

// date range filter functionality
if (isset($_GET["start_date"]) || isset($_GET["end_date"])) {

    $startDate = $_GET["start_date"];
    $endDate = $_GET["end_date"];

    function getAllBooking($startDate, $endDate) {
        global $conn;

        // Escape the input to prevent SQL injection
        $startDate = mysqli_real_escape_string($conn, $startDate);
        $endDate = mysqli_real_escape_string($conn, $endDate);

        $sql = "SELECT * FROM " . TBL . "bookings";

        if ($startDate && $endDate) {
            $sql .= " WHERE DATE(date_time) BETWEEN '$startDate' AND '$endDate'";
        }

        $sql .= " ORDER BY date_time ASC";

        // Execute the query and return the result set
        $rs = mysqli_query($conn, $sql);
        return $rs;
    }

    // Fetch all bookings and display them
    $si = 1;
    $bookingResults = getAllBooking($startDate, $endDate); 

    // Check if query returns results
    if ($bookingResults && mysqli_num_rows($bookingResults) > 0) {
        while ($bookingrow = mysqli_fetch_assoc($bookingResults)) {
            $booking_id = $bookingrow['booking_id'];
            $booking_type_id = $bookingrow['booking_type_id'];

            $date_time = $bookingrow['date_time'];
            $date = date('d-m-Y', strtotime($date_time));
            $time = date('g:i:s A', strtotime($date_time));

            $user_id = $bookingrow['user_id'];
            $user_row = getUser($user_id);

            // Initialize booking details based on booking type
            $event_row = $job_row = $expert_row = $product_row = $listing_row = $place_row = null;

            // Check for the booking type and fetch respective data
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
            ?>
            <tr>
                <td><?php echo $si; ?></td>
                <td><?php echo $user_row['first_name']; ?></td>
                <td><?php echo $user_row['email_id']; ?></td>
                <!-- <td><?php echo $user_row['mobile_number']; ?></td> -->
                <td><span><?php echo dateFormatconverter($date); ?></span></td>
                <td><?php echo $time; ?></td>
                <td><?php echo $bookingrow['booking_type']; ?></td>

                <?php
                // Output the relevant booking type name
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

                <td>
                    <form action="/status_update.php" method="POST">
                        <input type="hidden" value="<?php echo $booking_id ?>" name="booking_id">
                        <select name="status" class="form-select text-white 
                        <?php echo ($bookingrow['status'] == 'disapproved') ? 'bg-danger' : 
                            ($bookingrow['status'] == 'pending' ? 'bg-warning' : 'bg-success'); ?>" onchange="this.form.submit()">
                            <option value="pending" 
                                <?php echo ($bookingrow['status'] == 'pending') ? 'selected' : ''; ?>>
                                Pending
                            </option>
                            <option value="approved" 
                                <?php echo ($bookingrow['status'] == 'approved') ? 'selected' : ''; ?>>
                                Approved
                            </option>
                            <option value="disapproved" 
                                <?php echo ($bookingrow['status'] == 'disapproved') ? 'selected' : ''; ?>>
                                Disapproved
                            </option>
                        </select>
                    </form>
                </td>

                <td>
                    <a class="db-list-edit" href="admin-all-bookings-details.php?row=<?php echo $booking_id; ?>">View</a>
                </td>
            </tr>
            <?php
            $si++;
        }
    } else {
        echo "<tr><td colspan='9'>No bookings found for the selected date range.</td></tr>";
    }
}

