<?php
include "expert-config-info.php";
include "../header.php";

if($footer_row['admin_expert_show'] != 1) {
    header("Location: ".$webpage_full_link."dashboard");
}

if (isset($_SESSION['user_id'])) {
    $session_user_id = $_SESSION['user_id'];
}
$user_details_row = getUser($session_user_id);


$redirect_url = $webpage_full_link . 'dashboard';  //Redirect Url

if ($_GET['code'] == NULL && empty($_GET['code'])) {

    header("Location: $redirect_url");  //Redirect When code parameter is empty
}

//$expert_profile_codea = $_GET['code'];
$expert_profile_codea1 = str_replace('-', ' ', $_GET['code']);
$expert_profile_codea = str_replace('.php', '', $expert_profile_codea1);

$expert_profile_row = getSlugExpert($expert_profile_codea); // To Fetch particular Expert Data

if ($expert_profile_row['expert_id'] == NULL && empty($expert_profile_row['expert_id'])) {


    header("Location: $redirect_url");  //Redirect When No User Found in Table
}

$expert_id = $expert_profile_row['expert_id'];

$expert_profile_user_id = $expert_profile_row['user_id'];

$expert_profile_category_id = $expert_profile_row['category_id'];

$expert_profile_city_id = $expert_profile_row['city_id'];

$expert_profile_category_row = getExpertCategory($expert_profile_category_id);

$expert_category_name = $expert_profile_category_row['category_name'];

$expert_profile_city_row = getExpertCity($expert_profile_city_id);

$expert_city_name = $expert_profile_city_row['country_name'];

$expert_user_details_row = getUser($expert_profile_user_id);

// Service Expert Rating. for Rating of Star Starts

foreach (getExpertReview($expert_id) as $star_rating_row) {
    if ($star_rating_row["rate_cnt"] > 0) {
        $star_rate_times = $star_rating_row["rate_cnt"];
        $star_sum_rates = $star_rating_row["total_rate"];
        $star_rate_one = $star_sum_rates / $star_rate_times;
        $star_rate_two = number_format($star_rate_one, 1);
        $star_rate = floatval($star_rate_two);

    } else {
        $rate_times = 0;
        $rate_value = 0;
        $star_rate = 0;
    }
}

// Service Expert Rating. for Rating of Star Ends

expertprofilepageview($expert_id); //Function To Find Page View

// Fetch query of booking_availability
$check_query = "SELECT day, start_time, end_time FROM " . TBL . "booking_availability WHERE expert_id = '{$expert_profile_row['expert_id']}' AND is_available = 1";
$availability_day_result = mysqli_query($conn, $check_query);

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
$bookings = "SELECT date_time FROM " . TBL . "bookings WHERE booking_type = 'service_expert'";
$exist_day_result = mysqli_query($conn, $bookings);

$date_times = [];

while ($exist_day = mysqli_fetch_assoc($exist_day_result)) {
    $date_times[] = $exist_day['date_time'];
}

echo "<script>
    var existDays = " . json_encode($date_times) . ";
</script>";

?>

