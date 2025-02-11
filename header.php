<?php

/**
 * Created by Vignesh.
 * User: Vignesh
 */

if (file_exists('config/info.php')) {
    include('config/info.php');
}

if (file_exists('functions.php')) {
    include('functions.php');
}

$footer_row = getAllFooter(); //Fetch Footer Data

$admin_row = getAllSuperAdmin(); //Fetch Admin Data

$data_array['website_email_id'] = $footer_row['admin_primary_email'];
$data_array['admin_user_name'] = $admin_row['admin_email'];
$data_array['admin_user_password'] = $admin_row['admin_password'];

$all_texts_row = getAllTexts(); //Fetch All Text Data

if (isset($_SESSION['user_id'])) {

    $user_details_row = getUser($_SESSION['user_id']); //Fetch Logged In user data
    $user_plan = $user_details_row['user_plan']; //Fetch of Logged In user Plan

    $user_plan_type = getPlanType($user_plan); //Fetch Logged In User Plan details and data
    $session_user_id = $_SESSION['user_id'];
}

//Home page preview process
if (isset($_GET['preview']) && isset($_GET['q']) && isset($_GET['type']) && isset($_GET['query'])) {
    $current_home_page = $_GET['type']; //To set Homepage type.
} else {
    $current_home_page = $footer_row['admin_home_page']; //To set Homepage type.
}
$CurrentCity = isset($_SESSION['city']) ? $_SESSION['city'] : 'www';
$imageShow = false;
$imagesLogo = [];
$images = [];
$imageLinks = [];

foreach (getAllCities() as $city) {
    if ($CurrentCity == $city['city_slug']) {
        // Process city logos
        for ($j = 1; $j <= 2; $j++) {
            $imageKey = 'city_logo_' . $j;
            if (isset($city[$imageKey]) && !empty($city[$imageKey])) {
                $imageUrl = htmlspecialchars($webpage_full_link . 'images/cityimage/' . $city[$imageKey]);
                $imagesLogo[] = $imageUrl;
                $imageShow = true;
            }
        }

        // Process advertisement images and links
        for ($j = 1; $j <= 8; $j++) {
            $imageKey = 'ad_image_' . $j;
            $imageLinkKey = 'image_' . $j . '_link';

            if (isset($city[$imageKey]) && !empty($city[$imageKey])) {
                $imageUrl = htmlspecialchars($webpage_full_link . 'images/cityimage/' . $city[$imageKey]);
                $images[] = $imageUrl;

                if (isset($city[$imageLinkKey]) && !empty($city[$imageLinkKey])) {
                    $imageLinks[] = htmlspecialchars($city[$imageLinkKey]);
                }

                $imageShow = true;
            }
        }

        if ($imageShow) {
            break;
        }
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <?php include('seo.php'); ?>
    <!--== FAV ICON(BROWSER TAB ICON) ==-->
    <link rel="shortcut icon" href="<?php echo $slash; ?>/images/<?php echo $footer_row['home_page_fav_icon']; ?>"
        type="image/x-icon">
    <!--== GOOGLE FONTS ==-->
    <link href="https://fonts.googleapis.com/css?family=Oswald:700|Source+Sans+Pro:300,400,600,700&display=swap"
        rel="stylesheet">
    <!--== WEB ICON FONTS ==-->
    <link rel="preload" as="font" href="<?php echo $slash; ?>/css/icon.woff2" type="font/woff2" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--== CSS FILES ==-->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo $slash; ?>/css/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo $slash; ?>/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $slash; ?>/css/theme-color.php">
    <link rel="stylesheet" type="text/css" href="<?php echo $slash; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo $slash; ?>/css/fonts.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?php echo $slash; ?>js/html5shiv.js"></script>
    <script src="<?php echo $slash; ?>js/respond.min.js"></script>
    <![endif]-->

    <!--    Google Analytics Code Starts-->
    <?php echo stripslashes($footer_row['admin_google_analytics']); ?>
    <!--    Google Analytics Code Ends-->
    <style>
        .slick-slide {
            margin: 0px 8px;
        }

        .slick-slide img {
            width: 100%;
            border-radius: 15px;
            aspect-ratio: 16 / 9;
        }

        .slick-list {
            position: relative;
            display: block;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }

        .slick-list:focus {
            outline: none;
        }

        .slick-list.dragging {
            cursor: pointer;
            cursor: hand;
        }

        .slick-slider .slick-track,
        .slick-slider .slick-list {
            -webkit-transform: translate3d(0, 0, 0);
            -moz-transform: translate3d(0, 0, 0);
            -ms-transform: translate3d(0, 0, 0);
            -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
        }

        .slick-track {
            position: relative;
            top: 0;
            left: 0;
            display: block;
        }

        .slick-track:before,
        .slick-track:after {
            display: table;
            content: '';
        }

        .slick-track:after {
            clear: both;
        }

        .slick-loading .slick-track {
            visibility: hidden;
        }

        .slick-slide {
            display: none;
            float: left;
            height: 100%;
            min-height: 1px;
        }

        [dir='rtl'] .slick-slide {
            float: right;
        }

        .slick-slide img {
            display: block;
        }

        .slick-slide.slick-loading img {
            display: none;
        }

        .slick-slide.dragging img {
            pointer-events: none;
        }

        .slick-initialized .slick-slide {
            display: block;
        }

        #results {
            border: 1px solid #ccc;
            display: none;
            position: absolute;
            z-index: 1000;
            background: white;
            /* width: 200px; */
        }

        #results div {
            padding: 8px;
            cursor: pointer;
        }

        #results div:hover {
            background-color: #f0f0f0;
        }

        .booking-btn {
            background-color: rgb(243, 147, 22);
            padding: 15px;
            width: 100%;
            border-radius: 50px;
            border: none;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: 600;
            color: white;
        }

        #booking_time option:disabled {
            color: red;
            background-color: #f2d2d2;
            /* Light red background */
        }
    </style>
</head>

