<?php

include "home_page_top_section.php";

if ($current_home_page != '2' && $current_home_page != '3') {
?>
    <div class="ban-ql">
        <div class="container">
            <div class="row">
                <?php 
                    // if ($CurrentCity == 'www' || !$imageShow) {
                ?>
                <!-- <ul>
                    <?php
                        foreach (getAllHomePageTopSection() as $home_page_top_section_row) {
                    ?>
                        <li>
                            <div>
                                <img
                                    src="<?php echo htmlspecialchars($webpage_full_link . 'images/icon/' . $home_page_top_section_row['top_section_image']); ?>"
                                    alt="" class="cityimg">
                                <h4><?php echo htmlspecialchars($home_page_top_section_row['top_section_title']); ?></h4>
                                <p><?php echo htmlspecialchars($home_page_top_section_row['top_section_description']); ?></p>
                                <a href="<?php echo htmlspecialchars($home_page_top_section_row['top_section_link']); ?>">
                                    <?php echo htmlspecialchars($home_page_top_section_row['top_section_link_text']); ?>
                                </a>
                            </div>
                        </li>
                    <?php
                        }
                    ?>
                </ul> -->
                <?php
                    // } else {
                ?> 
                <ul>
                    <!-- <?php
                    foreach ($images as $index => $imageUrl) {
                        $link = isset($imageLinks[$index]) ? $imageLinks[$index] : '#';
                        echo '<a href="' . $link . '" target="_blank"><li><div class="mob_card p-0 " ><img class="img-fluid ratio ratio-3x4 object-fit-contain" src="' . $imageUrl . '" alt=""></div></li></a>';
                    }
                    ?> -->
                    <?php
                    foreach ($images as $index => $imageUrl) {
                        $link = isset($imageLinks[$index]) ? $imageLinks[$index] : '#';
                    ?>
                        <a href="<?php echo $link; ?>" target="_blank">
                        <li class="d-flex justify-content-center">
                            <div class="p-0 h-40 mx-2">
                                <img class="ratio ratio-3x4" src="<?php echo $imageUrl; ?>" alt="">
                            </div>
                        </li>
                        </a>
                    <?php
                    }
                    ?>
                </ul>
                <?php
                    // }
                ?>
            </div>
        </div>
    </div>

    <!-- START -->
    <section>
        <div class="str container">
            <div class="d-flex flex-column justify-content-center align-items-center ">
                <div class="home-tit d-flex flex-column justify-content-center align-items-center">
                    <h2><span><?php echo $Zitiziti['HOM-POP-TIT']; ?></span> <?php echo $Zitiziti['HOM-POP-TIT1']; ?></h2>
                    <p><?php echo $Zitiziti['HOM-POP-SUB-TIT']; ?></p>
                </div>
                <div class="plac-hom-all-pla">

                    <ul>
                        <?php
                        if ($current_home_page == '3' || $current_home_page == '4' || $current_home_page == '5' || $current_home_page == '6' || $current_home_page == '7' || $current_home_page == '8' || $current_home_page == '9') {

                            $all_cat_function = getAllCategoriesPos();
                        } else {
                            $all_cat_function = getAllTopCategories();
                        }

                        foreach ($all_cat_function as $toprow) {

                            $category_name = $toprow['category_name'];

                            if ($current_home_page == '3' || $current_home_page == '4' || $current_home_page == '5' || $current_home_page == '6' || $current_home_page == '7' || $current_home_page == '8' || $current_home_page == '9') {

                                $category_sql_row = getNameCategory($category_name);
                            } else {
                                $category_sql_row = getCategory($category_name);
                            }
                            $decoded_city_slugs = (array)json_decode($category_sql_row['city_slug'], true);
                            if ($CurrentCity == 'www' || in_array($CurrentCity, $decoded_city_slugs)) {
                        ?>
                            <li>
                                <div class="plac-hom-box">
                                    <div class="plac-hom-box-im">
                                        <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="b-lazy" data-src="<?php echo $webpage_full_link; ?>images/services/<?php echo $category_sql_row['category_image']; ?>" alt="">
                                        <h4><?php echo $category_sql_row['category_name']; ?></h4>
                                    </div>
                                    <div class="rel-list-txt-box">
                                        <?php
                                        if ($current_home_page == '3' || $current_home_page == '4' || $current_home_page == '5' || $current_home_page == '6' || $current_home_page == '7' || $current_home_page == '8' || $current_home_page == '9') {
                                        ?>
                                            <span
                                                class="dir-ho-cat"><?php echo $Zitiziti['LISTINGS']; ?> <?php echo AddingZero_BeforeNumber(getCountCategoryListing($category_sql_row['category_id'])); ?></span>
                                        <?php
                                        } else {
                                        ?>
                                            <span
                                                class="dir-ho-cat"><?php echo $Zitiziti['SHOW_ALL']; ?> (<?php echo AddingZero_BeforeNumber(getCountCategoryListing($category_sql_row['category_id'])); ?>
                                                )</span>
                                        <?php
                                        }
                                        ?>
                                        <span class="rat-more-cta-ic"><?php echo $Zitiziti['PLACE-MORE-DETAILS']; ?></span>
                                    </div>
                                    <a href="<?php echo $ALL_LISTING_URL . urlModifier($category_sql_row['category_slug']); ?>" class="fclick"></a>
                                </div>
                            </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="hom-cate-more">
                    <?php if ($current_home_page == '1' || $current_home_page == '2') { ?>
                    <a href=" all-category" class="cta-new-blue"><?php echo $Zitiziti['HOM-VI-ALL-SER']; ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- END -->
<?php } ?>
<?php
include "home_page_mid_section.php"
?>

<!-- START -->
<!-- <section>
    <div class="hom-ads">
        <div class="container">
            <div class="row">
                <div class="filt-com lhs-ads">
                    <div class="ads-box">
                        <?php
                        $ad_position_id = 1;   //Ad position on home page bottom
                        $get_ad_row = getAds($ad_position_id);
                        $ad_enquiry_photo = $get_ad_row['ad_enquiry_photo'];
                        ?>
                        <a href="<?php echo stripslashes($get_ad_row['ad_link']); ?>">
                            <span><?php echo $Zitiziti['AD']; ?></span>

                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="b-lazy" data-src="<?php echo $webpage_full_link; ?>images/ads/<?php if ($ad_enquiry_photo != NULL || !empty($ad_enquiry_photo)) {
                                                                                                                                                                                            echo $ad_enquiry_photo;
                                                                                                                                                                                        } else {
                                                                                                                                                                                            echo "ads2.jpg";
                                                                                                                                                                                        } ?>" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- END -->

<!-- START -->
<div class="ani-quo">
    <div class="ani-q1">
        <h4><?php echo $Zitiziti['HOM-WHAT-LOOK-TIT']; ?></h4>
        <p><?php echo $Zitiziti['HOM-WHAT-LOOK-SUB']; ?></p>
        <span><?php echo $Zitiziti['HOM-WHAT-LOOK-CTA']; ?></span>
    </div>
    <div class="ani-q2">
        <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="b-lazy" data-src="<?php echo $webpage_full_link; ?>images/quote.png" alt="">
    </div>
</div>
<!-- END -->