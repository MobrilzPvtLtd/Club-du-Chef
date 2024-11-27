<?php
include "header.php";

if (file_exists('config/user_authentication.php')) {
    include('config/user_authentication.php');
}

if (file_exists('config/general_user_authentication.php')) {
    include('config/general_user_authentication.php');
}

if (file_exists('config/event_page_authentication.php')) {
    include('config/event_page_authentication.php');
}
//To check the event count with current plan starts

$plan_type_event_count = $user_plan_type['plan_type_event_count'];
$event_count_user = getCountUserEvent($_SESSION['user_id']);

if ($event_count_user >= $plan_type_event_count) {

    $_SESSION['status_msg'] = $Zitiziti['EVENTS_LIMIT_EXCEED_MESSAGE'];

    header('Location: db-events');
    exit();
}
//To check the event count with current plan ends

?>
<!-- START -->
<!--PRICING DETAILS-->
<section class="<?php if ($footer_row['admin_language'] == 2) {
    echo "lg-arb";
} ?> login-reg">
    <div class="container">
        <div class="row">
            <div class="login-main add-list">
                <div class="log-bor">&nbsp;</div>
                <span class="steps"><?php echo $Zitiziti['ADD_NEW_EVENT']; ?></span>
                <div class="log">
                    <div class="login add-list-off">
                        <?php include "page_level_message.php"; ?>
                        <h4><?php echo $Zitiziti['CREATE_EVENT']; ?></h4>
                        <form action="event_insert.php" class="event_form" id="event_form" name="event_form"
                              method="post" enctype="multipart/form-data">
                            <ul>
                                <li>
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="event_name" required="required"
                                                       class="form-control" id="event_name"
                                                       placeholder="<?php echo $Zitiziti['EVENT_NAME']; ?>*">
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="event_address" required="required"
                                                       class="form-control" id="event_address"
                                                       placeholder="<?php echo $Zitiziti['ADDRESS']; ?>*">
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
                                                    <option value=""><?php echo $Zitiziti['SELECT_CATEGORY']; ?></option>
                                                    <?php
                                                    foreach (getAllEventCategories() as $categories_row) {
                                                        ?>
                                                        <option <?php if ($_SESSION['category_id'] == $categories_row['category_id']) {
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
                                                <select onChange="geteventCities(this.value);" name="country_id"
                                                        required="required" id="country_id"
                                                        class="chosen-select form-control">
                                                    <option value=""><?php echo $Zitiziti['SELECT_YOUR_COUNTRY']; ?></option>
                                                    <?php
                                                    //Countries Query
                                                    $admin_countries = $footer_row['admin_countries'];
                                                    $catArray = explode(',', $admin_countries);
                                                    foreach($catArray as $cat_Array) {

                                                        foreach (getMultipleCountry($cat_Array) as $countries_row) {
                                                            ?>
                                                            <option value="<?php echo $countries_row['country_id']; ?>"><?php echo $countries_row['country_name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select data-placeholder="<?php echo $Zitiziti['SELECT_YOUR_CITY']; ?>"
                                                        name="city_id[]" id="city_id" multiple required="required"
                                                        class="chosen-select form-control">
                                                    <option value=""><?php echo $Zitiziti['SELECT_YOUR_CITY']; ?></option>

                                                </select>
                                            </div>
                                        </div>
                                    </div> -->
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
                                                        <option
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
                                    <!--FILED END-->
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="event_start_date" required="required"
                                                       class="form-control"
                                                       placeholder="<?php echo $Zitiziti['DATE']; ?>*" id="newdate">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="event_time" required="required"
                                                       class="form-control"
                                                       placeholder="<?php echo $Zitiziti['TIME']; ?>*">
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="form-control" required="required"
                                                          name="event_description" id="event_description"
                                                          placeholder="<?php echo $Zitiziti['EVENT_DETAILS']; ?>"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="form-control" name="event_map"
                                                          placeholder="<?php echo $Zitiziti['GOOGLE_MAP_LOCATION']; ?>"></textarea>
                                                <!-- INPUT TOOL TIP -->
                                                <div class="inp-ttip">
                                                    <b><?php echo $Zitiziti['EVENT_IFRAME_FROM_GOOGLE']; ?></b><?php echo $Zitiziti['EVENT_COPY_PASTE_IFRAME_FROM_GOOGLE']; ?>
                                                </div>
                                                <!-- END INPUT TOOL TIP -->
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?php echo $Zitiziti['CHOOSE_BANNER_IMAGE']; ?></label>
                                                <div class="fil-img-uplo">
                                                    <span class="dumfil"><?php echo $Zitiziti['UPLOAD_A_FILE']; ?></span>
                                                    <input type="file" name="event_image"
                                                           accept="image/*,.jpg,.jpeg,.png" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="event_contact_name" required="required"
                                                       class="form-control"
                                                       placeholder="<?php echo $Zitiziti['CONTACT_PERSON']; ?>*">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="event_mobile" required="required"
                                                       class="form-control"
                                                       placeholder="<?php echo $Zitiziti['CONTACT_PHONE_NUMBER']; ?>*">
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->

                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="email" name="event_email" required="required"
                                                       class="form-control"
                                                       placeholder="<?php echo $Zitiziti['CONTACT_EMAIL_ID']; ?>*">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="event_website" class="form-control"
                                                       placeholder="<?php echo $Zitiziti['EVENT_WEBSITE']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div>
                                                <div class="chbox">
                                                    <input type="checkbox" id="isenquiry" name="isenquiry" checked="">
                                                    <label
                                                            for="isenquiry"><?php echo $Zitiziti['ENQUIRY_BOX_ENABLE']; ?></label>
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
                                    <button type="submit" name="event_submit"
                                            class="btn btn-primary"><?php echo $Zitiziti['SUBMIT']; ?></button>
                                </div>
                                <div class="col-md-12">
                                    <a href="dashboard" class="skip"><?php echo $Zitiziti['GO_TO_USER_DASHBOARD']; ?>
                                        >></a>
                                </div>
                            </div>
                            <!--FILED END-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--END PRICING DETAILS-->


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript">var webpage_full_link = '<?php echo $webpage_full_link;?>';</script>
<script type="text/javascript">var login_url = '<?php echo $LOGIN_URL;?>';</script>
<script src="js/custom.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/custom_validation.js"></script>
<script src="js/select-opt.js"></script>
<script src="admin/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('event_description');
</script>
<script>
    function geteventCities(val) {
        $.ajax({
            type: "POST",
            url: "city_process.php",
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
    <script src="js/google-geo-location-event-add.js">
    </script>
<?php } ?>
</body>

</html>