<?php
include "header.php";

if (file_exists('config/user_authentication.php')) {
    include('config/user_authentication.php');
}

if (file_exists('config/general_user_authentication.php')) {
    include('config/general_user_authentication.php');
}

if (file_exists('config/product_page_authentication.php')) {
    include('config/product_page_authentication.php');
}
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
                <span class="steps"><?php echo $Zitiziti['EDIT_PRODUCT']; ?></span>
                <div class="log">
                    <div class="login add-list-off">
                        <?php
                            $product_codea = $_GET['code'];
                            $products_a_row = getProduct($product_codea);
                        
                            // Fetch query of booking_availability
                            $check_query = "SELECT * FROM " . TBL . "booking_availability WHERE booking_type_id = '{$products_a_row['product_id']}' AND is_available = 1 AND booking_type = 'product'";
                            $availability_day_result = mysqli_query($conn, $check_query);

                            $availability_days = [];
                            while ($availability = mysqli_fetch_assoc($availability_day_result)) {
                                $availability_days[$availability['day']] = $availability;
                            }
                            global $products_a_row;

                            $edit_a_row = $products_a_row; 
                        ?>

                        <h4><?php echo $Zitiziti['EDIT_THIS_PRODUCT']; ?></h4>
                        <?php include "page_level_message.php"; ?>
                        <form action="product_update.php" class="product_form" id="product_form" name="product_form"
                              method="post" enctype="multipart/form-data">
                            <input type="hidden" id="product_id" value="<?php echo $products_a_row['product_id']; ?>"
                                   name="product_id" class="validate">
                            <input type="hidden" id="product_code"
                                   value="<?php echo $products_a_row['product_code']; ?>"
                                   name="product_code" class="validate">
                            <input type="hidden" id="gallery_image_old"
                                   value="<?php echo $products_a_row['gallery_image']; ?>" name="gallery_image_old"
                                   class="validate">
                            <ul>
                                <li>
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="product_name" id="product_name"
                                                       required="required" class="form-control"
                                                       value="<?php echo $products_a_row['product_name']; ?>"
                                                       placeholder="<?php echo $Zitiziti['PRODUCT_NAME_STAR']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->

                                    <?php
                                        include "booking_system_edit.php";
                                    ?>

                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select data-placeholder="<?php echo "Select Your City"; ?>" name="city_slug[]" id="city_slug" required="required" class="chosen-select form-control">
                                                    <?php
                                                    foreach (getAllCities() as $city) {
                                                        if (strtolower($city['city_name']) == 'www') {
                                                            continue;
                                                        }
                                                    ?>
                                                        <option <?php echo in_array($city['city_slug'], (array)json_decode($products_a_row['city_slug'], true)) ? 'selected' : '' ?>
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
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select onChange="getSubCategory(this.value);" name="category_id"
                                                        id="category_id" class="chosen-select form-control">
                                                    <option value=""><?php echo $Zitiziti['SELECT_CATEGORY']; ?></option>
                                                    <?php
                                                    foreach (getAllCategories() as $categories_row) {
                                                        ?>
                                                        <option <?php if ($products_a_row['category_id'] == $categories_row['category_id']) {
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
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select name="sub_category_id[]" id="sub_category_id" multiple
                                                        class="chosen-select form-control">
                                                    <?php
                                                    foreach (getCategorySubCategories($products_a_row['category_id']) as $sub_categories_row) {
                                                        ?>
                                                        <option <?php $catArray = explode(',', $products_a_row['sub_category_id']);
                                                        foreach ($catArray as $cat_Array) {
                                                            if ($sub_categories_row['sub_category_id'] == $cat_Array) {
                                                                echo "selected";

                                                            }

                                                        } ?>
                                                            value="<?php echo $sub_categories_row['sub_category_id']; ?>"><?php echo $sub_categories_row['sub_category_name']; ?></option>
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
                                                <input type="text" name="product_price" id="product_price"
                                                       onkeypress="return isNumber(event)"
                                                       value="<?php echo $products_a_row['product_price']; ?>"
                                                       required="required" class="form-control"
                                                       placeholder="<?php echo $Zitiziti['PRICE']; ?>*">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="product_price_offer" id="product_price_offer"
                                                       onkeypress="return isNumber(event)"
                                                       value="<?php echo $products_a_row['product_price_offer']; ?>"
                                                       class="form-control"
                                                       placeholder="<?php echo $Zitiziti['PRODUCT_OFFER']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                               <textarea class="form-control"
                                                         name="product_payment_link"
                                                         id="product_payment_link"
                                                         placeholder="<?php echo $Zitiziti['PRODUCT_PAYMENT_LINK']; ?>"><?php echo $products_a_row['product_payment_link']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="form-control" required="required"
                                                          name="product_description" id="product_description"
                                                          placeholder="<?php echo $Zitiziti['PRODUCT_DETAILS']; ?>"><?php echo $products_a_row['product_description']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?php echo $Zitiziti['PRODUCT_IMAGE_LABEL']; ?></label>
                                                <div class="fil-img-uplo">
                                                    <span class="dumfil"><?php echo $Zitiziti['UPLOAD_A_FILE'];  ?></span>
                                                    <input type="file" name="gallery_image[]" accept="image/*,.jpg,.jpeg,.png" class="form-control" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="log">
                                                <div class="login add-prod-high-oth">

                                                    <h4><?php echo $Zitiziti['HIGHLIGHTS']; ?></h4>
                                                    <span class="add-list-add-btn prod-add-high-oad"
                                                          title="add new offer">+</span>
                                                    <span class="add-list-rem-btn prod-add-high-ore"
                                                          title="remove offer">-</span>
                                                    <ul>
                                                        <?php
                                                        $products_a_row_product_highlights = $products_a_row['product_highlights'];

                                                        $products_a_row_product_highlights_Array = explode('|', $products_a_row_product_highlights);

                                                        foreach ($products_a_row_product_highlights_Array as $tuple) {

                                                            ?>

                                                            <li>
                                                                <!--FILED START-->
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <input type="text"
                                                                                   name="product_highlights[]"
                                                                                   value="<?php echo $tuple; ?>"
                                                                                   class="form-control"
                                                                                   placeholder="<?php echo $Zitiziti['HIGHLIGHTS_PLACEHOLDER']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--FILED END-->
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>


                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="log">
                                                <div class="login add-prod-oth">

                                                    <h4><?php echo $Zitiziti['SPECIFICATIONS']; ?></h4>
                                                    <span class="add-list-add-btn prod-add-oad"
                                                          title="add new offer">+</span>
                                                    <span class="add-list-rem-btn prod-add-ore"
                                                          title="remove offer">-</span>
                                                    <ul>
                                                        <?php
                                                        $products_a_row_product_info_question = $products_a_row['product_info_question'];
                                                        $products_a_row_product_info_answer = $products_a_row['product_info_answer'];

                                                        $products_a_row_product_info_question_Array = explode(',', $products_a_row_product_info_question);
                                                        $products_a_row_product_info_answer_Array = explode(',', $products_a_row_product_info_answer);

                                                        $zipped = array_map(null, $products_a_row_product_info_question_Array, $products_a_row_product_info_answer_Array);

                                                        foreach ($zipped as $tuple) {
                                                            $tuple[0]; // Info question
                                                            $tuple[1]; // Info Answer

                                                            ?>
                                                            <li>
                                                                <!--FILED START-->
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control"
                                                                                   name="product_info_question[]"
                                                                                   value="<?php echo $tuple[0]; ?>"
                                                                                   placeholder="<?php echo $Zitiziti['SPECIFICATIONS_QUESTION']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <i class="material-icons">arrow_forward</i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control"
                                                                                   name="product_info_answer[]"
                                                                                   value="<?php echo $tuple[1]; ?>"
                                                                                   placeholder="<?php echo $Zitiziti['SPECIFICATIONS_ANSWER']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--FILED END-->
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                               <textarea class="form-control"
                                                         name="product_tags"
                                                         id="product_tags"
                                                         placeholder="<?php echo $Zitiziti['PRODUCT_TAGS_PLACEHOLDER']; ?>"><?php echo $products_a_row['product_tags']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->
                                </li>
                            </ul>
                            <!--FILED START-->
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" name="product_submit" class="btn btn-primary"><?php echo $Zitiziti['UPDATE_AND_SUBMIT']; ?></button>
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
<script src="js/select-opt.js"></script>
<script type="text/javascript">var webpage_full_link = '<?php echo $webpage_full_link;?>';</script>
<script type="text/javascript">var login_url = '<?php echo $LOGIN_URL;?>';</script>
<script src="js/custom.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/custom_validation.js"></script>
<script src="admin/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('product_description');
</script>
<script>
    function getSubCategory(val) {
        $.ajax({
            type: "POST",
            url: "../sub_category_process.php",
            data: 'category_id=' + val,
            success: function(data) {
                $("#sub_category_id").html(data);
                $('#sub_category_id').trigger("chosen:updated");
            }
        });
    }
</script>

<?php
include "script.php";
?>

</body>

</html>