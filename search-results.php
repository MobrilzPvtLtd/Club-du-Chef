<?php
include "header.php";


if(isset($_GET['q'])) {
    $select_search = $_GET['q'];

    $CurrentCity = isset($_SESSION['city']) ? $_SESSION['city'] : 'www';

if($select_search != ''){
//get matched data from listings table
    $listings_qry = "SELECT * FROM " . TBL . "listings WHERE listing_description LIKE '%$select_search%' 
     OR listing_address LIKE '%$select_search%'  OR service_id LIKE '%$select_search%' OR service_1_name LIKE '%$select_search%' 
     OR service_1_detail LIKE '%$select_search%' OR listing_info_question LIKE '%$select_search%' OR listing_info_answer LIKE '%$select_search%'
     OR service_locations LIKE '%$select_search%' OR listing_name LIKE '%$select_search%' 
     AND (JSON_CONTAINS(city_slug, '\"$CurrentCity\"') OR '$CurrentCity' = 'www') AND listing_is_delete != '2'  ";
    $listings_query = mysqli_query($conn, $listings_qry);
} else{
    //get matched data from listings table
    $listings_qry = "SELECT * FROM " . TBL . "listings WHERE (JSON_CONTAINS(city_slug, '\"$CurrentCity\"') OR '$CurrentCity' = 'www') AND listing_is_delete != '2'  ";
    $listings_query = mysqli_query($conn, $listings_qry);
}

//get matched data from events table
    $event_qry = "SELECT * FROM " . TBL . "events WHERE event_description LIKE '%$select_search%' 
    OR event_name LIKE '%$select_search%' OR event_address LIKE '%$select_search%' AND (JSON_CONTAINS(city_slug, '\"$CurrentCity\"') OR '$CurrentCity' = 'www')";
    $event_query = mysqli_query($conn, $event_qry);

//get matched data from blog table
    $blog_qry = "SELECT * FROM " . TBL . "blogs WHERE blog_description LIKE '%$select_search%' 
    OR blog_name LIKE '%$select_search%' AND (JSON_CONTAINS(city_slug, '\"$CurrentCity\"') OR '$CurrentCity' = 'www')";
    $blog_query = mysqli_query($conn, $blog_qry);

//get matched data from product table
    $product_qry = "SELECT * FROM " . TBL . "products WHERE product_description LIKE '%$select_search%' 
    OR product_name LIKE '%$select_search%' OR product_info_question LIKE '%$select_search%' 
    OR product_info_answer LIKE '%$select_search%' OR product_highlights LIKE '%$select_search%' 
    OR product_tags LIKE '%$select_search%' AND (JSON_CONTAINS(city_slug, '\"$CurrentCity\"') OR '$CurrentCity' = 'www')";
    $product_query = mysqli_query($conn, $product_qry);

//get matched data from Job table
    $job_qry = "SELECT * FROM " . TBL . "jobs WHERE job_description LIKE '%$select_search%' 
    OR job_title LIKE '%$select_search%' OR job_small_description LIKE '%$select_search%' 
    OR job_company_name LIKE '%$select_search%' OR skill_set LIKE '%$select_search%' 
    OR contact_person LIKE '%$select_search%' AND (JSON_CONTAINS(city_slug, '\"$CurrentCity\"') OR '$CurrentCity' = 'www')";
    $job_query = mysqli_query($conn, $job_qry);

    //get matched data from Service Expert table
    $expert_qry = "SELECT * FROM " . TBL . "experts WHERE profile_name LIKE '%$select_search%' AND (JSON_CONTAINS(city_slug, '\"$CurrentCity\"') OR '$CurrentCity' = 'www')";
    $expert_query = mysqli_query($conn, $expert_qry);
}
?>
<!-- START -->
<section class="<?php if ($footer_row['admin_language'] == 2) {
    echo "lg-arb";
} ?> ser-head">
    <div class="container d-flex justify-content-center fl-di">
        <div class="blog-head-inn">
            <h1 class="ps-4"><?php echo $Zitiziti['SEARCH-RESULTS-SEARCH-RESULTS']; ?></h1>
        </div>
        <div class="ban-search">
            <form>
                <ul>
                    <!-- <li class="sr-sea">
                        <input type="text" id="select-search" value="<?php echo $select_search; ?>" class="autocomplete"
                            placeholder="<?php echo $Zitiziti['SEARCH-RESULTS-SEARCH-ANYTHING-PLACEHOLDER']; ?>">
                    </li>
                    <li class="sr-btn">
                        <input type="submit" id="search_result_page_filter_submit" name="filter_submit"
                            value="<?php echo $Zitiziti['SEARCH']; ?>" class="filter_submit">
                    </li> -->
                    <li class="sr-sea">
                        <input type="text" autocomplete="off" id="select-search" value="<?php echo $select_search; ?>" placeholder="<?php echo $Zitiziti['SEARCHBOX_LABEL']; ?>"
                            class="search-field rounded" required>

                        <ul id="results" class="tser-res tser-res1">
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
</section>
<!--END-->