<!-- START -->
<section>
    <div class="job-prof-pg exp-prof-pg">
        <div class="container">
            <div class="row">
                <div class="lhs">
                    <div class="jpro-bd-chat">
                        <h4><?php echo $Zitiziti['SERVICE-EXPERT-BOOK-THIS']; ?>
                            (<b><?php echo $expert_profile_row['profile_name']; ?></b>) <?php echo $Zitiziti['SERVICE-EXPERT-SERVICE-EXPERT-TEXT']; ?>
                            <span data-toggle="modal" data-target="#expfrm"><?php echo $Zitiziti['SERVICE-EXPERT-BOOK-NOW']; ?></span></h4>
                    </div>
                    <!--START-->
                    <div class="profile">
                        <div class="job-days">
                            <?php if ($expert_user_details_row['user_plan'] == 4 || $expert_user_details_row['user_plan'] == 3 ) { ?>
                            <span class="ver"><i class="material-icons" title="Verified expert">verified_user</i></span>
                            <?php
                            }
                            ?>
                            <?php
                            if ($star_rate_two != 0) {
                                ?>
                                <span class="rat" title="User rating 5 out of"><?php echo $star_rate_two; ?></span>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="jpro-ban-bg-img">
                            <span><?php echo $Zitiziti['SERVICE-EXPERT-STATUS']; ?>: <b><?php
                                    if($expert_profile_row['expert_availability_status'] == 0){ echo $Zitiziti['SERVICE-EXPERT-AVAILABLE-LABEL']; }
                                    elseif($expert_profile_row['expert_availability_status'] == 1){ echo $Zitiziti['SERVICE-EXPERT-BUSY-LABEL']; }
                                    elseif($expert_profile_row['expert_availability_status'] == 2){ echo $Zitiziti['SERVICE-EXPERT-CLOSED-TODAY-LABEL']; } ?></b></span>
                            <img
                                src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="b-lazy" data-src="<?php echo $slash; ?>service-experts/images/services/<?php echo $expert_profile_row['cover_image']; ?>"
                                alt="">
                        </div>
                        <div class="jpro-ban-tit">
                            <div class="s1">
                                <img
                                    src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="b-lazy" data-src="<?php echo $slash; ?>service-experts/images/services/<?php echo $expert_profile_row['profile_image']; ?>"
                                    alt="">
                            </div>
                            <div class="s2">
                                <h1><?php echo $expert_profile_row['profile_name']; ?></h1>
                                <span class="loc"><?php echo $expert_city_name; ?></span>
                                <p><?php echo $expert_category_name; ?></p>
                            </div>
                            <div class="s3">
                                <span
                                    class="cta fol comm-msg-act-btn" data-toggle="modal" data-target="#expfrm"><?php echo $Zitiziti['SERVICE-EXPERT-BOOK-NOW']; ?></span>
                                <span class="cta" data-toggle="modal"
                                      data-target="#expwrirevi"><?php echo $Zitiziti['LISTING_DETAILS_WRITE_REVIEW']; ?></span>
                            </div>
                        </div>
                    </div>
                    <!--END-->
                    <!--START-->
                    <div class="jb-pro-bio">
                        <h4><?php echo $Zitiziti['SERVICE-EXPERT-EXPERT-DETAILS']; ?></h4>
                        <ul>
                            <li>
                                <?php echo $Zitiziti['SERVICE-EXPERT-SERVICES-DONE']; ?>
                                <span><?php echo AddingZero_BeforeNumber(getIdCountFinishedExpertEnquiries($expert_id)); ?></span>
                            </li>
                            <li>
                                <?php echo $Zitiziti['SERVICE-EXPERT-EXPERIENCE']; ?>
                                <span><?php echo $expert_profile_row['years_of_experience']; ?> <?php echo $Zitiziti['SERVICE-EXPERT-YEARS-TEXT']; ?></span>
                            </li>
                            <li>
                                <?php echo $Zitiziti['SERVICE-EXPERT-BASE-FARE']; ?>
                                <span><?php if($footer_row['currency_symbol_pos']== 1){ echo $footer_row['currency_symbol']; } ?><?php echo $expert_profile_row['base_fare']; ?><?php if($footer_row['currency_symbol_pos']== 2){ echo $footer_row['currency_symbol']; } ?></span>
                            </li>
                            <li>
                                <?php echo $Zitiziti['SERVICE-EXPERT-VERIFIED']; ?>
                                <span><?php echo $Zitiziti['SERVICE-EXPERT-YES-TEXT']; ?></span>
                            </li>
                            <li>
                                <?php echo $Zitiziti['SERVICE-EXPERT-LOCATION']; ?>
                                <span><?php echo $expert_city_name; ?></span>
                            </li>
                            <li>
                                <?php echo $Zitiziti['SERVICE-EXPERT-JOIN-DATE']; ?>
                                <span><?php echo dateFormatconverter($expert_profile_row['expert_cdt']); ?></span>
                            </li>
                            <li>
                                <?php echo $Zitiziti['SERVICE-EXPERT-SERVICE-TIME']; ?>
                                <span><?php echo $expert_profile_row['available_time_start']; ?> <?php echo $Zitiziti['SERVICE-EXPERT-TO-TEXT']; ?> <?php echo $expert_profile_row['available_time_end']; ?></span>
                            </li>
                        </ul>
                    </div>
                    <!--END-->
                    <!--START-->
                    <div class="jpro-bd">
                        <?php if ($expert_profile_row['area_id'] != NULL) { ?>
                            <div class="jpro-bd-com">
                                <h4><?php echo $Zitiziti['SERVICE-EXPERT-SERVICE-AREAS']; ?></h4>
                                <?php
                                $area_set = explode(',', $expert_profile_row['area_id']);
                                foreach ($area_set as $area_set_id) {
                                    $area_name = getExpertArea($area_set_id);
                                    ?>
                                    <span><?php echo $area_name['city_name']; ?></span>
                                    <?php
                                }
                                ?>
                            </div>
                        <?php } ?>
                        <?php if ($expert_profile_row['sub_category_id'] != NULL) { ?>
                            <div class="jpro-bd-com">
                                <h4><?php echo $Zitiziti['SERVICE-EXPERT-SERVICES-CAN-DO']; ?></h4>
                                <?php
                                $sub_category = explode(',', $expert_profile_row['sub_category_id']);
                                foreach ($sub_category as $sub_category_id) {
                                    $sub_category_name = getExpertSubCategory($sub_category_id);
                                    ?>
                                    <span><?php echo $sub_category_name['sub_category_name']; ?></span>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="jpro-bd-com">
                            <h4><?php echo $Zitiziti['SERVICE-EXPERT-EXPERIENCE']; ?></h4>
                            <ul>
                                <?php
                                if ($expert_profile_row['experience_1'] != NULL) {
                                    ?>
                                    <li><?php echo $expert_profile_row['experience_1']; ?></li>
                                    <?php
                                }
                                if ($expert_profile_row['experience_2'] != NULL) {
                                    ?>
                                    <li><?php echo $expert_profile_row['experience_2']; ?></li>
                                    <?php
                                }
                                if ($expert_profile_row['experience_3'] != NULL) {
                                    ?>
                                    <li><?php echo $expert_profile_row['experience_3']; ?></li>
                                    <?php
                                }
                                if ($expert_profile_row['experience_4'] != NULL) {
                                    ?>
                                    <li><?php echo $expert_profile_row['experience_4']; ?></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="jpro-bd-com">
                            <h4><?php echo $Zitiziti['SERVICE-EXPERT-EDUCATION']; ?></h4>
                            <ul>
                                <?php
                                if ($expert_profile_row['education_1'] != NULL) {
                                    ?>
                                    <li><?php echo $expert_profile_row['education_1']; ?></li>
                                    <?php
                                }
                                if ($expert_profile_row['education_2'] != NULL) {
                                    ?>
                                    <li><?php echo $expert_profile_row['education_2']; ?></li>
                                    <?php
                                }
                                if ($expert_profile_row['education_3'] != NULL) {
                                    ?>
                                    <li><?php echo $expert_profile_row['education_3']; ?></li>
                                    <?php
                                }
                                if ($expert_profile_row['education_4'] != NULL) {
                                    ?>
                                    <li><?php echo $expert_profile_row['education_4']; ?></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="jpro-bd-com">
                            <h4><?php echo $Zitiziti['SERVICE-EXPERT-ADDITIONAL-INFORMATION']; ?></h4>
                            <?php
                            if ($expert_profile_row['additional_info_1'] != NULL) {
                                ?>
                                <span><?php echo $expert_profile_row['additional_info_1']; ?></span>
                                <?php
                            }
                            if ($expert_profile_row['additional_info_2'] != NULL) {
                                ?>
                                <span><?php echo $expert_profile_row['additional_info_2']; ?></span>
                                <?php
                            }
                            if ($expert_profile_row['additional_info_3'] != NULL) {
                                ?>
                                <span><?php echo $expert_profile_row['additional_info_3']; ?></span>
                                <?php
                            }
                            if ($expert_profile_row['additional_info_4'] != NULL) {
                                ?>
                                <span><?php echo $expert_profile_row['additional_info_4']; ?></span>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                        $review_count = getCountExpertExpertReview($expert_id); //Expert Reviews Count
                        if ($review_count > 0) {

                            ?>
                            <div class="jpro-bd-com">
                                <h4><?php echo $Zitiziti['SERVICE-EXPERT-USER-REVIEWS']; ?></h4>
                                <div class="lp-ur-all-rat">
                                    <ul>
                                        <?php
                                        foreach (getAllExpertExpertReviews($expert_id) as $reviewsqlrow) {

                                            $review_user_id = $reviewsqlrow['review_user_id'];

                                            $total_per_user_rating = number_format(($reviewsqlrow['expert_rating']), 1);

                                            $revuser_details_row = getUser($review_user_id); // To Fetch particular User Data

                                            ?>
                                            <li>
                                                <div class="lr-user-wr-img"><img
                                                        src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="b-lazy" data-src="<?php echo $slash; ?>images/user/<?php if (($revuser_details_row['profile_image'] == NULL) || empty($revuser_details_row['profile_image'])) {
                                                            echo $footer_row['user_default_image'];
                                                        } else {
                                                            echo $revuser_details_row['profile_image'];
                                                        } ?>"
                                                        alt="">
                                                </div>
                                                <div class="lr-user-wr-con">
                                                    <h6><?php echo $revuser_details_row['first_name']; ?></h6>
                                                    <label class="rat">
                                                        <?php if ($reviewsqlrow['expert_rating'] == 1) { ?>
                                                            <i class="material-icons">star</i>
                                                            <i class="material-icons">star_border</i>
                                                            <i class="material-icons">star_border</i>
                                                            <i class="material-icons">star_border</i>
                                                            <i class="material-icons">star_border</i>
                                                        <?php } ?>
                                                        <?php if ($reviewsqlrow['expert_rating'] == 2) { ?>
                                                            <i class="material-icons">star</i>
                                                            <i class="material-icons">star</i>
                                                            <i class="material-icons">star_border</i>
                                                            <i class="material-icons">star_border</i>
                                                            <i class="material-icons">star_border</i>
                                                        <?php } ?>
                                                        <?php if ($reviewsqlrow['expert_rating'] == 3) { ?>
                                                            <i class="material-icons">star</i>
                                                            <i class="material-icons">star</i>
                                                            <i class="material-icons">star</i>
                                                            <i class="material-icons">star_border</i>
                                                            <i class="material-icons">star_border</i>
                                                        <?php } ?>
                                                        <?php if ($reviewsqlrow['expert_rating'] == 4) { ?>
                                                            <i class="material-icons">star</i>
                                                            <i class="material-icons">star</i>
                                                            <i class="material-icons">star</i>
                                                            <i class="material-icons">star</i>
                                                            <i class="material-icons">star_border</i>
                                                        <?php } ?>
                                                        <?php if ($reviewsqlrow['expert_rating'] == 5) { ?>
                                                            <i class="material-icons">star</i>
                                                            <i class="material-icons">star</i>
                                                            <i class="material-icons">star</i>
                                                            <i class="material-icons">star</i>
                                                            <i class="material-icons">star</i>
                                                        <?php } ?>
                                                    </label>
                                                    <span
                                                        class="lr-revi-date"><?php echo dateFormatconverter($reviewsqlrow['review_cdt']); ?></span>
                                                    <p><?php echo stripslashes($reviewsqlrow['expert_message']); ?></p>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <?php
                        }else {
                            if ($session_user_id != NULL) {
                                ?>
                                <div
                                    class="spa-first-review"><?php echo $Zitiziti['SERVICE-EXPERT-BE-FIRST-REVIEW']; ?></div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <!--END-->
                </div>

                <!-- booking system form start  -->
                <div class="modal fade" id="booking">
                    <div class="modal-dialog">
                        <div class="modal-content" style="margin-top: 30%;">
                            <div class="log-bor">&nbsp;</div>
                            <span class="udb-inst">Booking</span>
                            <button type="button" class="close" data-dismiss="modal" style="margin-left: 92%;">&times;</button>
                            <div class="quote-pop">
                                <form method="post" action="/booking_insert.php" enctype="multipart/form-data">
                                    <input type="hidden" name="booking_type" value="service_expert">
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
                <div class="rhs">
                    <div class="ud-rhs-promo">
                        <h3><?php echo $Zitiziti['SERVICE-EXPERTS-PROFILE-HEADER-TEXT']; ?></h3>
                        <p><?php echo $Zitiziti['SERVICE-EXPERTS-PROFILE-P-TEXT']; ?></p>
                        <a href="<?php echo $slash; ?>login"><?php echo $Zitiziti['JOB-PROFILE-A']; ?></a>
                    </div>
                    
                    <?php
                    if (isset($_SESSION['status_msg'])) {
                        include "../page_level_message.php";
                        unset($_SESSION['status_msg']);
                    }
                    if($expert_profile_row['is_booking'] == 0 && $expert_profile_row['booking_url'] != ''){
                    ?>
                        <a href="<?php echo $expert_profile_row['booking_url']; ?>"><button  class="booking-btn"><?php echo $Zitiziti['SERVICE-EXPERT-BOOK-NOW']; ?></button></a>
                    <?php
                    }elseif($expert_profile_row['is_booking'] == 1) {
                    ?>
                        <button class="booking-btn" data-toggle="modal" data-target="#booking"><?php echo $Zitiziti['SERVICE-EXPERT-BOOK-NOW']; ?></button>

                    <?php
                    }
                    ?>
                    <?php
                    if($footer_row['admin_service_expert_mobile'] != NULL || $footer_row['admin_service_expert_email'] != NULL || $footer_row['admin_service_expert_whatsapp'] != NULL) {
                        ?>
                        <div class="ud-rhs-promo exp-rel-supp">
                            <h3><?php echo $Zitiziti['SERVICE-EXPERTS-PROFILE-CUSTOMER-SUPPORT']; ?></h3>
                            <ul>
                                <?php
                                if ($footer_row['admin_service_expert_mobile'] != NULL) {
                                    ?>
                                    <li>
                                        <i class="material-icons">local_phone</i>: <a
                                            href="tel:<?php echo $footer_row['admin_service_expert_mobile']; ?>"><?php echo $footer_row['admin_service_expert_mobile']; ?></a>
                                    </li>
                                    <?php
                                }
                                if ($footer_row['admin_service_expert_email'] != NULL) {
                                    ?>
                                    <li>
                                        <i class="material-icons">email</i>: <a
                                            href="mail:<?php echo $footer_row['admin_service_expert_email']; ?>"><?php echo $footer_row['admin_service_expert_email']; ?></a>
                                    </li>
                                    <?php
                                }
                                if ($footer_row['admin_service_expert_whatsapp'] != NULL) {
                                    ?>
                                    <li>
                                        <i class="material-icons">chat_bubble_outline</i>: <a
                                            href="tel:<?php echo $footer_row['admin_service_expert_whatsapp']; ?>"><?php echo $footer_row['admin_service_expert_whatsapp']; ?>
                                            (<?php echo $Zitiziti['WHATSAPP']; ?>)</a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="job-rel-pro">
                        <div class="hot-page2-hom-pre">
                            <h4><?php echo $Zitiziti['JOB-RELATED-PROFILES']; ?></h4>
                            <ul>
                                <?php
                                foreach (getExceptExpertsCategoryExpert($expert_profile_category_id, $expert_id) as $except_list_row) {

                                $except_expert_id = $except_list_row['expert_id'];

                                $except_category_id = $except_list_row['category_id'];

                                $except_expert_profile_category_row = getExpertCategory($except_category_id);

                                $except_expert_category_name = $except_expert_profile_category_row['category_name'];

                                // Expert Rating. for Rating of Star
                                foreach (getExpertReview($except_expert_id) as $star_rating_row_except) {
                                    if ($star_rating_row_except["rate_cnt"] > 0) {
                                        $star_rate_times = $star_rating_row_except["rate_cnt"];
                                        $star_sum_rates = $star_rating_row_except["total_rate"];
                                        $star_rate_one = $star_sum_rates / $star_rate_times;
                                        $star_rate_two = number_format($star_rate_one, 1);
                                        $star_rate = floatval($star_rate_two);

                                    } else {
                                        $rate_times = 0;
                                        $rate_value = 0;
                                        $star_rate = 0;
                                    }
                                }

                                ?><!-- Expert Service -->
                                <li>
                                    <div class="hot-page2-hom-pre-1">
                                        <img loading="lazy" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="b-lazy" data-src="<?php echo $slash; ?>service-experts/images/services/<?php echo $except_list_row['profile_image']; ?>" alt="">
                                    </div>
                                    <div class="hot-page2-hom-pre-2">
                                        <h5><?php echo $except_list_row['profile_name']; ?> <span class="rat"><?php echo $star_rate_two; ?></span></h5>
                                        <span><b><?php echo $except_expert_category_name; ?></b></span>
                                    </div>
                                    <a href="<?php echo $SERVICE_EXPERT_URL . urlModifier($except_list_row['expert_slug']); ?>" class="fclick"></a>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="job-rel-pro">
                        <div class="hot-page2-hom-pre">
                            <h4><?php echo $Zitiziti['SERVICE-EXPERT-TRENDING-SERVICES']; ?></h4>
                            <ul>
                                <?php
                                foreach (getExceptAllExpertCategories($expert_profile_category_id) as $except_category_row) {

                                    $except_category_id = $except_category_row['category_id'];

                                    $except_expert_profile_category_row = getExpertCategory($except_category_id);

                                    $except_category_name = $except_category_row['category_name'];

                                    $total_experts_category = getCountCategoryExperts($except_category_id);

                                    ?>
                                    <li>
                                        <div class="hot-page2-hom-pre-1">
                                            <img loading="lazy" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="b-lazy" data-src="<?php echo $slash; ?>service-experts/images/services/<?php echo $except_category_row['category_image']; ?>" alt="">
                                        </div>
                                        <div class="hot-page2-hom-pre-2">
                                            <h5><?php echo $except_category_name; ?></h5>
                                            <span><b><?php echo AddingZero_BeforeNumber($total_experts_category); ?> <?php echo $Zitiziti['SERVICE-EXPERTS-EXPERTS']; ?></b>, <?php echo AddingZero_BeforeNumber(getCategoryCountFinishedExpertEnquiries($except_category_id)); ?> <?php echo $Zitiziti['SERVICE-EXPERT-SERVICES-DONE']; ?></span>
                                        </div>
                                        <a href="<?php echo $ALL_EXPERTS_URL . urlModifier($except_category_row['category_slug']); ?>" class="fclick"></a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END -->


<?php
include "../footer.php";
?>

<!-- START -->
<section>
    <div class="pop-ups pop-quo">
        <!-- The Modal -->
        <div class="modal fade" id="expfrm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="log-bor">&nbsp;</div>
                    <span class="udb-inst">Contact</span>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <!-- Modal Header -->
                    <div class="quote-pop">
                        <div id="expert_detail_enq_success" class="log" style="display: none;"><p><?php echo $Zitiziti['SERVICE_EXPERT_ENQUIRY_SUCCESSFUL_MESSAGE']; ?></p>
                        </div>
                        <div id="expert_detail_enq_same" class="log" style="display: none;"><p><?php echo $Zitiziti['SERVICE_EXPERT_ENQUIRY_OWN_JOB_MESSAGE']; ?></p>
                        </div>
                        <div id="expert_detail_enq_fail" class="log" style="display: none;"><p><?php echo $Zitiziti['OOPS_SOMETHING_WENT_WRONG']; ?></p>
                        </div>
                        <div class="ser-exp-wel"><?php echo $Zitiziti['SERVICE-EXPERT-HEY-LABEL']; ?> <b><?php echo $expert_profile_row['profile_name']; ?></b></div>
                        <form method="post" name="expert_detail_enquiry_form"
                              id="expert_detail_enquiry_form">
                            <input type="hidden" class="form-control"
                                   name="expert_id"
                                   value="<?php echo $expert_id; ?>"
                                   placeholder=""
                                   required>
                            <input type="hidden" class="form-control"
                                   name="enquiry_category"
                                   value="<?php echo $expert_profile_row['category_id']; ?>"
                                   placeholder=""
                                   required>
                            <input type="hidden" class="form-control"
                                   name="expert_user_id"
                                   value="<?php echo $expert_profile_user_id; ?>" placeholder=""
                                   required>
                            <input type="hidden" class="form-control"
                                   name="enquiry_sender_id"
                                   value="<?php echo $session_user_id; ?>"
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
                                <input type="text" name="enquiry_name"
                                       value="<?php echo $user_details_row['first_name'] ?>"
                                       required="required" class="form-control"
                                       placeholder="<?php echo $Zitiziti['LEAD-NAME-PLACEHOLDER']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control"
                                       placeholder="<?php echo $Zitiziti['ENTER_EMAIL_STAR']; ?>" required="required"
                                       value="<?php echo $user_details_row['email_id'] ?>"
                                       name="enquiry_email"
                                       pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$"
                                       title="<?php echo $Zitiziti['LEAD-INVALID-EMAIL-TITLE']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control"
                                       value="<?php echo $user_details_row['mobile_number'] ?>"
                                       name="enquiry_mobile"
                                       placeholder="<?php echo $Zitiziti['LEAD-MOBILE-PLACEHOLDER']; ?>"
                                       pattern="[7-9]{1}[0-9]{9}"
                                       title="<?php echo $Zitiziti['LEAD-INVALID-MOBILE-TITLE']; ?>"
                                       required>
                            </div>
                            <div class="form-group">
                                <select class="chosen-select" disabled="disabled" required="required" name="enquiry_category_old">
                                    <option value=""><?php echo $Zitiziti['SELECT_CATEGORY']; ?></option>
                                    <?php
                                    foreach (getAllActiveExpertCategoriesPos() as $lead_categories_row) {
                                        ?>
                                        <option <?php if($expert_profile_row['category_id'] == $lead_categories_row['category_id']){ echo 'selected';} ?> value="<?php echo $lead_categories_row['category_id']; ?>"><?php echo $lead_categories_row['category_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6 serex-date">
                                <input type="text" class="form-control" name="enquiry_date"
                                       placeholder="<?php echo $Zitiziti['SERVICE-EXPERT-PREFERRED-DATE']; ?>" id="newdate">
                            </div>
                            <div class="form-group col-md-6 serex-time">
                                <select class="chosen-select" name="enquiry_time">
                                    <option value=""><?php echo $Zitiziti['SERVICE-EXPERT-PREFERRED-TIME']; ?></option>
                                    <?php
                                    $start_time = $expert_profile_row['available_time_start'];
                                    $new_start_time1 = strtotime('-60mins', strtotime($start_time));
                                    $new_start_time = date('g:i A', $new_start_time1); // format the next time

                                    $end_time = $expert_profile_row['available_time_end'];
                                    $new_end_time1 = strtotime('+60mins', strtotime($end_time));
                                    $new_end_time = date('g:i A', $new_end_time1); // format the next time

                                    $workingHours = (((strtotime($new_end_time) - strtotime($start_time)) / 3600)-1);

                                    $time = $new_start_time; // start
                                    for ($i = 0; $i <= $workingHours; $i++) {
                                        $prev = date('g:i a', strtotime($time)); // format the start time
                                        $next = strtotime('+60mins', strtotime($time)); // add 60 mins
                                        $time = date('g:i A', $next); // format the next time
                                        ?>
                                        <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="enquiry_location" id="enquiry_location" placeholder="<?php echo $Zitiziti['LEAD-LOCATION-PLACEHOLDER']; ?>"></textarea>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="enquiry_message" id="enquiry_message" placeholder="<?php echo $Zitiziti['LEAD-MESSAGE-PLACEHOLDER']; ?>"></textarea>
                            </div>
                            <input type="hidden" name="" id="source">
                            <button <?php if ($session_user_id == NULL || empty($session_user_id)) {
                                ?> disabled="disabled" <?php } ?> type="submit" id="expert_detail_enquiry_submit"
                                                                  name="expert_detail_enquiry_submit"
                                                                  class="btn btn-primary"><?php if ($session_user_id == NULL || empty($session_user_id)) {
                                    ?> <?php echo $Zitiziti['LOG_IN_TO_SUBMIT']; ?> <?php } else { ?><?php echo $Zitiziti['SUBMIT']; ?> <?php } ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--- END --->
        <!-- WRITE REVIEW -->
        <div class="modal fade" id="expwrirevi">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="exper-rev-box">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="tit">
                            <h4><?php echo $Zitiziti['SERVICE-EXPERT-WRITE-A-REVIEW-LABEL']; ?></h4>
                        </div>
                        <div class="prof">
                            <img
                                src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="b-lazy" data-src="<?php echo $slash; ?>service-experts/images/services/<?php echo $expert_profile_row['profile_image']; ?>"
                                alt="">
                            <h3><?php echo $expert_profile_row['profile_name']; ?></h3>
                            <p><?php echo $Zitiziti['SERVICE-EXPERT-REVIEW-P-LABEL']; ?></p>
                        </div>
                        <?php if (empty($session_user_id) || $session_user_id == Null || ($expert_profile_user_id == $session_user_id)) {
                            ?>
                            <?php if (empty($session_user_id) || $session_user_id == Null) {
                                ?>
                                <span style="text-align:center;display: block;color: red;" id=""><?php echo $Zitiziti['LISTING_DETAILS_LOGIN_AND_WRITE_REVIEW']; ?></span>
                                <?php
                            }
                            if ($expert_profile_user_id == $session_user_id) { ?>
                                <span style="text-align:center;display: block;color: red;" id=""><?php echo $Zitiziti['SERVICE-EXPERT-CANT-REVIEW-OWN-SERVICE']; ?></span>
                                <?php
                            }
                        } else {
                            ?>
                            <form class="col" name="expert_review_form" id="expert_review_form" method="post">
                                <input type="hidden" class="form-control" name="expert_id"
                                       value="<?php echo $expert_profile_row['expert_id']; ?>">
                                <input type="hidden" class="form-control" name="expert_user_id"
                                       value="<?php echo $expert_profile_user_id; ?>">
                                <input name="review_user_id" value="<?php echo $session_user_id; ?>"
                                       type="hidden"
                                >
                                <div id="expert_review_success"
                                     style="text-align:center;display: none;color: green;"><?php echo $Zitiziti['LISTING_DETAILS_REVIEW_SUCCESS_MESSAGE']; ?>
                                </div>
                                <div id="expert_review_fail"
                                     style="text-align:center;display: none;color: red;"><?php echo $Zitiziti['OOPS_SOMETHING_WENT_WRONG']; ?></div>
                                <div class="rating-new">
                                    <fieldset class="rating">
                                        <input type="radio" id="star5" name="expert_rating"
                                               class="expert_rating" value="5"/>
                                        <label class="full" for="star5" title="Awesome"></label>
                                        <input type="radio" id="star4" name="expert_rating"
                                               class="expert_rating" value="4"/>
                                        <label class="full" for="star4" title="Excellent"></label>
                                        <input type="radio" id="star3"
                                               class="expert_rating" name="expert_rating" value="3"/>
                                        <label class="full" for="star3" title="Good"></label>
                                        <input type="radio" id="star2" name="expert_rating"
                                               class="expert_rating" value="2"/>
                                        <label class="full" for="star2" title="Average"></label>
                                        <input type="radio" id="star1" name="expert_rating"
                                               class="expert_rating" value="1" checked="checked"/>
                                        <label class="full" for="star1" title="Poor"></label>
                                    </fieldset>
                                    <div id="star-value">3 Star</div>
                                </div>
                                <div class="rating-new-msg">
                                    <textarea name="expert_message"
                                              placeholder="<?php echo $Zitiziti['SERVICE-EXPERT-REVIEW-WRITE-YOUR-COMMENTS-LABEL']; ?>"></textarea>
                                </div>
                                <div class="rating-new-cta">
                                    <span data-dismiss="modal">Not now</span>
                                    <button type="submit" name="expert_review_submit"
                                            id="expert_review_submit"><?php echo $Zitiziti['SERVICE-EXPERT-REVIEW-SUBMIT-REVIEW']; ?></button>
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- END -->

<!--- CHAT NEW BOX START --->
<div class="msg-op msg-op-new">
    <span class="comm-msg-pop-clo1"><i class="material-icons">close</i></span>
    <div class="inn">
        <form name="new_chat_form" id="new_chat_form" method="post">
            <div class="s1">
                <img
                    src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="b-lazy" data-src="<?php echo $slash; ?>images/user/<?php if (($user_details_row['profile_image'] == NULL) || empty($user_details_row['profile_image'])) {
                        echo $footer_row['user_default_image'];
                    } else {
                        echo $user_details_row['profile_image'];
                    } ?>" alt="">
                <h4><b>Rn53 Themes <span class="ser-avail-yes" title="Availabale online"></span></b>Chennai</h4>
            </div>
            <div class="s2 chat-box-messages">
                <!-- FROM -->
                <div><?php echo $Zitiziti['COMMUNITY-PAGE-START-A-NEW-CHAT']; ?></div>
            </div>
            <div class="s3">
                <input type="text" name="chat_message" id="chat_message"
                       placeholder="<?php echo $Zitiziti['DB-MESSAGES-PLACEHOLDER']; ?>" required="">
                <button id="chat_send" name="chat_send" type="submit"><?php echo $Zitiziti['SEND']; ?> <i
                        class="material-icons">send</i></button>
            </div>
        </form>
    </div>
</div>
<!--- END --->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?php echo $slash; ?>js/jquery.min.js"></script>
<script src="<?php echo $slash; ?>js/popper.min.js"></script>
<script src="<?php echo $slash; ?>js/bootstrap.min.js"></script>
<script src="<?php echo $slash; ?>js/jquery-ui.js"></script>
<script src="<?php echo $slash; ?>js/blazy.min.js"></script>
<script type="text/javascript">var webpage_full_link = '<?php echo $webpage_full_link;?>';</script>
<script type="text/javascript">var login_url = '<?php echo $LOGIN_URL;?>';</script>
<script src="<?php echo $slash; ?>js/select-opt.js"></script>
<script src="<?php echo $slash; ?>js/custom.js"></script>
<script src="<?php echo $slash; ?>js/jquery.validate.min.js"></script>
<script src="<?php echo $slash; ?>js/custom_validation.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

<script>
    $(function() {
        // Date picker configuration
        $("#booking_date").datepicker({
            minDate: 0, 
            beforeShowDay: function(date) {
                var day = date.getDay(); 
                var dateString = $.datepicker.formatDate('yy-mm-dd', date);

                var isDisabled = existDays.some(function(existingDate) {
                    // Extract date (ignoring time part) from the existing booking date
                    var existingDateString = existingDate.split(' ')[0];
                    return existingDateString === dateString;
                });

                return [
                    availableDays.indexOf(day) !== -1 && !isDisabled,
                    !isDisabled, "", ""
                ];
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
            var dayOfWeek = new Date(selectedDate).getDay(); // Get the day of the week (0 = Sunday, 1 = Monday, etc.)

            // console.log("Selected day of the week: " + dayOfWeek);

            // If the day is available, enable the time picker and set available times
            if (availableDays.indexOf(dayOfWeek) !== -1) {
                // Find the available slots for the selected day
                var daySlots = availableSlots.find(function(slot) {
                    return slot.day === dayOfWeek; // Match the selected day
                });

                // Check if daySlots are found and contain valid start_time and end_time
                if (daySlots && daySlots.start_time && daySlots.end_time) {
                    var startTime = daySlots.start_time;
                    var endTime = daySlots.end_time;

                    // Generate time slots between start and end times
                    var timeSlots = generateTimeSlots(startTime, endTime, 30); // 30-minute intervals

                    $('#booking_time').empty();
                    
                    timeSlots.forEach(function(timeSlot) {
                        console.log(timeSlot); // Logging the time slot to make sure the array is correct
                        $('#booking_time').append('<option value="' + timeSlot + '">' + timeSlot + '</option>');
                    });
                } 
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

        // Convert time in 'HH:mm' format to total minutes
        function convertToMinutes(time) {
            var timeParts = time.split(':');
            return parseInt(timeParts[0]) * 60 + parseInt(timeParts[1]);
        }

        // Convert minutes back to 'HH:mm' format
        function convertToTimeFormat(minutes) {
            var hours = Math.floor(minutes / 60);
            var mins = minutes % 60;
            if (mins < 10) {
                mins = '0' + mins;
            }
            return hours + ':' + mins;
        }
    });

    $(document).ready(function () {
        $('input[name="expert_rating"]').change(function () {
            if ($('#star0').prop('checked')) {
                $("#star-value").html('0 Star');
            }
            else if ($('#star1').prop('checked')) {
                $("#star-value").html('1 Star');
            }
            else if ($('#star2').prop('checked')) {
                $("#star-value").html('2 Star');
            }
            else if ($('#star3').prop('checked')) {
                $("#star-value").html('3 Star');
            }
            else if ($('#star4').prop('checked')) {
                $("#star-value").html('4 Star');
            }
            else if ($('#star5').prop('checked')) {
                $("#star-value").html('5 Star');
            }
        });
    });

</script>
</body>

</html>