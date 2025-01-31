<?php
include "header.php";

if($footer_row['admin_event_show'] != 1) {
    header("Location: ".$webpage_full_link."dashboard");
}

$redirect_url = $webpage_full_link.'dashboard';  //Redirect Url

if ($_GET['row'] == NULL && empty($_GET['row'])) {

    header("Location: $redirect_url");  //Redirect When code parameter is empty
}


$event_codea1 = str_replace('-', ' ', $_GET['row']);
$event_codea = str_replace('.php', '', $event_codea1);

//$event_codea = $_GET['row'];
$events_a_row = getSlugEvent($event_codea);

$user_id = $events_a_row['user_id'];
$event_id = $events_a_row['event_id'];
$event_category_id = $events_a_row['category_id'];

eventpageview($event_id); //Function To Find Page View

$event_user_row = getUser($user_id);

$redirect_url = $webpage_full_link.'dashboard';  //Redirect Url

if ($event_id == NULL && empty($event_id)) {

    header("Location: $redirect_url");  //Redirect When No Event Found in Table
}

// Fetch query of booking_availability
$check_query = "SELECT day, start_time, end_time FROM " . TBL . "booking_availability WHERE event_id = '{$events_a_row['event_id']}' AND is_available = 1";
$availability_day_result = mysqli_query($conn, $check_query);

// Fetch existing booking dates from the database
$bookings = "SELECT date_time FROM " . TBL . "bookings WHERE booking_type = 'event'";
$exist_day_result = mysqli_query($conn, $bookings);