<?php
//No results found section
if (mysqli_num_rows($listings_query) <= 0 && mysqli_num_rows($event_query) <= 0 && mysqli_num_rows($blog_query) <= 0 && mysqli_num_rows($product_query) <= 0 && mysqli_num_rows($job_query) <= 0 && mysqli_num_rows($expert_query) <= 0 || $select_search == NULL || empty($select_search)) {
    ?>
<div class="container text-center"><?php echo $Zitiziti['SEARCH-RESULTS-OOPS-NO-RESULTS-FOUND']; ?>
    <b><?php echo $select_search; ?></b>. <?php echo $Zitiziti['SEARCH-RESULTS-PLEASE-TRY-WITH-OTHER']; ?></div>
<?php
}
else {
    $count = mysqli_num_rows($listings_query) + mysqli_num_rows($event_query) +  mysqli_num_rows($blog_query) + mysqli_num_rows($product_query) + mysqli_num_rows($job_query)+ mysqli_num_rows($expert_query);
    ?>
<div class="container ser-re-hu"><?php echo $Zitiziti['SEARCH-RESULTS-HURRAY']; ?> <?php echo $count; ?>
    <?php echo $Zitiziti['SEARCH-RESULTS-RESULTS-FOUND-FOR']; ?> <b><?php echo $select_search; ?></b>.</div>
<?php
}
?>


