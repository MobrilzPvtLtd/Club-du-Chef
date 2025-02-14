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

    $sql = "SELECT * FROM " . TBL . "bookings ORDER BY date_time ASC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}
?>
<style>
    .form-select {
        /* padding: 5px; */
        border-radius: 5px;
        border: none;
        width: 142px;
    }

    .form-select option {
        background-color: white;
        color: #000;
    }

</style>

    <!--CENTER SECTION-->
    <div class="ud-main">
   <div class="ud-main-inn ud-no-rhs">
    <div class="ud-cen">
        <div class="log-bor">&nbsp;</div>
        <span class="udb-inst"><?php echo $Zitiziti['LEADS']; ?></span>
        <?php include('config/user_activation_checker.php'); ?>
        <div class="ud-cen-s2">
            <h2><?php echo $Zitiziti['ENQUIRY_DETAILS']; ?></h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" name="datefilter" class="form-control" placeholder="Date filter">
                    </div>
                </div>
            </div>
            <table class="responsive-table bordered" id="myTable">
                <thead>
                <tr>
                    <tr>
                        <th>No</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <!-- <th>User Mobile</th> -->
                        <th>Date</th>
                        <th>Time</th>
                        <th>Booking Type</th>
                        <th>Booking Type Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tr>
                </thead>
                <tbody class="booking-table-body">
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
                                    <!-- <td><?php echo $user_row['mobile_number']; ?></td> -->
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
                                    <td>
                                        <form action="/status_update.php" method="POST">
                                            <input type="hidden" value="<?php echo $booking_id ?>" name="booking_id">
                                            <select name="status" class="form-select text-white" style="background-color: <?php echo ($bookingrow['status'] == 'disapproved') ? '#dc3545' : ($bookingrow['status'] == 'pending' ? '#FEBE10' : '#28a745'); ?>"
                                                onchange="this.form.submit()">
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

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize the date range picker
        $('input[name="datefilter"]').daterangepicker({
            timePicker: true,
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
            locale: {
                format: 'DD/MMM/YYYY'
            }
        });

        // Handle when the date range is applied
        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            var startDate = picker.startDate.format('YYYY-MM-DD');
            var endDate = picker.endDate.format('YYYY-MM-DD');

            // Trigger the AJAX request with the selected date range
            filterDateRangeStatus(startDate, endDate);
        });

        // Trigger filtering when the date range is selected
        function filterDateRangeStatus(startDate, endDate) {
            $.ajax({
                url: 'status_update.php',
                method: 'GET',
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    console.log(response);
                    
                    $('.booking-table-body').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching filtered data: ', error);
                }
            });
        }
    });
</script>