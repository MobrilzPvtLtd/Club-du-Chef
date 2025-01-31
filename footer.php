<!-- START -->
<?php
// Fetch query of booking_availability
if (isset($availability_day_result)) {
    $availability_days = [];
    $day_map = [
        'Sunday' => 0,
        'Monday' => 1,
        'Tuesday' => 2,
        'Wednesday' => 3,
        'Thursday' => 4,
        'Friday' => 5,
        'Saturday' => 6
    ];

    while ($availability = mysqli_fetch_assoc($availability_day_result)) {
        $day_name = $availability['day'];
        if (isset($day_map[$day_name])) {
            $day_index = $day_map[$day_name];
            
            $availability_days[] = [
                'day' => $day_index,
                'start_time' => $availability['start_time'],
                'end_time' => $availability['end_time']
            ];
        }
    }

    $available_days = array_map(function($slot) { return $slot['day']; }, $availability_days);
    $available_slots = json_encode($availability_days);

    echo "<script>
            var availableDays = " . json_encode($available_days) . ";
            var availableSlots = " . $available_slots . ";
        </script>";

    // Fetch existing booking dates from the database
    $date_times = [];

    while ($exist_day = mysqli_fetch_assoc($exist_day_result)) {
        $date_times[] = $exist_day['date_time'];
    }

    echo "<script>
        var existDays = " . json_encode($date_times) . ";
    </script>";
}

?>
<!-- booking system form start  -->
<div class="modal fade" id="booking">
    <div class="modal-dialog">
        <div class="modal-content" style="margin-top: 30%;">
            <div class="log-bor">&nbsp;</div>
            <span class="udb-inst">Booking</span>
            <button type="button" class="close" data-dismiss="modal" style="margin-left: 92%;">&times;</button>
            <div class="quote-pop">
                <form method="post" action="/booking_insert.php" enctype="multipart/form-data">
                    <input type="hidden" name="booking_type" value="<?php echo $booking_type; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $session_user_id; ?>">
                    <div class="form-group col-md-6 serex-date">
                        <input type="text" class="form-control" name="booking_date" placeholder="DATE" id="booking_date" required>
                    </div>
                    
                    <div class="form-group col-md-6 serex-date">
                        <select class="form-control" name="booking_time" id="booking_time" required>
                            <option value="">Select Time</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary float-end">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- booking system form end  -->
 
<!-- <span class="btn-ser-need-ani"><img loading="lazy" src="/images/icon/help.png" alt=""></span> -->