<!-- START -->
<section class="<?php if ($footer_row['admin_language'] == 2) {
    echo "lg-arb";
} ?> event-body ser-resu">
    <div class="container">
        <div class="row">
            <ul id="intseres">

                <?php
                //                <!--                //Listing search print starts-->
                if (mysqli_num_rows($listings_query) > 0) {
                    while ($listings_row = mysqli_fetch_array($listings_query)) {

                        $decoded_city_slugs = (array)json_decode($listings_row['city_slug'], true);
                        if ($CurrentCity == 'www' || in_array($CurrentCity, $decoded_city_slugs)) {
                ?>
                <li>
                    <div class="smbox">
                        <div class="ser0"><img src="<?php if ($listings_row['profile_image'] != NULL || !empty($listings_row['profile_image'])) {
                                            echo "images/listings/" . $listings_row['profile_image'];
                                        } else {
                                            echo "images/listings/" . $footer_row['listing_default_image'];
                                        } ?>">
                        </div>
                        <div class="ser1">
                            <a
                                href="<?php echo $LISTING_URL.urlModifier($listings_row['listing_slug']); ?>"><?php echo $listings_row['listing_name']; ?></a>
                        </div>
                        <span class="ser2"><?php echo $Zitiziti['LISTING']; ?></span>
                        <div class="ser3">
                            <?php
                                    if (strlen($listings_row['listing_description']) >= 50) {
                                        $pos = strpos($listings_row['listing_description'], ' ', 50);
                                        echo substr(stripslashes($listings_row['listing_description']), 0, $pos);
                                    }else{
                                        echo stripslashes($listings_row['listing_description']);
                                    }

                                    ?>

                        </div>
                        <span class="ser4">
                            <a
                                href="<?php echo $LISTING_URL.urlModifier($listings_row['listing_slug']); ?>"><?php echo $LISTING_URL.urlModifier($listings_row['listing_slug']); ?></a>
                        </span>
                    </div>
                </li>
                <?php
                        }
                    }
                }
                //                <!--                //Listing search print ends-->

                //                <!--                //Event search print starts-->


                if (mysqli_num_rows($event_query) > 0) {
                    while ($events_row = mysqli_fetch_array($event_query)) {

                        $decoded_city_slugs = (array)json_decode($events_row['city_slug'], true);
                        if ($CurrentCity == 'www' || in_array($CurrentCity, $decoded_city_slugs)) {
                    ?>
                <li>
                    <div class="smbox">
                        <div class="ser0">
                            <img loading="lazy" src="images/events/<?php echo $events_row['event_image']; ?>" alt="">
                        </div>
                        <div class="ser1">
                            <a
                                href="<?php echo $EVENT_URL.urlModifier($events_row['event_slug']); ?>"><?php echo $events_row['event_name']; ?></a>
                        </div>
                        <span class="ser2 ser-ev"><?php echo $Zitiziti['EVENT']; ?></span>
                        <div class="ser3">

                            <?php
                                    if (strlen($events_row['event_description']) >= 50) {
                                        $pos = strpos($events_row['event_description'], ' ', 50);
                                        echo substr(stripslashes($events_row['event_description']), 0, $pos);
                                    } else {
                                        echo stripslashes($events_row['event_description']);
                                    }
                                    ?>
                        </div>
                        <span class="ser4">
                            <a
                                href="<?php echo $EVENT_URL.urlModifier($events_row['event_slug']); ?>"><?php echo $EVENT_URL.urlModifier($events_row['event_slug']); ?></a>
                        </span>
                    </div>
                </li>
                <?php
                        }
                    }
                }
                //                <!--                //Event search print ends-->

                //                <!--                //Blog search print starts-->

                if (mysqli_num_rows($blog_query) > 0) {
                    while ($blog_row = mysqli_fetch_array($blog_query)) {
                        $decoded_city_slugs = (array)json_decode($blog_row['city_slug'], true);
                        if ($CurrentCity == 'www' || in_array($CurrentCity, $decoded_city_slugs)) {
                        ?>
                <li>
                    <div class="smbox">
                        <div class="ser0">
                            <img loading="lazy" src="images/blogs/<?php echo $blog_row['blog_image']; ?>" alt="">
                        </div>
                        <div class="ser1"><a
                                href="<?php echo $BLOG_URL.urlModifier($blog_row['blog_slug']); ?>"><?php echo $blog_row['blog_name']; ?></a>
                        </div>
                        <span class="ser2 ser-bl"><?php echo $Zitiziti['BLOG']; ?></span>
                        <div class="ser3">
                            <?php
                                    if (strlen($blog_row['blog_description']) >= 50) {
                                        $pos = strpos($blog_row['blog_description'], ' ', 50);
                                        echo substr(stripslashes($blog_row['blog_description']), 0, $pos);
                                    }else{
                                        echo stripslashes($blog_row['blog_description']);
                                    }

                                    ?>
                        </div>
                        <span class="ser4">
                            <a
                                href="<?php echo $BLOG_URL.urlModifier($blog_row['blog_slug']); ?>"><?php echo $BLOG_URL.urlModifier($blog_row['blog_slug']); ?></a>
                        </span>
                    </div>
                </li>
                <?php
                        }
                    }
                }
                //                <!--                //Blog search print ends-->

                //                <!--                //Product search print starts-->

                if (mysqli_num_rows($product_query) > 0) {
                    while ($product_row = mysqli_fetch_array($product_query)) {
                        $decoded_city_slugs = (array)json_decode($product_row['city_slug'], true);
                        if ($CurrentCity == 'www' || in_array($CurrentCity, $decoded_city_slugs)) {
                        ?>
                <li>
                    <div class="smbox">
                        <div class="ser0">
                            <img loading="lazy"
                                src="images/products/<?php echo array_shift(explode(',', $product_row['gallery_image'])); ?>"
                                alt="">
                        </div>
                        <div class="ser1"><a
                                href="<?php echo $PRODUCT_URL.urlModifier($product_row['product_slug']); ?>"><?php echo $product_row['product_name']; ?></a>
                        </div>
                        <span class="ser2 ser-bl"><?php echo $Zitiziti['PRODUCT']; ?></span>
                        <div class="ser3">
                            <?php
                                    if (strlen($product_row['product_description']) >= 50) {
                                        $pos = strpos($product_row['product_description'], ' ', 50);
                                        echo substr(stripslashes($product_row['product_description']), 0, $pos);
                                    }else{
                                        echo stripslashes($product_row['product_description']);
                                    }

                                    ?>
                        </div>
                        <span class="ser4">
                            <a
                                href="<?php echo $PRODUCT_URL.urlModifier($product_row['product_slug']); ?>"><?php echo $PRODUCT_URL.urlModifier($product_row['product_slug']); ?></a>
                        </span>
                    </div>
                </li>
                <?php
                        }
                    }
                }
                //                <!--                //Product search print ends-->

                //                <!--                //Job search print starts-->

                if (mysqli_num_rows($job_query) > 0) {
                    while ($job_row = mysqli_fetch_array($job_query)) {
                        $decoded_city_slugs = (array)json_decode($job_row['city_slug'], true);
                        if ($CurrentCity == 'www' || in_array($CurrentCity, $decoded_city_slugs)) {
                        ?>
                <li>
                    <div class="smbox">
                        <div class="ser0">
                            <img loading="lazy" src="jobs/images/jobs/<?php echo $job_row['company_logo']; ?>" alt="">
                        </div>
                        <div class="ser1"><a
                                href="<?php echo $JOB_URL.urlModifier($job_row['job_slug']); ?>"><?php echo $job_row['job_title']; ?></a>
                        </div>
                        <span class="ser2 ser-bl"><?php echo $Zitiziti['JOB']; ?></span>
                        <div class="ser3">
                            <?php
                                    if (strlen($job_row['job_description']) >= 50) {
                                        $pos = strpos($job_row['job_description'], ' ', 50);
                                        echo substr(stripslashes($job_row['job_description']), 0, $pos);
                                    }else{
                                        echo stripslashes($job_row['job_description']);
                                    }

                                    ?>
                        </div>
                        <span class="ser4">
                            <a
                                href="<?php echo $JOB_URL.urlModifier($job_row['job_slug']); ?>"><?php echo $JOB_URL.urlModifier($job_row['job_slug']); ?></a>
                        </span>
                    </div>
                </li>
                <?php
                        }
                    }
                }
                //                <!--                //Job search print ends-->

                //                <!--                //Expert search print starts-->

                if (mysqli_num_rows($expert_query) > 0) {
                    while ($expert_row = mysqli_fetch_array($expert_query)) {
                        $decoded_city_slugs = (array)json_decode($expert_row['city_slug'], true);
                        if ($CurrentCity == 'www' || in_array($CurrentCity, $decoded_city_slugs)) {
                        ?>
                <li>
                    <div class="smbox">
                        <div class="ser0">
                            <img loading="lazy"
                                src="service-experts/images/services/<?php echo $expert_row['profile_image']; ?>"
                                alt="">
                        </div>
                        <div class="ser1"><a
                                href="<?php echo $SERVICE_EXPERT_URL . urlModifier($expert_row['expert_slug']); ?>"><?php echo $expert_row['profile_name']; ?></a>
                        </div>
                        <span class="ser2 ser-bl"><?php echo $Zitiziti['SERVICE-EXPERTS']; ?></span>
                        <span class="ser4">
                            <a
                                href="<?php echo $SERVICE_EXPERT_URL . urlModifier($expert_row['expert_slug']); ?>"><?php echo $SERVICE_EXPERT_URL . urlModifier($expert_row['expert_slug']); ?></a>
                        </span>
                    </div>
                </li>
                <?php
                        }
                    }
                }
                //                <!--                //Expert search print ends-->

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
                                <input type="text" class="form-control"
                                    placeholder="<?php echo $Zitiziti['LEAD-NAME-PLACEHOLDER']; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control"
                                    placeholder="<?php echo $Zitiziti['ENTER_EMAIL_STAR']; ?>"
                                    pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$"
                                    title="<?php echo $Zitiziti['LEAD-INVALID-EMAIL-TITLE']; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control"
                                    placeholder="<?php echo $Zitiziti['LEAD-MOBILE-PLACEHOLDER']; ?>"
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
<?php
include "footer.php";
?>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript">
var webpage_full_link = '<?php echo $webpage_full_link;?>';
</script>
<script type="text/javascript">
var login_url = '<?php echo $LOGIN_URL;?>';
</script>
<script src="js/custom.js"></script>
</body>

</html>