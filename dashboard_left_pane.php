<style>
    p.notify001 {
        color: #fff;
        background-color: #e62525;
        width: 1.5vw;
        height: 3vh;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 41px;
        font-size: 12px;
        position: absolute;
        left: 35px;
    }

    .ud-lhs-s2 ul li button {
        font-weight: 500;
        color: #435769 !important;
        font-size: 12px;
        display: block;
        padding: 7px 17px;
        margin-right: 15px;
        background-color: #d9e4ee;
        border: none;
    }

    .ud-lhs-s2 ul li button img {
        width: 28px;
        margin-right: 15px;
        padding: 3px;
        border-radius: 2px;
        margin-top: -2px;
    }

    .ud-lhs-s2 ul li button:hover {
        background: #d0dbe5;
        border-radius: 0 50px 50px 0
    }
</style>
<!-- START -->
<!--PRICING DETAILS-->
<section class="<?php if ($footer_row['admin_language'] == 2) {
                    echo "lg-arb";
                } ?> ud">
    <div class="ud-inn ">
        <!--LEFT SECTION-->
        <div class="ud-lhs">
            <div class="ud-lhs-s1">
                <img
                    src="<?php echo $slash; ?>images/user/<?php if (($user_details_row['profile_image'] == NULL) || empty($user_details_row['profile_image'])) {
                                                                echo $footer_row['user_default_image'];
                                                            } else {
                                                                echo $user_details_row['profile_image'];
                                                            } ?>" alt="">
                <div class="ud-lhs-pro-bio">
                    <h4><?php echo $user_details_row['first_name']; ?></h4>
                    <b><?php echo $Zitiziti['JOIN_ON']; ?> <?php echo dateFormatconverter($user_details_row['user_cdt']) ?></b>
                    <a class="ud-lhs-view-pro" target="_blank"
                        href="<?php echo $PROFILE_URL . urlModifier($user_details_row['user_slug']); ?>"><?php echo $Zitiziti['MY_PROFILE']; ?></a>
                </div>
            </div>
            <div class="ud-lhs-s2">
                <ul>
                    <li>
                        <a href="<?php echo $slash; ?>dashboard" class="<?php if ($current_page == "dashboard.php") {
                                                                            echo "db-lact";
                                                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/dbl1.png"
                                alt="" /> <?php echo $Zitiziti['MY_DASHBOARD']; ?></a>
                    </li>
                    <?php
                    if ($user_details_row['user_type'] == "Service provider") {  //To Check User type is Service provider
                    ?>
                        <?php if ($footer_row['admin_listing_show'] == 1 && $user_details_row['setting_listing_show'] == 1) { ?>
                            <li>
                                <h4><?php echo $Zitiziti['DASH-LHS-ALL-MOD']; ?></h4>
                                <a href="<?php echo $slash; ?>db-all-listing"
                                    class="<?php if ($current_page == "db-all-listing.php") {
                                                echo "db-lact";
                                            } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/shop.png"
                                        alt="" /><?php echo $Zitiziti['ALL_LISTING']; ?></a>
                            </li>
                        <?php } ?>
                        <?php if ($footer_row['admin_job_show'] == 1 && $user_details_row['setting_job_show'] == 1) { ?>
                            <li>
                                <a href="<?php echo $slash; ?>jobs/db-jobs"
                                    class="<?php if ($current_page == "db-jobs.php") {
                                                echo "db-lact";
                                            } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/employee.png"
                                        alt="" /><?php echo $Zitiziti['JOBS']; ?></a>
                            </li>
                        <?php } ?>
                        <?php if ($footer_row['admin_product_show'] == 1 && $user_details_row['setting_product_show'] == 1) { ?>
                            <li>
                                <a href="<?php echo $slash; ?>db-products"
                                    class="<?php if ($current_page == "db-products.php") {
                                                echo "db-lact";
                                            } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/cart.png"
                                        alt="" /><?php echo $Zitiziti['ALL_PRODUCTS']; ?></a>
                            </li>
                        <?php } ?>
                        <?php if ($footer_row['admin_event_show'] == 1 && $user_details_row['setting_event_show'] == 1) { ?>
                            <li>
                                <a href="<?php echo $slash; ?>db-events"
                                    class="<?php if ($current_page == "db-events.php") {
                                                echo "db-lact";
                                            } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/calendar.png"
                                        alt="" /><?php echo $Zitiziti['EVENTS']; ?></a>
                            </li>
                        <?php } ?>
                        <?php if ($footer_row['admin_blog_show'] == 1 && $user_details_row['setting_blog_show'] == 1) { ?>
                            <li>
                                <a href="<?php echo $slash; ?>db-blog-posts"
                                    class="<?php if ($current_page == "db-blog-posts.php") {
                                                echo "db-lact";
                                            } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/blog1.png"
                                        alt="" /><?php echo $Zitiziti['BLOG_POSTS']; ?></a>
                            </li>
                        <?php } ?>

                        <?php if ($footer_row['admin_coupon_show'] == 1 && $user_details_row['setting_coupon_show'] == 1) { ?>
                            <li>
                                <a href="<?php echo $slash; ?>db-coupons"
                                    class="<?php if ($current_page == "db-coupons.php") {
                                                echo "db-lact";
                                            } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/coupons.png"
                                        alt="" /><?php echo $Zitiziti['COUPONS']; ?></a>
                            </li>
                        <?php } ?>

                        <?php if ($footer_row['admin_listing_show'] == 1 && $user_details_row['setting_listing_show'] == 1) { ?>
                            <li>
                                <h4><?php echo $Zitiziti['DASH-LHS-LEAD']; ?></h4>
                                <a href="<?php echo $slash; ?>db-enquiry"
                                    class="<?php if ($current_page == "db-enquiry.php") {
                                                echo "db-lact";
                                            } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/tick.png"
                                        alt="" /><?php echo $Zitiziti['LEAD_ENQUIRY']; ?></a>
                            </li>
                        <?php } ?>
                        <?php if ($footer_row['admin_expert_show'] == 1 && $user_details_row['setting_expert_show'] == 1) { ?>
                            <li>
                                <a href="<?php echo $slash; ?>service-experts/db-service-expert"
                                    class="<?php if ($current_page == "db-service-expert.php") {
                                                echo "db-lact";
                                            } ?>"><img
                                        src="<?php echo $slash; ?>images/icon/expert.png"
                                        alt="" /><?php echo $Zitiziti['ALL_SERVICE_EXPERT_LEADS']; ?></a>
                            </li>
                        <?php } ?>

                        <?php
                        $bookings = "SELECT seen_count FROM " . TBL . "bookings WHERE seen_count = '0'";
                        $exist_day_result = mysqli_query($conn, $bookings);

                        ?>
                        <li>
                            <form action="../status_update.php" method="POST">
                                <input type="hidden" value="1" name="seen_count">
                                <button type="submit" class="<?php if ($current_page == "business-all-bookings.php") {
                                        echo "db-lact";
                                    } ?>">
                                    <?php
                                    $booking_count = mysqli_num_rows($exist_day_result);
                                    if ($booking_count > 0) {
                                        echo '<p class="notify001">' . $booking_count . '</p>';
                                    }
                                    ?>
                                    <img src="<?php echo $slash; ?>images/icon/booking.png" alt="" />
                                    <?php echo $Zitiziti['BOOKING_ENQUIRY']; ?>
                                </button>
                            </form>

                            <!-- <a href="<?php echo $slash; ?>business-all-bookings.php" class="<?php
                                if ($current_page == "business-all-bookings.php") {
                                    echo "db-lact";
                                } ?>">
                               <img src="<?php echo $slash; ?>images/icon/booking.png" alt=""/>
                               <?php echo $Zitiziti['BOOKING_ENQUIRY']; ?>
                            </a> -->
                        </li>

                        <li>
                            <h4><?php echo $Zitiziti['DASH-LHS-PAY']; ?></h4>
                            <a href="<?php echo $slash; ?>db-payment"
                                class="<?php if ($current_page == "db-payment.php") {
                                            echo "db-lact";
                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/dbl9.png"
                                    alt=""><?php echo $Zitiziti['CHECK_OUT']; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $slash; ?>db-promote"
                                class="<?php if ($current_page == "db-promote.php") {
                                            echo "db-lact";
                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/promotion.png"
                                    alt="" /><?php echo $Zitiziti['PROMOTIONS']; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $slash; ?>db-seo" class="<?php if ($current_page == "db-seo.php") {
                                                                                echo "db-lact";
                                                                            } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/seo.png"
                                    alt="" /><?php echo $Zitiziti['SEO']; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $slash; ?>db-point-history"
                                class="<?php if ($current_page == "db-point-history.php") {
                                            echo "db-lact";
                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/point.png"
                                    alt="" /><?php echo $Zitiziti['POINTS_HISTORY']; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $slash; ?>db-post-ads"
                                class="<?php if ($current_page == "db-post-ads.php") {
                                            echo "db-lact";
                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/dbl11.png"
                                    alt="" /><?php echo $Zitiziti['AD_SUMMARY']; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $slash; ?>db-invoice-all"
                                class="<?php if ($current_page == "db-invoice-all.php") {
                                            echo "db-lact";
                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/dbl16.png"
                                    alt="" /><?php echo $Zitiziti['PAYMENT_INVOICE']; ?></a>
                        </li>
                    <?php
                    }
                    ?>

                    <li>
                        <h4><?php echo $Zitiziti['DASH-LHS-PAGES']; ?></h4>
                        <a href="<?php echo $slash; ?>db-my-profile"
                            class="<?php if ($current_page == "db-my-profile.php" || $current_page == "db-my-profile-edit") {
                                        echo "db-lact";
                                    } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/profile.png"
                                alt="" /><?php echo $Zitiziti['MY_PROFILE']; ?></a>
                    </li>
                    <?php if ($user_details_row['user_type'] == "Service provider" && $footer_row['admin_expert_show'] == 1 && $user_details_row['setting_expert_show'] == 1) { ?>
                        <li>
                            <a href="<?php echo $slash; ?>service-experts/create-service-expert-profile"
                                class="<?php if ($current_page == "create-service-expert-profile.php") {
                                            echo "db-lact";
                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/profile.png"
                                    alt="" /><?php echo $Zitiziti['ADD_NEW_SERVICE_EXPERT']; ?></a>
                        </li>
                    <?php } ?>
                    <?php if ($footer_row['admin_job_show'] == 1 && $user_details_row['setting_job_show'] == 1) { ?>
                        <li>
                            <a href="<?php echo $slash; ?>jobs/create-job-seeker-profile"
                                class="<?php if ($current_page == "create-job-seeker-profile.php") {
                                            echo "db-lact";
                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/profile.png"
                                    alt="" /><?php echo $Zitiziti['PROFI_JOB_SEEKER_TIT']; ?></a>
                        </li>
                    <?php } ?>
                    <?php if ($user_details_row['user_type'] == "General") { ?>
                        <li>
                            <h4><?php echo $Zitiziti['BOOKING']; ?></h4>
                            <a href="<?php echo $slash; ?>user-all-bookings.php"
                                class="<?php if ($current_page == "user-all-bookings.php") {
                                    echo "db-lact";
                                } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/booking.png"
                            alt="" /><?php echo $Zitiziti['BOOKING_ENQUIRY']; ?></a>
                        </li>
                    <?php } ?>
                    <li>
                        <h4><?php echo $Zitiziti['DASH-LHS-ACTI']; ?></h4>
                        <a href="<?php echo $slash; ?>jobs/db-user-applied-jobs"><img
                                src="<?php echo $slash; ?>images/icon/job-apply.png"
                                alt="" /><?php echo $Zitiziti['ALL_APPLIED_JOBS']; ?></a>
                    </li>
                    <?php if ($footer_row['admin_expert_show'] == 1 && $user_details_row['setting_expert_show'] == 1) { ?>
                        <li>
                            <a href="<?php echo $slash; ?>service-experts/db-my-service-bookings"
                                class="<?php if ($current_page == "db-my-service-bookings.php") {
                                            echo "db-lact";
                                        } ?>"><img
                                    src="<?php echo $slash; ?>images/icon/expert-book.png"
                                    alt="" /><?php echo $Zitiziti['MY_SERVICE_BOOKINGS']; ?></a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo $slash; ?>db-review" class="<?php if ($current_page == "db-review.php") {
                                                                            echo "db-lact";
                                                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/dbl13.png"
                                alt="" /><?php echo $Zitiziti['REVIEWS']; ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $slash; ?>db-like-listings"
                            class="<?php if ($current_page == "db-like-listings.php") {
                                        echo "db-lact";
                                    } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/dbl15.png"
                                alt="" /><?php echo $Zitiziti['LIKED_LISTINGS']; ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $slash; ?>db-followings"
                            class="<?php if ($current_page == "db-followings.php") {
                                        echo "db-lact";
                                    } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/dbl18.png"
                                alt="" /><?php echo $Zitiziti['FOLLOWINGS']; ?></a>
                    </li>

                    <li>
                        <a href="<?php echo $slash; ?>db-notifications"
                            class="<?php if ($current_page == "db-notifications.php") {
                                        echo "db-lact";
                                    } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/dbl19.png"
                                alt="" /><?php echo $Zitiziti['NOTIFICATIONS']; ?></a>
                    </li>
                    <li>
                        <h4><?php echo $Zitiziti['DASH-LHS-SETT']; ?></h4>
                        <a href="<?php echo $slash; ?>db-setting" class="<?php if ($current_page == "db-setting.php") {
                                                                                echo "db-lact";
                                                                            } ?>"><img loading="lazy" src="<?php echo $slash; ?>images/icon/dbl210.png"
                                alt="" /><?php echo $Zitiziti['SETTING']; ?></a>
                    </li>
                    <?php
                    if ($user_details_row['user_type'] == "Service provider") {  //To Check User type is Service provider
                    ?>
                        <li>
                            <a href="<?php echo $slash; ?>how-to" class="<?php if ($current_page == "how-to.php") {
                                                                                echo "db-lact";
                                                                            } ?>" target="_blank"><img loading="lazy" src="<?php echo $slash; ?>images/icon/dbl17.png"
                                    alt="" /><?php echo $Zitiziti['HOW_TOS']; ?></a>
                        </li>
                    <?php
                    }
                    ?>
                    <li>
                        <a href="<?php echo $slash; ?>logout"><img loading="lazy" src="<?php echo $slash; ?>images/icon/dbl12.png"
                                alt="" /><?php echo $Zitiziti['LOG_OUT']; ?></a>
                    </li>
                </ul>
            </div>
        </div>