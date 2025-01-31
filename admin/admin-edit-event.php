<?php
include "header.php";
?>

<?php if($footer_row['admin_event_show'] !=1 || $admin_row['admin_event_options'] != 1){
    header("Location: profile.php");
}
?>
<!-- START -->
<section>
    <div class="ad-com">
        <div class="ad-dash leftpadd">
            <section class="login-reg">
                <div class="container">
                    <div class="row">
                        <div class="login-main add-list posr">
                            <div class="log-bor">&nbsp;</div>
                            <span class="udb-inst">Edit event</span>
                            <div class="log log-1">
                                <div class="login">
                                    <h4>Edit this Event</h4>
                                    <?php include "../page_level_message.php"; ?>
                                    <?php
                                        $event_codea = $_GET['row'];
                                        $events_a_row = getEvent($event_codea);

                                        // Fetch query of booking_availability
                                        $check_query = "SELECT * FROM " . TBL . "booking_availability WHERE event_id = '{$events_a_row['event_id']}' AND is_available = 1";
                                        $availability_day_result = mysqli_query($conn, $check_query);

                                        $availability_days = [];
                                        while ($availability = mysqli_fetch_assoc($availability_day_result)) {
                                            $availability_days[$availability['day']] = $availability;
                                        }
                                    ?>
                                    <form action="update_event.php" class="event_edit_form" id="event_edit_form" name="event_edit_form"
                                          method="post" enctype="multipart/form-data">
                                        <input type="hidden" id="event_id" value="<?php echo $events_a_row['event_id']; ?>"
                                               name="event_id" class="validate">
                                        <input type="hidden" id="event_image_old"
                                               value="<?php echo $events_a_row['event_image']; ?>" name="event_image_old"
                                               class="validate">
                                        <ul>
                                            <li>
                                                <!--FILED START-->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <select name="user_id" required="required" class="form-control" id="user_id">
                                                                <option value="">Choose a user</option>
                                                                <?php
                                                                foreach (getAllUser() as $row) {
                                                                    ?>
                                                                    <option <?php if($events_a_row['user_id']== $row['user_id']){ echo "selected"; } ?>
                                                                        value="<?php echo $row['user_id']; ?>"><?php echo $row['first_name']; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->

                                                <!-- BOOKING SYSTEM START -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="chbox">
                                                            <input type="checkbox" name="booking" id="booking" <?php echo ($events_a_row['is_booking'] == 1 || $events_a_row['booking_url'] != '') ? 'checked' : ''; ?>>
                                                            <label for="booking">Booking System</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" id="booking-details" style="display: <?php echo ($events_a_row['is_booking'] == 1 || $events_a_row['booking_url'] != '') ? 'block' : 'none'; ?>;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="1" name="is_booking" id="is_booking" <?php echo $events_a_row['is_booking'] == 1 ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="is_booking">Use inbuilt booking system</label>
                                                    </div>

                                                    <!-- Days fieilds  -->
                                                    <div class="form-group mt-2" id="booking_days" style="display: <?php echo ($events_a_row['is_booking'] == 1) ? 'block' : 'none'; ?>;">
                                                        
                                                    <?php
                                                        $days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                                        
                                                        foreach ($days_of_week as $day) {
                                                            $is_checked = isset($availability_days[$day]) ? 'checked' : '';
                                                            $start_time = isset($availability_days[$day]) ? $availability_days[$day]['start_time'] : '';
                                                            $end_time = isset($availability_days[$day]) ? $availability_days[$day]['end_time'] : '';
                                                    ?>
                                                        
                                                        <div class="chbox">
                                                            <input type="checkbox" name="<?php echo strtolower($day); ?>" id="booking_<?php echo strtolower($day); ?>" value="<?php echo $day; ?>" <?php echo $is_checked; ?> style="height: 0px;">
                                                            <label for="booking_<?php echo strtolower($day); ?>"><?php echo $day; ?></label>

                                                            <div class="row <?php echo strtolower($day); ?>_time" style="display: <?php echo $is_checked ? 'block' : 'none'; ?>;">
                                                                <div class="form-group col-md-4 serex-date">
                                                                    <input type="time" class="form-control" name="start_time_<?php echo strtolower($day); ?>" value="<?php echo $start_time; ?>">
                                                                </div>
                                                                <div class="form-group col-md-4 serex-date">
                                                                    <input type="time" class="form-control" name="end_time_<?php echo strtolower($day); ?>" value="<?php echo $end_time; ?>">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php } ?>
                                                    </div>

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="0" name="is_booking" id="is_booking_url" <?php echo $events_a_row['is_booking'] == 0 ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="is_booking_url">Use your own booking system</label>
                                                    </div>

                                                    <div class="form-group mt-2" id="booking_url_group" style="display: <?php echo ($events_a_row['booking_url']) ? 'block' : 'none'; ?>;">
                                                        <input type="text" name="booking_url" id="booking_url" class="form-control" value="<?php echo $events_a_row['booking_url']; ?>" placeholder="Enter your booking system url...">
                                                    </div>
                                                </div>
                                                <!-- BOOKING SYSTEM END -->
                                                    
                                                <!--FILED START-->
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="text" name="event_name" required="required" class="form-control"
                                                                   value="<?php echo $events_a_row['event_name']; ?>" placeholder="Event name *">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->
                                                <!--FILED START-->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="text" name="event_address" required="required" class="form-control" id="event_address"
                                                                   value="<?php echo $events_a_row['event_address']; ?>"  placeholder="Address *">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->
                                                <!--FILED START-->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <select name="category_id"
                                                                    id="category_id" class="chosen-select form-control">
                                                                <option value="">Select Category</option>
                                                                <?php
                                                                foreach (getAllEventCategories() as $categories_row) {
                                                                    ?>
                                                                    <option <?php if ($events_a_row['category_id'] == $categories_row['category_id']) {
                                                                        echo "selected";
                                                                    } ?>
                                                                        value="<?php echo $categories_row['category_id']; ?>"><?php echo $categories_row['category_name']; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->
                                                <!-- <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <select onChange="geteventCities(this.value);" name="country_id" required="required"
                                                                    class="chosen-select form-control">
                                                                <option value=""><?php echo "Select your Country"; ?></option>
                                                                <?php
                                                                //Countries Query
                                                                $admin_countries = $footer_row['admin_countries'];
                                                                $catArray = explode(',', $admin_countries);
                                                                foreach ($catArray as $cat_Array) {

                                                                    foreach (getMultipleCountry($cat_Array) as $countries_row) {
                                                                        ?>
                                                                        <option <?php if ($events_a_row['country_id'] == $countries_row['country_id']) {
                                                                            echo "selected";
                                                                        } ?>
                                                                                value="<?php echo $countries_row['country_id']; ?>"><?php echo $countries_row['country_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <!--FILED END-->

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <select data-placeholder="<?php echo "Select Your City"; ?>" name="city_slug[]" id="city_slug" required="required" class="chosen-select form-control">
                                                                <?php
                                                                foreach (getAllCities() as $city) {
                                                                    if (strtolower($city['city_name']) == 'www') {
                                                                        continue;
                                                                    }
                                                                    ?>
                                                                   <option <?php echo in_array($city['city_slug'], (array)json_decode($events_a_row['city_slug'], true)) ? 'selected' : '' ?>
                                                                        value="<?php echo $city['city_slug']; ?>">
                                                                        <?php echo $city['city_name']; ?>
                                                                    </option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED START-->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                            $timestamp = strtotime($events_a_row['event_start_date']);
                                                            $event_start_date = date('m/d/Y', $timestamp);
                                                            ?>
                                                            <input type="text" id="event_start_date" name="event_start_date" required="required" class="form-control"
                                                                   value="<?php echo $event_start_date; ?>" placeholder="Date *">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="event_time" required="required" class="form-control"
                                                                   value="<?php echo $events_a_row['event_time']; ?>" placeholder="Time *">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->
                                                <!--FILED START-->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <textarea class="form-control" required="required" id="event_description" name="event_description"
                                                                      placeholder="Event details"><?php echo $events_a_row['event_description']?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->
                                                <!--FILED START-->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <textarea class="form-control" name="event_map"
                                                                      placeholder="Google map location"><?php echo $events_a_row['event_map']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->
                                                <!--FILED START-->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Choose banner image</label>
                                                            <input type="file" name="event_image" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->
                                                <!--FILED START-->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="event_contact_name" required="required" class="form-control"
                                                                   value="<?php echo $events_a_row['event_contact_name']; ?>" placeholder="Contact person *">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="event_mobile" required="required" class="form-control"
                                                                   value="<?php echo $events_a_row['event_mobile']; ?>" placeholder="Contact phone number *">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->

                                                <!--FILED START-->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="email" name="event_email" required="required" class="form-control"
                                                                   value="<?php echo $events_a_row['event_email']; ?>" placeholder="Contact Email Id *">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="event_website" class="form-control"
                                                                   value="<?php echo $events_a_row['event_website']; ?>" placeholder="Event Website">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->

                                                <!--FILED START-->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div>
                                                            <div class="chbox">
                                                                <input type="checkbox" id="isenquiry" name="isenquiry" <?php if($events_a_row['isenquiry'] == 1){ ?> checked="" <?php }?>>
                                                                <label for="isenquiry">Enquiry or Registration form
                                                                    enable</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->
                                            </li>
                                        </ul>
                                        <!--FILED START-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" name="event_submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                        <!--FILED END-->
                                    </form>
                                    <div class="col-md-12">
                                        <a href="profile.php" class="skip">Go to user dashboard
                                            >></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

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
<script src="js/admin-custom.js"></script> 
<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script src="../js/select-opt.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('event_description');
</script>
<script>
    $(document).ready(function() {
        // Show or hide the booking details when the checkbox is toggled

        $("#booking").change(function() {
            if ($(this).is(':checked')) {
                $("#booking-details").show();
            } else {
                $("#booking-details").hide();
                $("#booking_url_group").hide();
                $("#booking_url").val('');
            }
        });

        // Clear the booking URL when the inbuilt booking system is selected
        $("#is_booking").change(function() {
            if ($(this).is(':checked')) {
                $("#booking_days").show();
                $("#booking_url").val('');
                $("#booking_url_group").hide();
            }
        });

        // Monday checkbox event handler
        $('#booking_monday').change(function() {
            if ($(this).is(':checked')) {
                $(".monday_time").show();
            } else {
                $(".monday_time").hide();
            }
        });

        // Tuesday checkbox event handler
        $('#booking_tuesday').change(function() {
            if ($(this).is(':checked')) {
                $(".tuesday_time").show();
            } else {
                $(".tuesday_time").hide();
            }
        });

        // Wednesday checkbox event handler
        $('#booking_wednesday').change(function() {
            if ($(this).is(':checked')) {
                $(".wednesday_time").show();
            } else {
                $(".wednesday_time").hide();
            }
        });

        // Thursday checkbox event handler
        $('#booking_thursday').change(function() {
            if ($(this).is(':checked')) {
                $(".thursday_time").show();
            } else {
                $(".thursday_time").hide();
            }
        });

        // Friday checkbox event handler
        $('#booking_friday').change(function() {
            if ($(this).is(':checked')) {
                $(".friday_time").show();
            } else {
                $(".friday_time").hide();
            }
        });

        // Saturday checkbox event handler
        $('#booking_saturday').change(function() {
            if ($(this).is(':checked')) {
                $(".saturday_time").show();
            } else {
                $(".saturday_time").hide();
            }
        });

        // Sunday checkbox event handler
        $('#booking_sunday').change(function() {
            if ($(this).is(':checked')) {
                $(".sunday_time").show();
            } else {
                $(".sunday_time").hide();
            }
        });

        // Show/hide the booking URL input based on the radio button selection
        $("#is_booking_url").change(function() {
            if ($(this).is(':checked')) {
                // Show the booking URL group and hide the day-specific booking options
                $("#booking_url_group").show();
                $("#booking_days").hide();  // Hides the entire booking days section

                // Hide each day's checkbox and clear their checked state
                $(".monday_time, .tuesday_time, .wednesday_time, .thursday_time, .friday_time, .saturday_time, .sunday_time").hide();
                
                $("#booking_monday, #booking_tuesday, #booking_wednesday, #booking_thursday, #booking_friday, #booking_saturday, #booking_sunday").prop("checked", false);
            } else {
                // Hide the booking URL group when unchecked
                $("#booking_url_group").hide();
                $("#booking_url").val('');  // Clear the booking URL input value
            }
        });
    });

    function geteventCities(val) {
        $.ajax({
            type: "POST",
            url: "../city_process.php",
            data: 'country_id=' + val,
            success: function (data) {
                $("#city_id").html(data);
                $('#city_id').trigger("chosen:updated");
            }
        });
    }
</script>
<?php if ($footer_row['admin_google_paid_geo_location'] == 1) { ?>
<script
      src="https://maps.googleapis.com/maps/api/js?key=<?php echo $footer_row['admin_geo_map_api']; ?>&callback=initAutocomplete&libraries=places&v=weekly"
      defer
    ></script>
    <script src="../js/google-geo-location-event-add.js">
     </script>
     <?php } ?>
</body>

</html>