<body>

    <!--    Google Ad Sense Code Starts-->
    <?php echo stripslashes($footer_row['admin_google_ad_sense']); ?>
    <!--    Google Ad Sense Code Ends-->

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>

    <!-- START -->
    <section>
        <div class="str ind2-home">
            <?php if ($footer_row['admin_install_flag'] == 0) {
                kwohereza($SHYIRAMO);
            } ?>
            <div <?php if ($current_page == "index.php" || $current_page == "all-category.php") { ?> class="hom-head"
                style=" background-image: url(images/<?php echo $footer_row['home_page_banner']; ?>);" <?php } ?>>
                <div class="hom-top">
                    <div class="container">
                        <div class="row">
                            <div class="hom-nav d-flex justify-content-md-center justify-content-sm-start <?php if (!isset($_SESSION['user_name']) && empty($_SESSION['user_name'])) {
                                                                                                            } else { ?> db-open <?php } ?>">
                                <!--MOBILE MENU-->

                                <?php if ($imageShow && !empty($imagesLogo)): ?>
                                    <?php foreach ($imagesLogo as $imageUrl): ?>
                                        <a href="<?php echo htmlspecialchars($webpage_full_link); ?>" class="top-log">
                                            <img src="<?php echo $imageUrl; ?>" alt="" class="ic-logo">
                                        </a>
                                    <?php endforeach; ?>
                                <?php else: ?>


                                    <a href="<?php echo htmlspecialchars($webpage_full_link); ?>" class="top-log">
                                        <img src="<?php echo htmlspecialchars($slash . '/images/home/' . $footer_row['header_logo']); ?>"
                                            <?php if ($footer_row['header_logo_width'] !== NULL || $footer_row['header_logo_height'] !== NULL): ?>
                                            style="<?php if ($footer_row['header_logo_width'] !== NULL): ?>width: <?php echo htmlspecialchars($footer_row['header_logo_width']); ?>; <?php endif; ?>
                                                    <?php if ($footer_row['header_logo_height'] !== NULL): ?>height: <?php echo htmlspecialchars($footer_row['header_logo_height']); ?>;<?php endif; ?>"
                                            <?php endif; ?> alt="" class="ic-logo ">
                                    </a>

                                    <a href="<?php echo htmlspecialchars($webpage_full_link); ?>" class="top-log"
                                        style="margin-left: 15px;">
                                        <img src="<?php echo htmlspecialchars($slash . '/images/home/' . $footer_row['header_logo']); ?>"
                                            <?php if ($footer_row['header_logo_width'] !== NULL || $footer_row['header_logo_height'] !== NULL): ?>
                                            style="<?php if ($footer_row['header_logo_width'] !== NULL): ?>width: <?php echo htmlspecialchars($footer_row['header_logo_width']); ?>; <?php endif; ?>
                                                    <?php if ($footer_row['header_logo_height'] !== NULL): ?>height: <?php echo htmlspecialchars($footer_row['header_logo_height']); ?>;<?php endif; ?>"
                                            <?php endif; ?> alt="" class="ic-logo">
                                    </a>
                                <?php endif; ?>

                                <div class="menu">
                                    <div class="explore-cls"><?php echo $Zitiziti['EXPLORE']; ?></div>
                                </div>

                                <div class="pop-menu">
                                    <div class="container">
                                        <div class="row">
                                            <i class="material-icons clopme">close</i>
                                            <div class="pmenu-spri">
                                                <ul>
                                                    <?php if ($footer_row['admin_listing_show'] == 1) { ?>
                                                        <li><a href="/all-category" class="act"><img
                                                                    src="<?php echo $slash; ?>/images/icon/shop.png"><?php echo $Zitiziti['ALL_SERVICES']; ?>
                                                            </a></li>
                                                    <?php }
                                                    if ($footer_row['admin_expert_show'] == 1) { ?>
                                                        <li><a href="/service-experts" class="act"><img
                                                                    src="<?php echo $slash; ?>/images/icon/expert.png"><?php echo $Zitiziti['SERVICE-EXPERTS']; ?>
                                                            </a></li>
                                                    <?php }
                                                    if ($footer_row['admin_job_show'] == 1) { ?>
                                                        <li><a href="/jobs" class="act"><img
                                                                    src="<?php echo $slash; ?>/images/icon/employee.png"><?php echo $Zitiziti['JOBS']; ?>
                                                            </a></li>
                                                    <?php }
                                                    if ($footer_row['admin_place_show'] == 1) { ?>
                                                        <li><a href="/places" class="act"><img
                                                                    src="<?php echo $slash; ?>/images/places/icons/hot-air-balloon.png"><?php echo $Zitiziti['PLACE-MENU']; ?>
                                                            </a></li>
                                                    <?php }
                                                    if ($footer_row['admin_news_show'] == 1) { ?>
                                                        <li><a href="/news"><img
                                                                    src="<?php echo $slash; ?>/images/icon/news.png"><?php echo $Zitiziti['NEWS-MAGA']; ?>
                                                            </a></li>
                                                    <?php }
                                                    if ($footer_row['admin_event_show'] == 1) { ?>
                                                        <li><a href="/events"><img
                                                                    src="<?php echo $slash; ?>/images/icon/calendar.png"><?php echo $Zitiziti['EVENTS']; ?>
                                                            </a></li>
                                                    <?php }
                                                    if ($footer_row['admin_product_show'] == 1) { ?>
                                                        <li><a href="/all-products"><img
                                                                    src="<?php echo $slash; ?>/images/icon/cart.png"><?php echo $Zitiziti['PRODUCTS']; ?>
                                                            </a></li>
                                                    <?php }
                                                    if ($footer_row['admin_coupon_show'] == 1) { ?>
                                                        <li><a href="/coupons"><img
                                                                    src="<?php echo $slash; ?>/images/icon/coupons.png"><?php echo $Zitiziti['COUPONS_AND_DEALS']; ?>
                                                            </a></li>
                                                    <?php }
                                                    if ($footer_row['admin_blog_show'] == 1) { ?>
                                                        <!-- <li><a href="/blog-posts"><img
                                                                src="<?php echo $slash; ?>/images/icon/blog1.png"><?php echo $Zitiziti['BLOGS']; ?>
                                                        </a></li> -->
                                                    <?php } ?>
                                                    <li><a href="/community"><img
                                                                src="<?php echo $slash; ?>/images/icon/11.png"><?php echo $Zitiziti['COMMUNITY']; ?>
                                                        </a></li>
                                                </ul>
                                            </div>
                                            <div class="pmenu-cat">
                                                <h4><?php echo $Zitiziti['ALL_CATEGORIES']; ?></h4>
                                                <input type="text" id="pg-sear" placeholder="Search category">
                                                <ul id="pg-resu">
                                                    <?php
                                                    foreach (getAllCategoriesPos() as $category_row) {

                                                    ?>
                                                        <li>
                                                            <a
                                                                href="<?php echo $ALL_LISTING_URL . urlModifier($category_row['category_slug']); ?>"><?php echo $category_row['category_name']; ?>&nbsp;-&nbsp;<span><?php echo AddingZero_BeforeNumber(getCountCategoryListing($category_row['category_id'])); ?></span></a>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="dir-home-nav-bot">
                                                <ul>
                                                    <li><?php echo $Zitiziti['HOM-FEW-REASON-LOVE']; ?>
                                                        <span><?php echo $Zitiziti['HOM-CALL-US-ON']; ?></span>
                                                    </li>
                                                    <li><a href="/post-your-ads"
                                                            class="waves-effect waves-light btn-large"><i
                                                                class="material-icons">font_download</i>
                                                            <?php echo $Zitiziti['POST_ADS']; ?>
                                                        </a>
                                                    </li>
                                                    <li><a href="/pricing-details"
                                                            class="waves-effect waves-light btn-large"> <i
                                                                class="material-icons">store</i>
                                                            <?php echo $Zitiziti['HOM-HOW-P-TIT-2']; ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--END MOBILE MENU-->

                                <!-- <div class="top-ser py-3 ps-2 d-none  d-lg-block ">
                                    <form name="filter_form" id="filter_form" class="filter_form">
                                        <ul>
                                            <li class="sr-sea">
                                                <input type="text" autocomplete="off" id="top-select-search"
                                                    placeholder="<?php echo $Zitiziti['SEARCHBOX_LABEL']; ?>"
                                                    class="pe-2">
                                                <ul id="tser-res1" class="tser-res tser-res2">
                                                    <?php
                                                    foreach (getAllSearch() as $search_row) {
                                                    ?>
                                                    <li>
                                                        <div>
                                                            <h4><?php echo $search_row['search_title']; ?></h4>
                                                            <span><?php echo $search_row['search_tag_line']; ?></span><a
                                                                href="<?php echo $search_row['search_list_link']; ?>"></a>
                                                        </div>
                                                    </li>
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </li>

                                            <li class="sbtn">
                                                <button type="button" class="btn btn-success me-3"
                                                    id="top_filter_submit"><i class="material-icons">&nbsp;</i></button>
                                            </li>
                                        </ul>
                                    </form>
                                </div> -->

                                <ul class="bl align-content-center ">
                                    <li>
                                        <script>
                                            function ChangeCity(city) {
                                                $.post("../admin/config/updateCity.php", {
                                                        city: city
                                                    })
                                                    .done(function(data) {
                                                        data = jQuery.parseJSON(data);
                                                        if (data.status == 1) {
                                                            location.reload();

                                                        } else {
                                                            console.log('Issues in city name changes');
                                                        }
                                                    });
                                            }
                                        </script>
                                        <select name="city" onchange="ChangeCity(this.value)">
                                            <?php
                                            if (isset($CityList['Ciudades'])) {
                                                $allCitiesValue = htmlspecialchars($CityList['Ciudades'], ENT_QUOTES, 'UTF-8');
                                                $selected = ($DomainPrefix == $allCitiesValue) ? ' selected' : '';
                                                echo '<option value="' . $allCitiesValue . '"' . $selected . '>Ciudades</option>';
                                            }

                                            foreach ($CityList as $City => $CitySlug) {
                                                if ($CitySlug == 'www') {
                                                    continue;
                                                }

                                                $selected = ($DomainPrefix == $CitySlug) ? ' selected' : '';
                                                echo '<option value="' . htmlspecialchars($CitySlug, ENT_QUOTES, 'UTF-8') . '"' . $selected . '>' . htmlspecialchars($City, ENT_QUOTES, 'UTF-8') . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </li>
                                    <li>
                                        <a href="/pricing-details"
                                            class="text-decoration-none"><?php echo $Zitiziti['ADD_BUSINESS']; ?></a>
                                    </li>


                                    <?php
                                    if (!isset($_SESSION['user_name']) && empty($_SESSION['user_name'])) {
                                    ?>
                                        <li>
                                            <a href="/login"
                                                class="text-decoration-none"><?php echo $Zitiziti['SIGN_IN']; ?></a>
                                        </li>
                                        <li>
                                            <a href="/login?login=register"
                                                class="text-decoration-none"><?php echo $Zitiziti['CREATE_AN_ACCOUNT']; ?></a>
                                        </li>
                                    <?php
                                    } else {
                                    ?>

                                        <div class="al" style="margin-left: 15px;">
                                            <div class="head-pro">
                                                <img src="<?php echo $slash; ?>/images/user/<?php if (($user_details_row['profile_image'] == NULL) || empty($user_details_row['profile_image'])) {
                                                                                                echo $footer_row['user_default_image'];
                                                                                            } else {
                                                                                                echo $user_details_row['profile_image'];
                                                                                            } ?>" alt="User" title="Go to dashboard">
                                                <span class="fclick near-pro-cta"></span>
                                            </div>
                                            <div class="db-menu">
                                                <span class="material-icons db-menu-clo">close</span>
                                                <div class="ud-lhs-s1">
                                                    <img src="<?php echo $slash; ?>/images/user/<?php if (($user_details_row['profile_image'] == NULL) || empty($user_details_row['profile_image'])) {
                                                        echo $footer_row['user_default_image'];
                                                    } else {
                                                        echo $user_details_row['profile_image'];
                                                    } ?>" alt="">
                                                    <div class="ud-lhs-pro-bio">
                                                        <h4><?php echo $user_details_row['first_name']; ?></h4>
                                                        <b><?php echo $Zitiziti['JOIN_ON']; ?><?php echo dateFormatconverter($user_details_row['user_cdt']) ?></b>
                                                        <a class="ud-lhs-view-pro" target="_blank"
                                                            href="<?php echo $PROFILE_URL . urlModifier($user_details_row['user_slug']); ?>"><?php echo $Zitiziti['MY_PROFILE']; ?></a>
                                                    </div>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a href="<?php echo $slash; ?>dashboard" class="<?php if ($current_page == "dashboard.php") {
                                                            echo "db-lact";
                                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/dbl1.png" alt="" />
                                                        <?php echo $Zitiziti['MY_DASHBOARD']; ?></a>
                                                    </li>
                                                    <?php
                                                    if ($user_details_row['user_type'] == "Service provider") {  //To Check User type is Service provider
                                                    ?>
                                                        <?php if ($footer_row['admin_listing_show'] == 1 && $user_details_row['setting_listing_show'] == 1) { ?>
                                                            <li>
                                                                <h4><?php echo $Zitiziti['DASH-LHS-ALL-MOD']; ?></h4>
                                                                <a href="<?php echo $slash; ?>db-all-listing" class="<?php if ($current_page == "db-all-listing.php") {
                                                                    echo "db-lact";
                                                                } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/shop.png" alt="" /><?php echo $Zitiziti['ALL_LISTING']; ?></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if ($footer_row['admin_job_show'] == 1 && $user_details_row['setting_job_show'] == 1) { ?>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>jobs/db-jobs" class="<?php if ($current_page == "db-jobs.php") {
                                                                    echo "db-lact";
                                                                } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/employee.png" alt="" /><?php echo $Zitiziti['JOBS']; ?></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if ($footer_row['admin_product_show'] == 1 && $user_details_row['setting_product_show'] == 1) { ?>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>db-products" class="<?php if ($current_page == "db-products.php") {
                                                                    echo "db-lact";
                                                                } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/cart.png" alt="" /><?php echo $Zitiziti['ALL_PRODUCTS']; ?>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if ($footer_row['admin_event_show'] == 1 && $user_details_row['setting_event_show'] == 1) { ?>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>db-events" class="<?php if ($current_page == "db-events.php") {
                                                                echo "db-lact";
                                                                } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/calendar.png" alt="" /><?php echo $Zitiziti['EVENTS']; ?></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if ($footer_row['admin_blog_show'] == 1 && $user_details_row['setting_blog_show'] == 1) { ?>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>db-blog-posts" class="<?php if ($current_page == "db-blog-posts.php") {
                                                                echo "db-lact";
                                                                } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/blog1.png" alt="" /><?php echo $Zitiziti['BLOG_POSTS']; ?></a>
                                                            </li>
                                                        <?php } ?>

                                                        <?php if ($footer_row['admin_coupon_show'] == 1 && $user_details_row['setting_coupon_show'] == 1) { ?>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>db-coupons" class="<?php if ($current_page == "db-coupons.php") {
                                                                echo "db-lact";
                                                                } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/coupons.png" alt="" /><?php echo $Zitiziti['COUPONS']; ?></a>
                                                            </li>
                                                        <?php } ?>

                                                        <?php if ($footer_row['admin_listing_show'] == 1 && $user_details_row['setting_listing_show'] == 1) { ?>
                                                            <li>
                                                                <h4><?php echo $Zitiziti['DASH-LHS-LEAD']; ?></h4>
                                                                <a href="<?php echo $slash; ?>db-enquiry" class="<?php if ($current_page == "db-enquiry.php") {
                                                                echo "db-lact";
                                                                } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/tick.png" alt="" /><?php echo $Zitiziti['LEAD_ENQUIRY']; ?>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if ($footer_row['admin_expert_show'] == 1 && $user_details_row['setting_expert_show'] == 1) { ?>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>service-experts/db-service-expert"
                                                                    class="<?php if ($current_page == "db-service-expert.php") {
                                                                    echo "db-lact";
                                                                    } ?>"><img src="<?php echo $slash; ?>/images/icon/expert.png" alt="" /><?php echo $Zitiziti['ALL_SERVICE_EXPERT_LEADS']; ?>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>business-all-bookings.php" class="<?php 
                                                                if ($current_page == "business-all-bookings.php") {
                                                                echo "db-lact";
                                                            } ?>">
                                                            <img src="<?php echo $slash; ?>images/icon/booking.png" alt=""/>
                                                            <?php echo $Zitiziti['BOOKING_ENQUIRY']; ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <h4><?php echo $Zitiziti['DASH-LHS-PAY']; ?></h4>
                                                            <a href="<?php echo $slash; ?>db-payment" class="<?php if ($current_page == "db-payment.php") {
                                                            echo "db-lact";
                                                            } ?>"><img loading="lazy"  src="<?php echo $slash; ?>/images/icon/dbl9.png" alt=""><?php echo $Zitiziti['CHECK_OUT']; ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>db-promote" class="<?php if ($current_page == "db-promote.php") {
                                                            echo "db-lact";
                                                            } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/promotion.png" alt="" /><?php echo $Zitiziti['PROMOTIONS']; ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>db-seo" class="<?php if ($current_page == "db-seo.php") {
                                                            echo "db-lact";
                                                            } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/seo.png" alt="" /><?php echo $Zitiziti['SEO']; ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>db-point-history" class="<?php if ($current_page == "db-point-history.php") {
                                                            echo "db-lact";
                                                            } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/point.png" alt="" /><?php echo $Zitiziti['POINTS_HISTORY']; ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>db-post-ads" class="<?php if ($current_page == "db-post-ads.php") {
                                                            echo "db-lact";
                                                            } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/dbl11.png" alt="" /><?php echo $Zitiziti['AD_SUMMARY']; ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>db-invoice-all" class="<?php if ($current_page == "db-invoice-all.php") {
                                                            echo "db-lact";
                                                            } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/dbl16.png" alt="" /><?php echo $Zitiziti['PAYMENT_INVOICE']; ?></a>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>

                                                    <li>
                                                        <h4><?php echo $Zitiziti['DASH-LHS-PAGES']; ?></h4>
                                                        <a href="<?php echo $slash; ?>db-my-profile" class="<?php if ($current_page == "db-my-profile.php" || $current_page == "db-my-profile-edit") {
                                                            echo "db-lact";
                                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/profile.png" alt="" /><?php echo $Zitiziti['MY_PROFILE']; ?></a>
                                                    </li>
                                                    <?php if ($user_details_row['user_type'] == "Service provider" && $footer_row['admin_expert_show'] == 1 && $user_details_row['setting_expert_show'] == 1) { ?>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>service-experts/create-service-expert-profile"
                                                                class="<?php if ($current_page == "create-service-expert-profile.php") {
                                                                    echo "db-lact";
                                                                } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/profile.png" alt="" /><?php echo $Zitiziti['ADD_NEW_SERVICE_EXPERT']; ?>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($footer_row['admin_job_show'] == 1 && $user_details_row['setting_job_show'] == 1) { ?>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>jobs/create-job-seeker-profile" class="<?php if ($current_page == "create-job-seeker-profile.php") {
                                                            echo "db-lact";
                                                            } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/profile.png" alt="" /><?php echo $Zitiziti['PROFI_JOB_SEEKER_TIT']; ?>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                    <li>
                                                        <h4><?php echo $Zitiziti['DASH-LHS-ACTI']; ?></h4>
                                                        <a href="<?php echo $slash; ?>jobs/db-user-applied-jobs">
                                                            <img src="<?php echo $slash; ?>/images/icon/job-apply.png"alt="" />
                                                            <?php echo $Zitiziti['ALL_APPLIED_JOBS']; ?>
                                                        </a>
                                                    </li>
                                                    <?php if ($footer_row['admin_expert_show'] == 1 && $user_details_row['setting_expert_show'] == 1) { ?>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>service-experts/db-my-service-bookings"
                                                                class="<?php if ($current_page == "db-my-service-bookings.php") {
                                                                echo "db-lact";
                                                                } ?>"><img src="<?php echo $slash; ?>/images/icon/expert-book.png" alt="" /><?php echo $Zitiziti['MY_SERVICE_BOOKINGS']; ?>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                    <li>
                                                        <a href="<?php echo $slash; ?>db-review" class="<?php if ($current_page == "db-review.php") {
                                                            echo "db-lact";
                                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/dbl13.png" alt="" /><?php echo $Zitiziti['REVIEWS']; ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo $slash; ?>db-like-listings" class="<?php if ($current_page == "db-like-listings.php") {
                                                        echo "db-lact";
                                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/dbl15.png" alt="" /><?php echo $Zitiziti['LIKED_LISTINGS']; ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo $slash; ?>db-followings" class="<?php if ($current_page == "db-followings.php") {
                                                            echo "db-lact";
                                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/dbl18.png" alt="" /><?php echo $Zitiziti['FOLLOWINGS']; ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo $slash; ?>db-notifications" class="<?php if ($current_page == "db-notifications.php") {
                                                        echo "db-lact";
                                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/dbl19.png" alt="" /><?php echo $Zitiziti['NOTIFICATIONS']; ?></a>
                                                    </li>
                                                    <li>
                                                        <h4><?php echo $Zitiziti['DASH-LHS-SETT']; ?></h4>
                                                        <a href="<?php echo $slash; ?>db-setting" class="<?php if ($current_page == "db-setting.php") {
                                                            echo "db-lact";
                                                        } ?>"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/dbl210.png" alt="" /><?php echo $Zitiziti['SETTING']; ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo $slash; ?>how-to" class="<?php if ($current_page == "how-to.php") {
                                                            echo "db-lact";
                                                        } ?>" target="_blank"><img loading="lazy" src="<?php echo $slash; ?>/images/icon/dbl17.png" alt="" /><?php echo $Zitiziti['HOW_TOS']; ?>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo $slash; ?>logout"><img loading="lazy"
                                                                src="<?php echo $slash; ?>/images/icon/dbl12.png"
                                                                alt="" /><?php echo $Zitiziti['LOG_OUT']; ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </ul>

                                <!--MOBILE MENU-->
                                <div class="mob-menu">
                                    <div class="mob-me-ic"><i class="material-icons">menu</i></div>
                                    <div class="mob-me-all">

                                        <div class="mob-me-clo"><i class="material-icons">close</i></div>
                                        <?php
                                        if (!isset($_SESSION['user_name']) && empty($_SESSION['user_name'])) {
                                        ?>
                                            <div class="mv-cate">
                                                <h4>Ciudades</h4>
                                                <ul>
                                                    <li>
                                                        <script>
                                                            function ChangeCity(city) {
                                                                $.post("../admin/config/updateCity.php", {
                                                                        city: city
                                                                    })
                                                                    .done(function(data) {
                                                                        data = jQuery.parseJSON(data);
                                                                        if (data.status == 1) {
                                                                            location.reload();

                                                                        } else {
                                                                            console.log('Issues in city name changes');
                                                                        }
                                                                    });
                                                            }
                                                        </script>
                                                        <select name="city" onchange="ChangeCity(this.value)">
                                                            <?php
                                                            if (isset($CityList['Ciudades'])) {
                                                                $allCitiesValue = htmlspecialchars($CityList['Ciudades'], ENT_QUOTES, 'UTF-8');
                                                                $selected = ($DomainPrefix == $allCitiesValue) ? ' selected' : '';
                                                                echo '<option value="' . $allCitiesValue . '"' . $selected . '>Ciudades</option>';
                                                            }

                                                            foreach ($CityList as $City => $CitySlug) {
                                                                if ($CitySlug == 'www') {
                                                                    continue;
                                                                }

                                                                $selected = ($DomainPrefix == $CitySlug) ? ' selected' : '';
                                                                echo '<option value="' . htmlspecialchars($CitySlug, ENT_QUOTES, 'UTF-8') . '"' . $selected . '>' . htmlspecialchars($City, ENT_QUOTES, 'UTF-8') . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="mv-bus">

                                                <ul>
                                                    <li>
                                                        <a
                                                            href="/pricing-details"><?php echo $Zitiziti['ADD_BUSINESS']; ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="/login">
                                                            <?php echo $Zitiziti['SIGN_IN']; ?>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="/login?login=register"><?php echo $Zitiziti['CREATE_AN_ACCOUNT']; ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="mv-pro ud-lhs-s1">
                                                <img src="<?php echo $slash; ?>/images/user/<?php if (($user_details_row['profile_image'] == NULL) || empty($user_details_row['profile_image'])) {
                                                    echo $footer_row['user_default_image'];
                                                } else {
                                                    echo $user_details_row['profile_image'];
                                                } ?>" alt="">
                                                <div class="ud-lhs-pro-bio">
                                                    <h4><?php echo $user_details_row['first_name']; ?></h4>
                                                    <b><?php echo $Zitiziti['JOIN_ON']; ?><?php echo dateFormatconverter($user_details_row['user_cdt']) ?></b>
                                                </div>
                                            </div>
                                            <div class="mv-pro-menu ud-lhs-s2">
                                                <ul>
                                                    <li>
                                                        <a href="<?php echo $slash; ?>dashboard" class="<?php if ($current_page == "dashboard.php") {
                                                            echo "db-lact";
                                                        } ?>"><img src="<?php echo $slash; ?>/images/icon/dbl1.png"
                                                        alt="" /> <?php echo $Zitiziti['MY_DASHBOARD']; ?></a>
                                                    </li>
                                                    <?php
                                                    if ($user_details_row['user_type'] == "Service provider") {  //To Check User type is Service provider
                                                    ?>
                                                        <?php if ($footer_row['admin_listing_show'] == 1 && $user_details_row['setting_listing_show'] == 1) { ?>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>db-all-listing" class="<?php if ($current_page == "db-all-listing.php") {
                                                                echo "db-lact";
                                                                } ?>"><img src="<?php echo $slash; ?>/images/icon/shop.png" alt="" /><?php echo $Zitiziti['ALL_LISTING']; ?></a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>add-listing-start"><img src="<?php echo $slash; ?>/images/icon/dbl3.png" alt="" /><?php echo $Zitiziti['ADD_NEW_LISTING']; ?></a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>db-enquiry" class="<?php if ($current_page == "db-enquiry.php") {
                                                                echo "db-lact";
                                                                } ?>"><img src="<?php echo $slash; ?>/images/icon/tick.png" alt="" /><?php echo $Zitiziti['LEAD_ENQUIRY']; ?></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if ($footer_row['admin_job_show'] == 1 && $user_details_row['setting_job_show'] == 1) { ?>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>jobs/db-jobs" class="<?php if ($current_page == "db-jobs.php") {
                                                                echo "db-lact";
                                                                } ?>"><img src="<?php echo $slash; ?>jobs/images/icon/employee.png" alt="" /><?php echo $Zitiziti['JOBS']; ?></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if ($footer_row['admin_product_show'] == 1 && $user_details_row['setting_product_show'] == 1) { ?>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>db-products" class="<?php if ($current_page == "db-products.php") {
                                                                echo "db-lact";
                                                                } ?>"><img src="<?php echo $slash; ?>/images/icon/cart.png" alt="" /><?php echo $Zitiziti['ALL_PRODUCTS']; ?></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if ($footer_row['admin_event_show'] == 1 && $user_details_row['setting_event_show'] == 1) { ?>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>db-events" class="<?php if ($current_page == "db-events.php") {
                                                                echo "db-lact";
                                                                } ?>"><img src="<?php echo $slash; ?>/images/icon/calendar.png" alt="" /><?php echo $Zitiziti['EVENTS']; ?></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if ($footer_row['admin_blog_show'] == 1 && $user_details_row['setting_blog_show'] == 1) { ?>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>db-blog-posts" class="<?php if ($current_page == "db-blog-posts.php") {
                                                                echo "db-lact";
                                                                } ?>"><img src="<?php echo $slash; ?>/images/icon/blog1.png" alt="" /><?php echo $Zitiziti['BLOG_POSTS']; ?></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if ($footer_row['admin_expert_show'] == 1 && $user_details_row['setting_expert_show'] == 1) { ?>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>service-experts/create-service-expert-profile"
                                                                    class="<?php if ($current_page == "create-service-expert-profile.php") {
                                                                        echo "db-lact";
                                                                    } ?>"><img
                                                                src="<?php echo $slash; ?>/images/icon/profile.png"
                                                                alt="" /><?php echo $Zitiziti['ADD_NEW_SERVICE_EXPERT']; ?></a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>service-experts/db-service-expert"
                                                                    class="<?php if ($current_page == "db-service-expert.php") {
                                                                        echo "db-lact";
                                                                    } ?>"><img
                                                                src="<?php echo $slash; ?>/images/icon/expert.png"
                                                                alt="" /><?php echo $Zitiziti['ALL_SERVICE_EXPERT_LEADS']; ?></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if ($footer_row['admin_coupon_show'] == 1 && $user_details_row['setting_coupon_show'] == 1) { ?>
                                                            <li>
                                                                <a href="<?php echo $slash; ?>db-coupons" class="<?php if ($current_page == "db-coupons.php") {
                                                                echo "db-lact";
                                                                } ?>"><img src="<?php echo $slash; ?>/images/icon/coupons.png" alt="" /><?php echo $Zitiziti['COUPONS']; ?></a>
                                                            </li>
                                                        <?php } ?>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>db-promote" class="<?php if ($current_page == "db-promote.php") {
                                                            echo "db-lact";
                                                            } ?>"><img src="<?php echo $slash; ?>/images/icon/promotion.png" alt="" /><?php echo $Zitiziti['PROMOTIONS']; ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>db-seo" class="<?php if ($current_page == "db-seo.php") {
                                                                echo "db-lact";
                                                            } ?>"><img src="<?php echo $slash; ?>/images/icon/seo.png" alt="" /><?php echo $Zitiziti['SEO']; ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>db-point-history" class="<?php if ($current_page == "db-point-history.php") {
                                                            echo "db-lact";
                                                             } ?>"><img src="<?php echo $slash; ?>/images/icon/point.png" alt="" /><?php echo $Zitiziti['POINTS_HISTORY']; ?>
                                                            </a>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>

                                                    <li>
                                                        <a href="<?php echo $slash; ?>db-my-profile" class="<?php if ($current_page == "db-my-profile.php" || $current_page == "db-my-profile-edit") {
                                                            echo "db-lact";
                                                        } ?>"><img src="<?php echo $slash; ?>/images/icon/profile.png" alt="" /><?php echo $Zitiziti['MY_PROFILE']; ?></a>
                                                    </li>
                                                    <?php if ($footer_row['admin_job_show'] == 1 && $user_details_row['setting_job_show'] == 1) { ?>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>jobs/create-job-seeker-profile" class="<?php if ($current_page == "create-job-seeker-profile.php") {
                                                            echo "db-lact";
                                                            } ?>"><img src="<?php echo $slash; ?>/images/icon/profile.png" alt="" /><?php echo $Zitiziti['PROFI_JOB_SEEKER_TIT']; ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>jobs/db-user-applied-jobs"><img
                                                                    src="<?php echo $slash; ?>/images/icon/job-apply.png"
                                                                    alt="" /><?php echo $Zitiziti['ALL_APPLIED_JOBS']; ?>
                                                            </a>
                                                        </li>
                                                    <?php }
                                                    if ($footer_row['admin_expert_show'] == 1 && $user_details_row['setting_expert_show'] == 1) { ?>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>service-experts/db-my-service-bookings"
                                                                class="<?php if ($current_page == "db-my-service-bookings.php") {
                                                                        echo "db-lact";
                                                                    } ?>"><img
                                                                src="<?php echo $slash; ?>/images/icon/expert-book.png"
                                                                alt="" /><?php echo $Zitiziti['MY_SERVICE_BOOKINGS']; ?>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                    <li>
                                                        <a href="<?php echo $slash; ?>db-review" class="<?php if ($current_page == "db-review.php") {
                                                            echo "db-lact";
                                                        } ?>"><img src="<?php echo $slash; ?>/images/icon/dbl13.png" alt="" /><?php echo $Zitiziti['REVIEWS']; ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo $slash; ?>db-like-listings" class="<?php if ($current_page == "db-like-listings.php") {
                                                            echo "db-lact";
                                                            } ?>"><img src="<?php echo $slash; ?>/images/icon/dbl15.png" alt="" /><?php echo $Zitiziti['LIKED_LISTINGS']; ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo $slash; ?>db-followings" class="<?php if ($current_page == "db-followings.php") {
                                                            echo "db-lact";
                                                        } ?>"><img src="<?php echo $slash; ?>/images/icon/dbl18.png" alt="" /><?php echo $Zitiziti['FOLLOWINGS']; ?></a>
                                                    </li>
                                                    <?php
                                                    if ($user_details_row['user_type'] == "Service provider") {  //To Check User type is Service provider
                                                    ?>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>db-post-ads" class="<?php if ($current_page == "db-post-ads.php") {
                                                            echo "db-lact";
                                                            } ?>"><img src="<?php echo $slash; ?>/images/icon/dbl11.png" alt="" /><?php echo $Zitiziti['AD_SUMMARY']; ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>db-payment" class="<?php if ($current_page == "db-payment.php") {
                                                            echo "db-lact";
                                                            } ?>"><img src="<?php echo $slash; ?>/images/icon/dbl9.png" alt=""><?php echo $Zitiziti['CHECK_OUT']; ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo $slash; ?>db-invoice-all" class="<?php if ($current_page == "db-invoice-all.php") {
                                                            echo "db-lact";
                                                            } ?>"><img src="<?php echo $slash; ?>/images/icon/dbl16.png" alt="" /><?php echo $Zitiziti['PAYMENT_INVOICE']; ?>
                                                            </a>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>
                                                    <li>
                                                        <a href="<?php echo $slash; ?>db-notifications" class="<?php if ($current_page == "db-notifications.php") {
                                                        echo "db-lact";
                                                        } ?>"><img src="<?php echo $slash; ?>/images/icon/dbl19.png" alt="" /><?php echo $Zitiziti['NOTIFICATIONS']; ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo $slash; ?>how-to" class="<?php if ($current_page == "how-to.php") {
                                                            echo "db-lact";
                                                        } ?>" target="_blank"><img src="<?php echo $slash; ?>/images/icon/dbl17.png" alt="" /><?php echo $Zitiziti['HOW_TOS']; ?>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo $slash; ?>db-setting" class="<?php if ($current_page == "db-setting.php") {
                                                            echo "db-lact";
                                                        } ?>"><img src="<?php echo $slash; ?>/images/icon/dbl210.png" alt="" /><?php echo $Zitiziti['SETTING']; ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo $slash; ?>logout"><img
                                                                src="<?php echo $slash; ?>/images/icon/dbl12.png"
                                                                alt="" /><?php echo $Zitiziti['LOG_OUT']; ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <div class="mv-cate">
                                            <h4><?php echo $Zitiziti['ALL_CATEGORIES']; ?></h4>
                                            <ul>
                                                <?php foreach (getAllCategoriesPos() as $row) { ?>
                                                    <li>
                                                        <a
                                                            href="<?php echo $ALL_LISTING_URL . urlModifier($row['category_name']); ?>"><?php echo $row['category_name']; ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <!--END MOBILE MENU-->
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($current_page == "index.php" || $current_page == "index1.php" || $current_page == "index2.php" || $current_page == "all-category.php") { ?>
                    <div class="container">
                        <div class="d-flex flex-column justify-content-center align-item-center">
                            <div class="ban-tit">
                                <h1>
                                    <?php if ($current_page == "all-category.php") { ?>
                                        <b><?php echo $Zitiziti['HOM-BAN-TIT-CAT']; ?></b>
                                    <?php } else { ?>
                                        <b><?php echo $Zitiziti['HOM-BAN-TIT']; ?></b> <?php echo $Zitiziti['HOM-BAN-SUB-TIT']; ?>
                                    <?php } ?>
                                </h1>
                            </div>
                            <div class="container d-flex justify-content-center">
                                <div class="ban-search">
                                    <form name="filter_form" id="filter_form">
                                        <ul>
                                            <!-- <li class="sr-cate">
                                            <select onChange="getSearchCategories(this.value);" name="explor_select"
                                                id="explor_select" class="chosen-select rounded">
                                                <option value=""><?php echo $Zitiziti['SEARCHBOX_LABEL_SER']; ?></option>
                                                <?php if ($footer_row['admin_listing_show'] == 1) { ?>
                                                <option value="1"><?php echo $Zitiziti['ALL_SERVICES']; ?></option>
                                                <?php }
                                                if ($footer_row['admin_expert_show'] == 1) { ?>
                                                <option value="2"><?php echo $Zitiziti['SERVICE-EXPERTS']; ?></option>
                                                <?php }
                                                if ($footer_row['admin_job_show'] == 1) { ?>
                                                <option value="3"><?php echo $Zitiziti['JOBS']; ?></option>
                                                <?php }
                                                if ($footer_row['admin_place_show'] == 1) { ?>
                                                <option value="4"><?php echo $Zitiziti['PLACE-MENU']; ?></option>
                                                <?php }
                                                if ($footer_row['admin_news_show'] == 1) { ?>
                                                <option value="5"><?php echo $Zitiziti['NEWS-MAGA']; ?></option>
                                                <?php }
                                                if ($footer_row['admin_event_show'] == 1) { ?>
                                                <option value="6"><?php echo $Zitiziti['EVENTS']; ?></option>
                                                <?php }
                                                if ($footer_row['admin_product_show'] == 1) { ?>
                                                <option value="7"><?php echo $Zitiziti['PRODUCTS']; ?></option>
                                                <?php }
                                                if ($footer_row['admin_coupon_show'] == 1) { ?>
                                                <option value="8"><?php echo $Zitiziti['COUPONS_AND_DEALS']; ?></option>
                                                <?php }
                                                if ($footer_row['admin_blog_show'] == 1) { ?>
                                                <option value="9"><?php echo $Zitiziti['BLOGS']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </li> -->
                                            <!-- <li class="sr-cit">
                                                <select id="city_check" name="city_check" class="chosen-select">
                                                    <option value=""><?php echo $Zitiziti['SELECT_CITY']; ?></option>
                                                    <?php if (isset($_SESSION['google_city_name']) && ($_SESSION['google_city_name']) != NULL) { ?>
                                                        <option <?php
                                                                echo 'selected';
                                                                ?>
                                                            value="<?php echo $_SESSION['google_city_name']; ?>">
                                                            <?php echo $_SESSION['google_city_name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                    <?php
                                                    $all_city_array = array();
                                                    foreach (getAllListingPageCities() as $city_listrow) {
                                                        $arr34 = explode(',', $city_listrow['city_id']);
                                                        foreach ($arr34 as $row) {
                                                            if (trim($row) != '') {
                                                                $all_city_array[] = trim($row);
                                                            }
                                                        }
                                                    }
                                                    $city_input = array();
                                                    $city_input = array_unique($all_city_array);

                                                    foreach ($city_input as $places) {
                                                        $cityrow = getCity($places);
                                                        $hyphend_city_name = urlModifier($cityrow['city_name']);
                                                    ?>
                                                        <option <?php if ($_SESSION['city_check'] == $hyphend_city_name) {
                                                                    echo 'selected';
                                                                } ?> value="<?php echo urlModifier($hyphend_city_name); ?>">
                                                            <?php echo $cityrow['city_name']; ?>
                                                        </option>
                                                        <?php
                                                    }
                                                        ?>
                                                </select>
                                            </li>
                                            <li class="sr-nor">
                                                <select class="chosen-select" id="expert-select-search"
                                                    name="expert-select-search">
                                                    <option value=""><?php echo $Zitiziti['SEARCHBOX_LABEL']; ?></option>
                                                    <?php
                                                    foreach (getAllCategoriesPos() as $expert_search_categories_row) {

                                                        $search_category_name = $expert_search_categories_row['category_name'];

                                                        $search_category_id = $expert_search_categories_row['category_id'];
                                                    ?>
                                                        <option value="<?php echo $search_category_name; ?>">
                                                            <?php echo $search_category_name; ?>
                                                        </option>
                                                        <?php
                                                    }
                                                        ?>
                                                </select>
                                        </li> -->
                                            <li class="sr-sea">
                                                <input type="text" autocomplete="off" id="select-search"
                                                    placeholder="<?php echo $Zitiziti['SEARCHBOX_LABEL']; ?>"
                                                    class="search-field rounded" required>

                                                <ul id="results" class="tser-res tser-res1">
                                                    <!-- <?php
                                                            $si = 1;
                                                            foreach (getAllSearch() as $search_header_row) {
                                                            ?>
                                                            <li>
                                                                <div>
                                                                    <h4><?php echo $search_header_row['search_title']; ?></h4>
                                                                    <span><?php echo $search_header_row['search_tag_line']; ?></span>
                                                                    <a href="<?php echo $search_header_row['search_list_link']; ?>"></a>
                                                                </div>
                                                            </li>
                                                        <?php
                                                            }
                                                        ?> -->
                                                </ul>
                                            </li>
                                            <li class="sr-btn">
                                                <input type="submit" id="filter_submit" name="filter_submit"
                                                    value="<?php echo $Zitiziti['SEARCH']; ?>" class="filter_submit rounded">
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>

                            <div class="ban-short-links">
                                <ul>
                                    <?php if ($footer_row['admin_listing_show'] == 1) { ?>
                                        <li>
                                            <div>
                                                <img src="<?php echo $slash; ?>/images/icon/shop.png" alt="">
                                                <h4><?php echo $Zitiziti['ALL_CATEGORY']; ?></h4>
                                                <a href="/all-category" class="fclick"></a>
                                            </div>
                                        </li>
                                    <?php }
                                    if ($footer_row['admin_expert_show'] == 1) { ?>
                                        <li>
                                            <div>
                                                <img src="<?php echo $slash; ?>/images/icon/expert.png" alt="">
                                                <h4><?php echo $Zitiziti['SERVICE-EXPERTS-EXPERTS']; ?></h4>
                                                <a href="/service-experts" class="fclick"></a>
                                            </div>
                                        </li>
                                    <?php }
                                    if ($footer_row['admin_job_show'] == 1) { ?>
                                        <li>
                                            <div>
                                                <img src="<?php echo $slash; ?>/images/icon/employee.png" alt="">
                                                <h4><?php echo $Zitiziti['JOBS']; ?></h4>
                                                <a href="/jobs" class="fclick"></a>
                                            </div>
                                        </li>
                                    <?php }
                                    if ($footer_row['admin_place_show'] == 1) { ?>
                                        <li>
                                            <div>
                                                <img src="<?php echo $slash; ?>/images/places/icons/hot-air-balloon.png" alt="">
                                                <h4><?php echo $Zitiziti['PLACE-TRAVEL']; ?></h4>
                                                <a href="/places" class="fclick"></a>
                                            </div>
                                        </li>
                                    <?php }
                                    if ($footer_row['admin_news_show'] == 1) { ?>
                                        <li>
                                            <div>
                                                <img src="<?php echo $slash; ?>/images/icon/news.png" alt="">
                                                <h4><?php echo $Zitiziti['NEWS']; ?></h4>
                                                <a href="/news" class="fclick"></a>
                                            </div>
                                        </li>
                                    <?php }
                                    if ($footer_row['admin_event_show'] == 1) { ?>
                                        <li>
                                            <div>
                                                <img src="<?php echo $slash; ?>/images/icon/calendar.png" alt="">
                                                <h4><?php echo $Zitiziti['EVENTS']; ?></h4>
                                                <a href="/events" class="fclick"></a>
                                            </div>
                                        </li>
                                    <?php }
                                    if ($footer_row['admin_product_show'] == 1) { ?>
                                        <li>
                                            <div>
                                                <img src="<?php echo $slash; ?>/images/icon/cart.png" alt="">
                                                <h4><?php echo $Zitiziti['PRODUCTS']; ?></h4>
                                                <a href="/all-products" class="fclick"></a>
                                            </div>
                                        </li>
                                    <?php }
                                    if ($footer_row['admin_coupon_show'] == 1) { ?>
                                        <li>
                                            <div>
                                                <img src="<?php echo $slash; ?>/images/icon/coupons.png" alt="">
                                                <h4><?php echo $Zitiziti['COUPONS']; ?></h4>
                                                <a href="/coupons" class="fclick"></a>
                                            </div>
                                        </li>
                                    <?php }
                                    if ($footer_row['admin_blog_show'] == 1) { ?>
                                        <!-- <li>
                                    <div>
                                        <img src="<?php echo $slash; ?>/images/icon/blog1.png" alt="">
                                        <h4><?php echo $Zitiziti['BLOGS']; ?></h4>
                                        <a href="/blog-posts" class="fclick"></a>
                                    </div>
                                </li> -->
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="h2-ban-ql">
                                <ul>
                                    <?php if ($footer_row['admin_listing_show'] == 1) { ?>
                                        <li>
                                            <div>
                                                <img src="<?php echo $slash; ?>/images/icon/listing.png" alt="">
                                                <h5><span
                                                        class="count1"><?php echo AddingZero_BeforeNumber(getCountCategory()); ?></span><?php echo $Zitiziti['ALL_SERVICES']; ?>
                                                </h5>
                                                <a href="/all-category">&nbsp;</a>
                                            </div>
                                        </li>
                                    <?php }
                                    if ($footer_row['admin_expert_show'] == 1) { ?>
                                        <li>
                                            <div>
                                                <img src="<?php echo $slash; ?>/images/icon/expert.png" alt="">
                                                <h5><span
                                                        class="count1"><?php echo AddingZero_BeforeNumber(getCountCategory()); ?></span><?php echo $Zitiziti['SERVICE-EXPERTS']; ?>
                                                </h5>
                                                <a href="/service-experts">&nbsp;</a>
                                            </div>
                                        </li>
                                    <?php }
                                    if ($footer_row['admin_job_show'] == 1) { ?>
                                        <li>
                                            <div>
                                                <img src="<?php echo $slash; ?>/images/icon/employee.png" alt="">
                                                <h5>
                                                    <span
                                                        class="count1"><?php echo AddingZero_BeforeNumber(getCountCategory()); ?></span><?php echo $Zitiziti['JOBS']; ?>
                                                </h5>
                                                <a href="/jobs">&nbsp;</a>
                                            </div>
                                        </li>
                                    <?php }
                                    if ($footer_row['admin_product_show'] == 1) { ?>
                                        <li>
                                            <div>
                                                <img src="<?php echo $slash; ?>/images/icon/shop.png" alt="">
                                                <h5><span
                                                        class="count1"><?php echo AddingZero_BeforeNumber(getCountProduct()); ?></span><?php echo $Zitiziti['PRODUCTS']; ?>
                                                </h5>
                                                <a href="/all-products">&nbsp;</a>
                                            </div>
                                        </li>
                                    <?php }
                                    if ($footer_row['admin_event_show'] == 1) { ?>
                                        <li>
                                            <div>
                                                <img src="<?php echo $slash; ?>/images/icon/event.png" alt="">
                                                <h5><span
                                                        class="count1"><?php echo AddingZero_BeforeNumber(getCountEvent()); ?></span><?php echo $Zitiziti['EVENTS']; ?>
                                                </h5>
                                                <a href="/events">&nbsp;</a>
                                            </div>
                                        </li>
                                    <?php }
                                    if ($footer_row['admin_coupon_show'] == 1) { ?>
                                        <li>
                                            <div>
                                                <img src="<?php echo $slash; ?>/images/icon/coupons.png" alt="">
                                                <h5><span
                                                        class="count1"><?php echo AddingZero_BeforeNumber(getCountCoupon()); ?></span><?php echo $Zitiziti['COUPONS']; ?>
                                                </h5>
                                                <a href="/coupons">&nbsp;</a>
                                            </div>
                                        </li>
                                    <?php }
                                    if ($footer_row['admin_blog_show'] == 1) { ?>
                                        <!-- <li>
                                    <div>
                                        <img src="<?php echo $slash; ?>/images/icon/blog.png" alt="">
                                        <h5><span
                                                class="count1"><?php echo AddingZero_BeforeNumber(getCountBlog()); ?></span><?php echo $Zitiziti['BLOGS']; ?>
                                        </h5>
                                        <a href="/blog-posts">&nbsp;</a>
                                    </div>
                                </li> -->
                                    <?php } ?>
                                    <li>
                                        <div>
                                            <img src="<?php echo $slash; ?>/images/icon/general.png" alt="">
                                            <h5><span
                                                    class="count1"><?php echo AddingZero_BeforeNumber(getCountUser()); ?></span><?php echo $Zitiziti['COMMUNITY']; ?>
                                            </h5>
                                            <a href="/community">&nbsp;</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <span class="bg">&nbsp;</span>
    <!-- END -->