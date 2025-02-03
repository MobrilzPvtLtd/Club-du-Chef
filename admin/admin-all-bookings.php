<?php
include "header.php";

function getAllbooking()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "bookings ORDER BY booking_id DESC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}
?>
<!-- START -->
<section>
    <div class="ad-com">
        <div class="ad-dash leftpadd">
            <div class="ud-cen">
                <div class="log-bor">&nbsp;</div>
                <span class="udb-inst">All Jobs</span>
                <div class="ud-cen-s2">
                    <h2>All Job Posts</h2>
                    <?php include "../page_level_message.php"; ?>
                    <div style="display: none" class="static-success-message log-suc"><p>Job(s) has been Permanently Deleted!!! Please wait for automatic page refresh!! </p></div>
                    <a href="job-create.php" class="db-tit-btn">Add new Job opening</a>
                    <table class="responsive-table bordered" id="pg-resu">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User Name</th>
                                <th>User Email</th>
                                <th>User Mobile</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Booking Type</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $si = 1;
                        foreach (getAllbooking() as $bookingrow) {
                            $booking_id = $bookingrow['booking_id'];
                            $date_time = $bookingrow['date_time'];

                            $date = date('d-m-Y', strtotime($date_time));
                            $time = date('g:i:s A', strtotime($date_time));

                            $user_id = $bookingrow['user_id'];

                            $user_row = getUser($user_id);

                            ?>
                            <tr>
                                <td><?php echo $si; ?></td>
                                <td><?php echo $user_row['first_name']; ?></td>
                                <td><?php echo $user_row['email_id']; ?></td>
                                <td><?php echo $user_row['mobile_number']; ?></td>
                                <td><span><?php echo dateFormatconverter($date); ?></span></td>
                                <td><?php echo $time; ?></td>
                                <td><?php echo $bookingrow['booking_type']; ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php
                            $si++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="ad-pgnat">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
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
<script>
    $(document).ready(function () {
        $('#pg-resu').DataTable({
            "columnDefs": [
                { "bSortable": false, "aTargets": [ 8 ] }
            ]
        });
    });
</script>
</body>

</html>