?>
<!-- START -->
<section class="<?php if ($footer_row['admin_language'] == 2) {
    echo "lg-arb";
} ?> eve-deta-pg eve-deta-pg1">
    <div class="container">
        <div class="eve-deta-pg-main">
           
            <?php
            if (($events_a_row['isenquiry'] == 1)) {
                ?>
                <div class="rhs">
                    <div class="list-rhs-form pglist-bg pglist-p-com">
                        <div class="quote-pop">
                            <h3><?php echo $Zitiziti['REGISTER_NOW']; ?></h3>
                            <div id="event_detail_enq_success" class="log new-tnk-msg" style="display: none;"><p><?php echo $Zitiziti['ENQUIRY_SUCCESSFUL_MESSAGE']; ?></p>
                            </div>
                            <div id="event_detail_enq_same" class="log" style="display: none;"><p><?php echo $Zitiziti['ENQUIRY_OWN_EVENT_MESSAGE']; ?></p>
                            </div>
                            <div id="event_detail_enq_fail" class="log" style="display: none;"><p><?php echo $Zitiziti['OOPS_SOMETHING_WENT_WRONG']; ?></p>
                            </div>
                            <form method="post" name="event_detail_enquiry_form" id="event_detail_enquiry_form">
                                <?php if (!isset($_SESSION['user_code']) && empty($_SESSION['user_code'])){ ?>
                                <fieldset disabled="disabled">
                                    <?php } ?>
                                    <input type="hidden" class="form-control" name="event_id"
                                           value="<?php echo $event_id ?>"
                                           placeholder=""
                                           required>
                                    <input type="hidden" class="form-control"
                                           name="listing_user_id"
                                           value="<?php echo $user_id; ?>" placeholder=""
                                           required>
                                    <input type="hidden" class="form-control"
                                           name="enquiry_sender_id"
                                           value="<?php echo $_SESSION['user_id']; ?>"
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

                                    <div class="form-group ic-user">
                                        <input type="text" name="enquiry_name"
                                               value="<?php echo $user_details_row['first_name'] ?>"
                                               required="required" class="form-control"
                                               placeholder="<?php echo $Zitiziti['LEAD-NAME-PLACEHOLDER']; ?>">
                                    </div>
                                    <div class="form-group ic-eml">
                                        <input type="email" class="form-control"
                                               placeholder="<?php echo $Zitiziti['ENTER_EMAIL_STAR']; ?>" required="required"
                                               value="<?php echo $user_details_row['email_id'] ?>"
                                               name="enquiry_email"
                                               pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$"
                                               title="<?php echo $Zitiziti['LEAD-INVALID-EMAIL-TITLE']; ?>">
                                    </div>
                                    <div class="form-group ic-pho">
                                        <input type="text" class="form-control"
                                               value="<?php echo $user_details_row['mobile_number'] ?>"
                                               name="enquiry_mobile"
                                               placeholder="<?php echo $Zitiziti['LEAD-MOBILE-PLACEHOLDER']; ?>"
                                               pattern="[7-9]{1}[0-9]{9}"
                                               title="<?php echo $Zitiziti['LEAD-INVALID-MOBILE-TITLE']; ?>"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="3" name="enquiry_message"
                                                  placeholder="<?php echo $Zitiziti['LEAD-MESSAGE-PLACEHOLDER']; ?>"></textarea>
                                    </div>
                                    <input type="hidden" id="source">
                                    <?php if (!isset($_SESSION['user_code']) && empty($_SESSION['user_code'])){ ?>
                                </fieldset>
                            <?php } ?>
                                <?php if (!isset($_SESSION['user_code']) && empty($_SESSION['user_code'])) { ?>
                                    <a href="<?php echo $slash; ?>login">
                                        <button type="button" name="" class="btn btn-primary"><?php echo $Zitiziti['LEAD-LOGIN-ENJOY-MESSAGE']; ?>
                                        </button>
                                    </a>
                                <?php } else { ?>
                                    <button type="submit" name="enquiry_submit" class="btn btn-primary"><?php echo $Zitiziti['SUBMIT']; ?>
                                    </button>
                                <?php } ?>

                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
             <div class="lhs">
                <div class="img">
                    <img loading="lazy" src="<?php echo $slash; ?>images/events/<?php echo $events_a_row['event_image']; ?>" alt="">
                    <span class="dat"><b><?php echo dateMonthFormatconverter($events_a_row['event_start_date']); ?></b> <?php echo dateDayFormatconverter($events_a_row['event_start_date']); ?></span>
                </div>
                
            </div>
        </div>
    </div>
</section>
<!--END-->

<!-- START -->
<section class="<?php if ($footer_row['admin_language'] == 2) {
    echo "lg-arb";
} ?> eve-deta-body">
    <div class="container">
        <div class="eve-deta-body-main">
            <div class="lhs">
               <div class="head">
                   <div class="eve-bred-crum">
                        <ul>
                        <li><a href="<?php echo $slash; ?>"><?php echo $Zitiziti['HOME']; ?></a></li>
                        <li><a href="<?php echo $slash; ?>events"><?php echo $Zitiziti['ALL_EVENTS']; ?></a></li>
                        <li><a href="#"><?php echo $events_a_row['event_name']; ?></a></li>
                        </ul>
                    </div>
                    <h1><?php echo $events_a_row['event_name']; ?></h1>
                </div>
                <?php echo stripslashes($events_a_row['event_description']) ?>
                <div class="list-sh">
                        <span class="share-new" data-toggle="modal" data-target="#sharepop"><i class="material-icons">share</i> Share now</span>
                    </div>
            </div>
            <div class="rhs">
                <!-- booking system form start  -->
                <?php
                    $booking_type = isset($_GET['booking_type']) ? $_GET['booking_type'] : 'event';

                    if (isset($_SESSION['status_msg'])) {
                        include "page_level_message.php";
                        unset($_SESSION['status_msg']);
                    }
                    if($events_a_row['is_booking'] == 0 && $events_a_row['booking_url'] != ''){
                    ?>
                        <a href="<?php echo $events_a_row['booking_url']; ?>"><button  class="booking-btn"><?php echo $Zitiziti['SERVICE-EXPERT-BOOK-NOW']; ?></button></a>
                    <?php
                    }elseif($events_a_row['is_booking'] == 1) {
                    ?>
                        <button class="booking-btn" data-toggle="modal" data-target="#booking"><?php echo $Zitiziti['SERVICE-EXPERT-BOOK-NOW']; ?></button>

                <?php
                }
                ?>
                <div class="sec-1">
                    <h4><?php echo $Zitiziti['EVENT-DETAILS-EVENT-INFORMATION']; ?>:</h4>
                    <ul>
                        <li><b><?php echo $Zitiziti['NAME']; ?></b>: <?php echo $events_a_row['event_name']; ?></li>
                        <li><b><?php echo $Zitiziti['DATE']; ?></b>: <?php echo dateFormatconverter($events_a_row['event_start_date']); ?></li>
                        <li><b><?php echo $Zitiziti['TIME']; ?></b>: <?php echo $events_a_row['event_time']; ?></li>
                        <li><b><?php echo $Zitiziti['ADDRESS']; ?></b>: <?php echo $events_a_row['event_address']; ?></li>
                        <li><b><?php echo $Zitiziti['CONTACT_PERSON']; ?></b>: <?php echo $events_a_row['event_contact_name']; ?></li>
                        <li><b><?php echo $Zitiziti['PHONE']; ?></b>: <?php echo $events_a_row['event_mobile']; ?></li>
                        <li><b><?php echo $Zitiziti['EMAIL']; ?></b>: <?php echo $events_a_row['event_email']; ?></li>
                        <?php
                        if ($events_a_row['event_website'] != NULL || empty($events_a_row['event_website'])) {
                            ?>
                            <li><b><?php echo $Zitiziti['WEBSITE']; ?></b>: <?php echo $events_a_row['event_website']; ?></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="sec-2">
                    <h4><?php echo $Zitiziti['LOCATION']; ?></h4>
                    <?php echo $events_a_row['event_map']; ?>
                </div>
                <div class="sec-3">
                    <div class="pro-bad-sml">
                        <img
                            src="<?php echo $slash; ?>images/user/<?php if (($event_user_row['profile_image'] == NULL) || empty($event_user_row['profile_image'])) {
                                echo $footer_row['user_default_image'];
                            } else {
                                echo $event_user_row['profile_image'];
                            } ?>" alt="">
                        <h4><?php echo $event_user_row['first_name']; ?></h4>
                        <b><?php echo $Zitiziti['BLOG-DETAILS-JOIN-ON']; ?> <?php echo dateFormatconverter($event_user_row['user_cdt']); ?></b>
                        <a target="_blank"
                           href="<?php echo $PROFILE_URL.urlModifier($event_user_row['user_slug']); ?>"
                           class="fclick">&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="pro-rel-events">
            <h4><?php echo $Zitiziti['EVENT-DETAILS-RELATED-EVENTS']; ?></h4>
            <div class="event-body">
            <div class="plac-hom-all-pla plac-det-eve">
                    <ul class="multiple-items1">
                        <?php
                        $si = 1;
                        foreach (getExceptEvent($event_id,$event_category_id) as $eventrow) {

                            $user_id = $eventrow['user_id'];

                            $event_user_row = getUser($user_id);

                            ?>
                                <li>
                                    <div class="plac-hom-box">
                                        <div class="plac-hom-box-im">
                                        <img loading="lazy" src="<?php echo $slash; ?>images/events/<?php echo $eventrow['event_image']; ?>" alt="">
                                        <h4>
                                            <?php echo $eventrow['event_name']; ?>
                                        </h4>
                                            <span class="plac-det-cate"><?php echo dateMonthFormatconverter($eventrow['event_start_date']); ?>
                                                <b><?php echo dateDayFormatconverter($eventrow['event_start_date']); ?></b></span>
                                        </div>
                                        <a href="<?php echo $EVENT_URL.urlModifier($eventrow['event_slug']); ?>" class="fclick"></a>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
            </div>
        </div>
    </div>
</section>
<!--END--> 

<section>
    <div class="pop-ups pop-quo">
        <!-- The Modal -->
        <div class="modal fade" id="quote">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <!-- Modal Header -->
                    <div class="quote-pop">
                        <h4><?php echo $Zitiziti['LEAD-GET-QUOTE']; ?></h4>
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="<?php echo $Zitiziti['LEAD-NAME-PLACEHOLDER']; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="<?php echo $Zitiziti['ENTER_EMAIL_STAR']; ?>"
                                       pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$"
                                       title="<?php echo $Zitiziti['LEAD-INVALID-EMAIL-TITLE']; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="<?php echo $Zitiziti['LEAD-MOBILE-PLACEHOLDER']; ?>"
                                       pattern="[7-9]{1}[0-9]{9}"
                                       title="<?php echo $Zitiziti['LEAD-INVALID-MOBILE-TITLE']; ?>" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="3"
                                          placeholder="<?php echo $Zitiziti['LEAD-MESSAGE-PLACEHOLDER']; ?>"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary"><?php echo $Zitiziti['SUBMIT']; ?></button>
                        </form>
                    </div>
                    <div class="log-bor">&nbsp;</div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- SHARE POPUP -->
<div class="modal fade sharepop" id="sharepop">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Share now</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <input type="text" value="" id="shareurl">
                <div class="shareurltip">
                    <button onclick="shareurl()" onmouseout="shareurlout()">
                        <span class="shareurltxt" id="myTooltip">Copy to clipboard</span>
                        Copy text                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
include "footer.php";
?>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?php echo $slash; ?>js/jquery.min.js"></script>
<script src="<?php echo $slash; ?>js/popper.min.js"></script>
<script src="<?php echo $slash; ?>js/bootstrap.min.js"></script>
<script src="<?php echo $slash; ?>js/jquery-ui.js"></script>
<script type="text/javascript">var webpage_full_link ='<?php echo $webpage_full_link;?>';</script>
<script type="text/javascript">var login_url ='<?php echo $LOGIN_URL;?>';</script>
<script src="<?php echo $slash; ?>js/slick.js"></script>
<script src="<?php echo $slash; ?>js/custom.js"></script>
<script src="<?php echo $slash; ?>js/jquery.validate.min.js"></script>
<script src="<?php echo $slash; ?>js/custom_validation.js"></script>
<script>
$('.multiple-items1').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerMode: false
            }
        }]

    });    