<!-- <div class="ani-quo-form">
    <i class="material-icons ani-req-clo">close</i>
    <div class="tit">
        <h3><?php echo $Zitiziti['HOM-WHAT-SER']; ?> <span><?php echo $Zitiziti['HOM-WHAT-BIZ-BOOK-HELP-YOU']; ?></span></h3>
    </div>
    <div class="hom-col-req">
        <div id="home_slide_enq_success" class="log"
             style="display: none;">
            <p><?php echo $Zitiziti['ENQUIRY_SUCCESSFUL_MESSAGE']; ?></p>
        </div>
        <div id="home_slide_enq_fail" class="log" style="display: none;">
            <p><?php echo $Zitiziti['OOPS_SOMETHING_WENT_WRONG']; ?></p>
        </div>
        <div id="home_slide_enq_same" class="log" style="display: none;">
            <p><?php echo $Zitiziti['ENQUIRY_OWN_LISTING_MESSAGE']; ?></p>
        </div>
        <form name="home_slide_enquiry_form" id="home_slide_enquiry_form" method="post" enctype="multipart/form-data">
            <input type="hidden" class="form-control"
                   name="listing_id"
                   value="0"
                   placeholder=""
                   required>
            <input type="hidden" class="form-control"
                   name="listing_user_id"
                   value="0"
                   placeholder=""
                   required>
            <input type="hidden" class="form-control"
                   name="enquiry_sender_id"
                   value=""
                   placeholder=""
                   required>
            <input type="hidden" class="form-control"
                   name="enquiry_source"
                   value="<?php if (isset($_GET["src"])) {
                       echo $_GET["src"];
                   } else {
                       echo "Website";
                   }; ?>"
                   placeholder=""
                   required>
            <div class="form-group">
                <input type="text" name="enquiry_name" value="" required="required" class="form-control"
                       placeholder="<?php echo $Zitiziti['LEAD-NAME-PLACEHOLDER']; ?>">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="<?php echo $Zitiziti['ENTER_EMAIL_STAR']; ?>" required="required" value=""
                       name="enquiry_email"
                       pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$"
                       title="<?php echo $Zitiziti['LEAD-INVALID-EMAIL-TITLE']; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" value="" name="enquiry_mobile"
                       placeholder="<?php echo $Zitiziti['LEAD-MOBILE-PLACEHOLDER']; ?>" pattern="[7-9]{1}[0-9]{9}"
                       title="<?php echo $Zitiziti['LEAD-INVALID-MOBILE-TITLE']; ?>" required="">
            </div>
            <div class="form-group">
                <select name="enquiry_category" id="enquiry_category" class="form-control chosen-select">
                    <option value=""><?php echo $Zitiziti['SELECT_CATEGORY']; ?></option>
                    <?php
                    foreach (getAllCategories() as $categories_row) {
                        ?>
                        <option
                            value="<?php echo $categories_row['category_id']; ?>"><?php echo $categories_row['category_name']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <textarea class="form-control" rows="3" name="enquiry_message"
                          placeholder="<?php echo $Zitiziti['LEAD-MESSAGE-PLACEHOLDER']; ?>"></textarea>
            </div>
            <input type="hidden" id="source">
            <button type="submit" id="home_slide_enquiry_submit" name="home_slide_enquiry_submit"
                    class="btn btn-primary"><?php echo $Zitiziti['SUBMIT_REQUIREMENTS']; ?>
            </button>
        </form>
    </div>
</div> -->
<!-- END -->

<!-- START -->
<section>
    <div class="full-bot-book">
        <div class="container">
            <div class="row">
                <?php if($footer_row['admin_install_flag'] == 0) { kwohereza($SHYIRAMO); }?>
                <div class="bot-book">
                    <div class="col-md-12 bb-text">
                        <h4><?php echo $Zitiziti['FOOT-BAN-TIT']; ?></h4>
                        <p><?php echo $Zitiziti['FOOT-BAN-SUB-TIT']; ?></p>
                        <a href="<?php echo $slash; ?>pricing-details"><?php echo $Zitiziti['FOOT-BAN-ADD']; ?> <i class="material-icons">arrow_forward</i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END -->
<!-- <?php 
// if($footer_row['admin_install_flag'] == 1) { unlink("install1.php"); unlink("install2.php"); }
if ($footer_row['admin_install_flag'] == 1) {
    if (file_exists("install1.php")) {
        unlink("install1.php");
    } else {
        error_log("File 'install1.php' does not exist and could not be deleted.");
    }

    if (file_exists("install2.php")) {
        unlink("install2.php");
    } else {
        error_log("File 'install2.php' does not exist and could not be deleted.");
    }
} 
?> -->
<section class="<?php if($footer_row['admin_language']== 2){ echo "lg-arb";}?> wed-hom-footer">
    <div class="container">
        <div class="row foot-supp">
            
            <div class="row">
                <div class="col-md-10">
                    <h2><span><?php echo $Zitiziti['FOOTER-FREE-SUPPORT']; ?>:</span> <?php echo $footer_row['footer_mobile']; ?> &nbsp;&nbsp;|&nbsp;&nbsp; <span><?php echo $Zitiziti['EMAIL']; ?>:</span> <?php echo $footer_row['admin_primary_email']; ?></h2>
                    <!-- <span> <?php echo $Zitiziti['FOOTER-FREE-SUPPORT']; ?>:</span> <?php echo $footer_row['footer_mobile']; ?>
                    <span><?php echo $Zitiziti['EMAIL']; ?>:</span> <?php echo $footer_row['admin_primary_email']; ?> -->
                </div>
                <div class="col-md-2 footer_support">
                    <select name="lang" id="lang" class="form-control">
                        <option>Select Language</option>
                        <option value="en" <?php if($lang == 'en') {echo 'selected';} ?>>English</option>
                        <option value="es" <?php if($lang == 'es') {echo 'selected';} ?>>Spanish</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row wed-foot-link">
            <div class="col-md-4 foot-tc-mar-t-o">
                <h4><?php echo $Zitiziti['FOOTER-TOP-CATEGORY']; ?></h4>
                <ul>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['top_category_1']))); ?>"><?php echo getCategoryName($footer_row['top_category_1']); ?></a></li>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['top_category_2']))); ?>"><?php echo getCategoryName($footer_row['top_category_2']); ?></a></li>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['top_category_3']))); ?>"><?php echo getCategoryName($footer_row['top_category_3']); ?></a></li>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['top_category_4']))); ?>"><?php echo getCategoryName($footer_row['top_category_4']); ?></a></li>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['top_category_5']))); ?>"><?php echo getCategoryName($footer_row['top_category_5']); ?></a></li>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['top_category_6']))); ?>"><?php echo getCategoryName($footer_row['top_category_6']); ?></a></li>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['top_category_7']))); ?>"><?php echo getCategoryName($footer_row['top_category_7']); ?></a></li>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['top_category_8']))); ?>"><?php echo getCategoryName($footer_row['top_category_8']); ?></a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4><?php echo $Zitiziti['FOOTER-TRENDING-CATEGORY']; ?></h4>
                <ul>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['trend_category_1']))); ?>"><?php echo getCategoryName($footer_row['trend_category_1']); ?></a></li>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['trend_category_2']))); ?>"><?php echo getCategoryName($footer_row['trend_category_2']); ?></a></li>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['trend_category_3']))); ?>"><?php echo getCategoryName($footer_row['trend_category_3']); ?></a></li>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['trend_category_4']))); ?>"><?php echo getCategoryName($footer_row['trend_category_4']); ?></a></li>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['trend_category_5']))); ?>"><?php echo getCategoryName($footer_row['trend_category_5']); ?></a></li>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['trend_category_6']))); ?>"><?php echo getCategoryName($footer_row['trend_category_6']); ?></a></li>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['trend_category_7']))); ?>"><?php echo getCategoryName($footer_row['trend_category_7']); ?></a></li>
                    <li><a href="<?php echo $ALL_LISTING_URL . urlModifier(getCategoryName(strtolower($footer_row['trend_category_8']))); ?>"><?php echo getCategoryName($footer_row['trend_category_8']); ?></a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4><?php echo $Zitiziti['FOOTER-HELP']; ?> &amp; <?php echo $Zitiziti['FOOTER-SUPPORT']; ?></h4>
                <ul>
                    <li><a href="<?php echo $slash; ?><?php echo $footer_row['footer_page_url_1']; ?>"><?php echo $footer_row['footer_page_name_1']; ?></a>
                    </li>
                    <li><a href="<?php echo $slash; ?><?php echo $footer_row['footer_page_url_2']; ?>"><?php echo $footer_row['footer_page_name_2']; ?></a>
                    </li>
                    <li><a href="<?php echo $slash; ?><?php echo $footer_row['footer_page_url_3']; ?>"><?php echo $footer_row['footer_page_name_3']; ?></a>
                    </li>
                    <li><a href="<?php echo $slash; ?><?php echo $footer_row['footer_page_url_4']; ?>"><?php echo $footer_row['footer_page_name_4']; ?></a>
                    </li>
                    <li><a href="privacy-policy.php"><?php echo $Zitiziti['pg_pri_tit']; ?></a></li>
                    <li><a href="terms-of-use.php"><?php echo $Zitiziti['pg_terms_tit']; ?></a></li>
                </ul>
            </div>
        </div>

        <!-- POPULAR TAGS -->
        <div class="row wed-foot-link-pop">
            <div class="col-md-12">
                <h4><?php echo $Zitiziti['FOOTER-POPULAR-TAGS']; ?></h4>
                <ul>
                    <?php
                    foreach (getAllPopularTags() as $popular_tags_row) {
                        ?>
                        <li><a href="<?php echo $popular_tags_row['popular_tags_link']; ?>"><?php echo $popular_tags_row['popular_tags_name']; ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- POPULAR TAGS -->

        <div class="row wed-foot-link-1">
            <?php if($footer_row['admin_get_in_touch_feature'] == 1) { ?>
            <div class="col-md-4">
                <h4><?php echo $Zitiziti['FOOTER-GET-IN-TOUCH']; ?></h4>
                <p><?php echo $Zitiziti['ADDRESS']; ?>: <?php echo $footer_row['footer_address']; ?></p>
                <p><?php echo $Zitiziti['PHONE']; ?>: <a href="tel:<?php echo $footer_row['footer_mobile']; ?>"><?php echo $footer_row['footer_mobile']; ?></a></p>
                <p><?php echo $Zitiziti['EMAIL']; ?>: <a href="mailto:<?php echo $footer_row['admin_primary_email']; ?>"><?php echo $footer_row['admin_primary_email']; ?></a></p>
            </div>
            <?php } ?>
            <?php if($footer_row['admin_footer_mobile_app_feature'] == 1) { ?>
            <div class="col-md-4 fot-app">
                <h4><?php echo $Zitiziti['FOOTER-DOWNLOAD-FREE-MOBILE-APPS']; ?></h4>
                <ul>
                    <li><a href="<?php echo $footer_row['mobile_app_andriod']; ?>"><img loading="lazy" src="/images/gstore.png" alt=""></a>
                    </li>
                    <li><a href="<?php echo $footer_row['mobile_app_ios']; ?>"><img loading="lazy" src="/images/astore.png" alt=""></a>
                    </li>
                </ul>
            </div>
            <?php } ?>
            <div class="col-md-4 fot-soc">
                <h4><?php echo $Zitiziti['FOOTER-SOCIAL-MEDIA']; ?></h4>
                <ul>
                    <li><a target="_blank" href="<?php echo $footer_row['footer_linked_in']; ?>"><img loading="lazy" src="/images/social/1.png" alt=""></a></li>
                    <li><a target="_blank" href="<?php echo $footer_row['footer_twitter']; ?>"><img loading="lazy" src="/images/social/2.png" alt=""></a></li>
                    <li><a target="_blank" href="<?php echo $footer_row['footer_fb']; ?>"><img loading="lazy" src="/images/social/3.png" alt=""></a></li>
                    <li><a target="_blank" href="<?php echo $footer_row['footer_whatsapp']; ?>"><img loading="lazy" src="/images/social/4.png" alt=""></a></li>
                    <li><a target="_blank" href="<?php echo $footer_row['footer_youtube']; ?>"><img loading="lazy" src="/images/social/5.png" alt=""></a></li>
                </ul>
            </div>
        </div>
        <?php if($footer_row['admin_country_list_feature'] == 1) { ?>
        <div class="row foot-count">
            <ul>
                <li><a target="_blank" href="http://<?php echo $footer_row['footer_country_url_1']; ?>"><?php echo $footer_row['footer_country_name_1']; ?></a></li>
                <li><a target="_blank" href="http://<?php echo $footer_row['footer_country_url_2']; ?>"><?php echo $footer_row['footer_country_name_2']; ?></a></li>
                <li><a target="_blank" href="http://<?php echo $footer_row['footer_country_url_3']; ?>"><?php echo $footer_row['footer_country_name_3']; ?></a></li>
                <li><a target="_blank" href="http://<?php echo $footer_row['footer_country_url_4']; ?>"><?php echo $footer_row['footer_country_name_4']; ?></a></li>
                <li><a target="_blank" href="http://<?php echo $footer_row['footer_country_url_5']; ?>"><?php echo $footer_row['footer_country_name_5']; ?></a></li>
                <li><a target="_blank" href="http://<?php echo $footer_row['footer_country_url_6']; ?>"><?php echo $footer_row['footer_country_name_6']; ?></a></li>
                <li><a target="_blank" href="http://<?php echo $footer_row['footer_country_url_7']; ?>"><?php echo $footer_row['footer_country_name_7']; ?></a></li>
            </ul>
        </div>
        <?php } ?>
    </div>
</section>

<!-- START -->
<section>
    <div class="cr">
        <div class="container">
            <div class="row">
                <p><?php echo $Zitiziti['FOOTER-COPYRIGHT']; ?> © <?php echo $footer_row['copyright_year']; ?> <a href="<?php echo $footer_row['copyright_website_link']; ?>" target="_blank"><?php echo $footer_row['copyright_website']; ?></a>. <?php echo $Zitiziti['FOOTER-PROUDLY-POWERED-BY']; ?> <a href="https://www.zitiziti.com" target="_blank">www.zitiziti.com</a></p>
            </div>
        </div>
    </div>
</section>
<!-- END -->

<!-- START -->
<div class="fqui-menu">
<ul >
    <?php if ($footer_row['admin_listing_show'] == 1) { ?>
        <li><a href="<?php echo $webpage_full_link; ?>" ><img  src="/images/icon/shop.png"><?php echo $Zitiziti['HOME']; ?></a></li>
        <li><a href="<?php echo $webpage_full_link; ?>all-category"
                class="act"><img        src="/images/icon/shop.png"><?php echo $Zitiziti['ALL_SERVICES']; ?>
            </a></li>
    <?php }
    if ($footer_row['admin_expert_show'] == 1) { ?>
        <li><a href="<?php echo $webpage_full_link; ?>service-experts"
                class="act"><img        src="/images/icon/expert.png"><?php echo $Zitiziti['SERVICE-EXPERTS']; ?>
            </a></li>
    <?php }
    if ($footer_row['admin_job_show'] == 1) { ?>
        <li><a href="<?php echo $webpage_full_link; ?>jobs" class="act"><img        src="/images/icon/employee.png"><?php echo $Zitiziti['JOBS']; ?>
            </a></li>
    <?php }
    if ($footer_row['admin_place_show'] == 1) { ?>
        <li><a href="<?php echo $webpage_full_link; ?>places"
                class="act"><img        src="/images/places/icons/hot-air-balloon.png"><?php echo $Zitiziti['PLACE-MENU']; ?>
            </a></li>
    <?php }
    if ($footer_row['admin_news_show'] == 1) { ?>
        <li><a href="<?php echo $webpage_full_link; ?>news"><img        src="/images/icon/news.png"><?php echo $Zitiziti['NEWS-MAGA']; ?>
            </a></li>
    <?php }
    if ($footer_row['admin_event_show'] == 1) { ?>
        <li><a href="<?php echo $webpage_full_link; ?>events"><img        src="/images/icon/calendar.png"><?php echo $Zitiziti['EVENTS']; ?>
            </a></li>
    <?php }
    if ($footer_row['admin_product_show'] == 1) { ?>
        <li><a href="<?php echo $webpage_full_link; ?>all-products"><img        src="/images/icon/cart.png"><?php echo $Zitiziti['PRODUCTS']; ?>
            </a></li>
    <?php }
    if ($footer_row['admin_coupon_show'] == 1) { ?>
        <li><a href="<?php echo $webpage_full_link; ?>coupons"><img        src="/images/icon/coupons.png"><?php echo $Zitiziti['COUPONS_AND_DEALS']; ?>
            </a></li>
    <?php }
    if ($footer_row['admin_blog_show'] == 1) { ?>
        <li><a href="<?php echo $webpage_full_link; ?>blog-posts"><img        src="/images/icon/blog1.png"><?php echo $Zitiziti['BLOGS']; ?>
            </a></li>
    <?php } ?>
    <li><a href="<?php echo $webpage_full_link; ?>community"><img    src="/images/icon/11.png"><?php echo $Zitiziti['COMMUNITY']; ?>
        </a></li>
        <li><span class="btn-ser-need-ani"><img loading="lazy" src="/images/icon/how1.png"><?php echo $Zitiziti['SUPPORT']; ?></span></li>
</ul>
</div>
<!-- END -->

<script src="<?php echo $webpage_full_link; ?>/js/jquery.min.js"></script>
<script>
    $("#lang").change(function() {
        langValue = $(this).val()
        // console.log($(this).val());
        
        $.ajax({
            type: "POST",
            url: "../change_language.php", 
            data: {
                lang: langValue,
            },
            success: function(data) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error during the language change:', error);
            }
        });
    });

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

