<?php
include "header.php";
?>

<?php if($footer_row['admin_job_show'] != 1 || $admin_row['admin_jobs_options'] != 1){
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
                        <div class="login-main add-list add-ncate">
                            <div class="log-bor">&nbsp;</div>
                            <span class="udb-inst">Add new Job</span>
                            <div class="log log-1">
                                <div class="login">
                                    <h4>Add New Job</h4>
                                    <?php include "../page_level_message.php"; ?>
                                    <form action="insert_job.php" class="job_form" id="job_form" name="job_form"
                                          method="post" enctype="multipart/form-data">
                                        <div class="inn">
                                            <ul>
                                                <li>
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
                                                                        <option value="<?php echo $city['city_slug']; ?>">
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
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <select name="user_code" id="user_code" class="form-control chosen-select"
                                                                        required="required">
                                                                    <option value="" disabled selected>User Name</option>
                                                                    <?php
                                                                    foreach (getAllUser() as $ad_users_row) {
                                                                        ?>
                                                                        <option
                                                                            value="<?php echo $ad_users_row['user_code']; ?>"><?php echo $ad_users_row['first_name']; ?></option>
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
                                                                <input type="checkbox" name="booking" id="booking">
                                                                <label for="booking">Booking System</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Use inbuilt booking system -->
                                                    <div class="col-md-12" id="booking-details" style="display:none;">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="1" name="is_booking" id="is_booking">
                                                            <label class="form-check-label" for="is_booking">Use inbuilt booking system</label>
                                                        </div>

                                                        <!-- Days fieilds  -->
                                                        <div class="form-group mt-2" id="booking_days" style="display:none;">
                                                            <?php
                                                                $days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                                                
                                                                foreach ($days_of_week as $day) {
                                                            ?>
                                                            <div class="chbox">
                                                                <input type="checkbox" name="<?php echo strtolower($day); ?>" id="booking_<?php echo strtolower($day); ?>" value="<?php echo $day; ?>" style="height: 0px;" >
                                                                <label for="booking_<?php echo strtolower($day); ?>"><?php echo $day; ?></label>

                                                                <div class="row <?php echo strtolower($day); ?>_time" style="display:none;">
                                                                    <div class="form-group col-md-4 serex-date">
                                                                        <input type="time" class="form-control mb-3" name="start_time_<?php echo strtolower($day); ?>" value="">
                                                                    </div>
                                                                    <div class="form-group col-md-4 serex-date">
                                                                        <input type="time" class="form-control mb-3" name="end_time_<?php echo strtolower($day); ?>" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        </div>

                                                        <!-- Use your own booking system -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="0" name="is_booking" id="is_booking_url">
                                                            <label class="form-check-label" for="is_booking_url">Use your own booking system</label>
                                                        </div>

                                                        <div class="form-group mt-2" id="booking_url_group" style="display:none;">
                                                            <input type="text" name="booking_url" id="booking_url" class="form-control" value="" placeholder="Enter your booking system url...">
                                                        </div>
                                                    </div>
                                                    <!-- BOOKING SYSTEM END -->
                                                    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Job Title*</label>
                                                                <input type="text" name="job_title" id="job_title"
                                                                       class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Salary*</label>
                                                                <!--                                    <input type="range" min="0" max="300" value="0"-->
                                                                <!--                                           onchange="updateTextInput(this.value);" class="form-control" id="salsli">-->
                                                                <input type="text" required="required" onkeypress="return isNumber(event)" id="textInput" class="form-control"  name="job_salary" value="">
                                                                <!--                                    <span id="salout" class="salout"></span>-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">No of openings*</label>
                                                                <input type="text" onkeypress="return isNumber(event)"
                                                                       name="no_of_openings" class="form-control"
                                                                       required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Interview Date</label>
                                                                <input type="date" name="job_interview_date"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Interview Time</label>
                                                                <input type="time" name="job_interview_time"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Role</label>
                                                                <input type="text" name="job_role" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Education & Qualification</label>
                                                                <input type="text" name="educational_qualification"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Location</label>
                                                                <select class="form-control chosen-select" name="job_location">
                                                                    <option value="">Select Job location</option>
                                                                    <?php
                                                                    foreach (getAllJobCities() as $cities_row) {
                                                                        ?>
                                                                        <option
                                                                            value="<?php echo $cities_row['city_id']; ?>"><?php echo $cities_row['city_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Company logo</label>
                                                                <input type="file" name="company_logo"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Job category</label>
                                                                <select onChange="getJobSubCategory(this.value);"
                                                                        class="form-control chosen-select" name="category_id">
                                                                    <option value="">Select Category</option>
                                                                    <?php
                                                                    foreach (getAllJobCategories() as $categories_row) {
                                                                        ?>
                                                                        <option
                                                                            value="<?php echo $categories_row['category_id']; ?>"><?php echo $categories_row['category_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Job sub-category</label>
                                                                <select class="form-control chosen-select" id="sub_category_id"
                                                                        name="sub_category_id">
                                                                    <option value="">Job sub-category</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Job Type</label>
                                                                <select class="form-control chosen-select" name="job_type">
                                                                    <option value="1">Permanent</option>
                                                                    <option value="2">Contract</option>
                                                                    <option value="3">Part time</option>
                                                                    <option value="4">Freelance</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Year(s) of experience</label>
                                                                <input type="text" onkeypress="return isNumber(event)"
                                                                       name="years_of_experience" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Contact no</label>
                                                                <input type="text" onkeypress="return isNumber(event)"
                                                                       name="contact_number" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Email id</label>
                                                                <input type="email" name="contact_email_id"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Website</label>
                                                                <input type="text" name="contact_website"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Contact person</label>
                                                                <input type="text" name="contact_person"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Interview location</label>
                                                                <input type="text" name="interview_location"
                                                                     id="interview_location"  class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Company Name</label>
                                                                <input type="text" name="job_company_name"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Skill set</label>
                                                                <select class="chosen-select form-control" multiple
                                                                        name="skill_set[]">
                                                                    <?php
                                                                    foreach (getAllJobSkill() as $skill_row) {
                                                                        ?>
                                                                        <option
                                                                            value="<?php echo $skill_row['category_id']; ?>"><?php echo $skill_row['category_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">Job Descriptions</label>
                                    <textarea name="job_description" class="form-control"
                                              id="job_description"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="tit">About your company(small description)</label>
                                                            <textarea name="job_small_description"
                                                                      class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                </li>
                                            </ul>
                                            <div class="form-group">
                                                <button type="submit" name="job_submit" class="btn btn-primary">Submit
                                                    Now
                                                </button>
                                            </div>
                                        </div>
                                    </form>

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
<script src="../js/select-opt.js"></script>
<script src="js/admin-custom.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('job_description');
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
    
    function getJobSubCategory(val) {
        $.ajax({
            type: "POST",
            url: "../job_sub_category_process.php",
            data: 'category_id=' + val,
            success: function (data) {
                $("#sub_category_id").html(data);
                $('#sub_category_id').trigger("chosen:updated");
            }
        });
    }
</script>
<script>
    var slider = document.getElementById("salsli");
    var output = document.getElementById("salout");
    output.innerHTML = slider.value;

    slider.oninput = function () {
        output.innerHTML = this.value + "K";
    }
</script>
<script>
    function updateTextInput(val) {
        document.getElementById('textInput').value = val;
    }
</script>
<?php if ($footer_row['admin_google_paid_geo_location'] == 1) { ?>
<script
      src="https://maps.googleapis.com/maps/api/js?key=<?php echo $footer_row['admin_geo_map_api']; ?>&callback=initAutocomplete&libraries=places&v=weekly"
      defer
    ></script>
    <script src="../js/google-geo-location-job-add.js">
     </script>
     <?php } ?>
</body>

</html>