//    <!-- Event Enquiry Form Event Detail Page Ajax Call And Validation starts-->
    $(document).ready(function () {
        $("#event_detail_enquiry_form").validate({
            rules: {
                enquiry_name: {required: true},
                enquiry_email: {required: true, email: true},
                enquiry_mobile: {required: true}

            },
            messages: {

                enquiry_name: {required: "Name is Required"},
                enquiry_email: {required: "Email ID is Required"},
                enquiry_mobile: {required: "Mobile Number is Required"}
            },

            submitHandler: function (form) { // for demo
                //form.submit();
                $.ajax({
                    type: "POST",
                    data: $("#event_detail_enquiry_form").serialize(),
                    url: "<?php echo $slash; ?>enquiry_submit.php",
                    cache: true,
                    success: function (html) {
                        // alert(html);
                        if (html == 1) {
                            $("#event_detail_enq_success").show();
                            $("#event_detail_enquiry_form")[0].reset();
                        } else {
                            if (html == 3) {
                                $("#event_detail_enq_same").show();
                                $("#event_detail_enquiry_form")[0].reset();
                            }else {
                                $("#event_detail_enq_fail").show();
                                $("#event_detail_enquiry_form")[0].reset();
                            }
                        }

                    }

                })
            }
        });
    });
    <!-- Event Enquiry Form Event Detail Page Ajax Call And Validation ends-->

</script>
</body>

</html>