<script>
    $(function() {
        // Date picker configuration
        $("#booking_date").datepicker({
            minDate: 0, 
            beforeShowDay: function(date) {
                var day = date.getDay(); // Get the day of the week (0=Sunday, 1=Monday, etc.)
                return [availableDays.indexOf(day) !== -1, "", ""];
            },
            onSelect: function(selectedDate) {
                updateTimeSlots(selectedDate);
            }
        });

        // Time picker configuration
        $('#booking_time').timepicker({
            'minTime': '08:00',   // Default start time (to be updated dynamically)
            'maxTime': '18:00',   // Default end time (to be updated dynamically)
            'interval': 30,       // Time interval in minutes
            'disableTime': []     // Disable times based on selected date
        });

        // Function to update time slots based on selected date
        function updateTimeSlots(selectedDate) {
            console.log(existDays);  // Log existDays to check the format

            // Format the selected date as 'yyyy-mm-dd'
            var dateString = $.datepicker.formatDate('yy-mm-dd', new Date(selectedDate));
            var dayOfWeek = new Date(selectedDate).getDay();

            // Find the available slots for the selected day
            var daySlots = availableSlots.find(function(slot) {
                return slot.day === dayOfWeek;  // Match the selected day
            });

            // Check if daySlots are found and contain valid start_time and end_time
            if (daySlots && daySlots.start_time && daySlots.end_time) {
                var startTime = daySlots.start_time;
                var endTime = daySlots.end_time;

                // Generate time slots between start and end times (30-minute intervals)
                var timeSlots = generateTimeSlots(startTime, endTime, 30); // 30-minute intervals

                $('#booking_time').empty();  

                timeSlots.forEach(function(timeSlot) {
                    var isDisabled = existDays.some(function(existingDate) {

                        if (existingDate && typeof existingDate === 'string') {
                            var dateParts = existingDate.split(' ');

                            var existingDateString = dateParts[0];  
                            var existingTime = dateParts[1] || '00:00';  

                            existingTime = existingTime.split(':').slice(0, 2).join(':'); 

                                if (existingDateString === dateString) {
                                    if (existingTime === timeSlot) {
                                        console.log('Disabling exact time slot:', timeSlot);
                                        return true; 
                                    }
                                }
                        } else {
                            console.log('Invalid or undefined existingDate:', existingDate); 
                        }

                        return false;
                    });

                    // Append the time slot to the dropdown, and disable it if already booked
                    $('#booking_time').append(
                        '<option value="' + timeSlot + '" ' + (isDisabled ? 'disabled' : '') + '>' + timeSlot + '</option>'
                    );
                });
            }
        }


        // Function to generate time slots between start time and end time
        function generateTimeSlots(startTime, endTime, interval) {
            var slots = [];
            var start = convertToMinutes(startTime);
            var end = convertToMinutes(endTime);
            
            for (var time = start; time < end; time += interval) {
                slots.push(convertToTimeFormat(time));
            }
            return slots;
        }

        // Convert time in 'HH:mm' format (24-hour) to total minutes
        // function convertToMinutes(time) {
        //     var timeParts = time.split(':');
        //     var hours = parseInt(timeParts[0]);
        //     var minutes = parseInt(timeParts[1]);

        //     // Convert 12-hour format to 24-hour format for correct minute calculation
        //     if (hours < 12) {
        //         return hours * 60 + minutes;
        //     } else {
        //         return (hours === 12 ? 0 : hours - 12 + 12) * 60 + minutes; // Convert 12 PM correctly
        //     }
        // }
        function convertToMinutes(time) {
            var timeParts = time.split(':');
            return parseInt(timeParts[0]) * 60 + parseInt(timeParts[1]);
        }

        // Convert minutes back to 'hh:mm AM/PM' format (12-hour)
        function convertToTimeFormat(minutes) {
            var hours = Math.floor(minutes / 60);
            var mins = minutes % 60;

            // Convert back to 12-hour format
            // var period = hours < 12 ? 'AM' : 'PM'; // Determine AM/PM

            // if (hours === 0) {
            //     hours = 12; // Midnight (12:00 AM)
            // } else if (hours > 12) {
            //     hours -= 12; // Convert PM hours (13:00 to 1:00 PM)
            // }

            if (mins < 10) {
                mins = '0' + mins;
            }
            return hours + ':' + mins;

            // return hours + ':' + mins + ' ' + period;
        }

    });
</script>