<?php
include "header.php";
?>

<?php if($footer_row['admin_product_show'] != 1 || $admin_row['admin_product_options'] != 1){
    header("Location: profile.php");
}
?>
<!-- START -->
<section>
    <div class="ad-com">
        <div class="ad-dash leftpadd">
            <div class="login-reg">
                <div class="container">
                    <?php
                    $product_codea = $_GET['code'];
                    $products_a_row = getProduct($product_codea);

                    ?>
                    <form action="update_product.php" class="product_form" id="product_form" name="product_form"
                          method="post" enctype="multipart/form-data">
                        <input type="hidden" id="product_id" value="<?php echo $products_a_row['product_id']; ?>"
                               name="product_id" class="validate">
                        <input type="hidden" id="product_code" value="<?php echo $products_a_row['product_code']; ?>"
                               name="product_code" class="validate">
                        <input type="hidden" id="gallery_image_old"
                               value="<?php echo $products_a_row['gallery_image']; ?>" name="gallery_image_old"
                               class="validate">
                        <div class="row">
                            <div class="login-main add-list posr">
                                <div class="log-bor">&nbsp;</div>
                                <span class="udb-inst">Edit Product Details</span>
                                <div class="log log-1">
                                    <div class="login">
                                        <h4>Edit Product Details</h4>
                                        <?php include "../page_level_message.php"; ?>
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
                                                            <select name="user_code" id="user_code" class="form-control"
                                                                    required="required">
                                                                <option value="" disabled>User Name</option>
                                                                <?php
                                                                foreach (getAllUser() as $ad_users_row) {
                                                                    ?>
                                                                    <option <?php if ($products_a_row['user_id'] == $ad_users_row['user_id']) {
                                                                        echo "selected";
                                                                    } ?>
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
                                                            <input type="checkbox" name="booking" id="booking" <?php echo ($products_a_row['is_booking'] == 1 || $products_a_row['booking_url'] != '') ? 'checked' : ''; ?>>
                                                            <label for="booking">Booking System</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" id="booking-details" style="display: <?php echo ($products_a_row['is_booking'] == 1 || $products_a_row['booking_url'] != '') ? 'block' : 'none'; ?>;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="1" name="is_booking" id="is_booking" <?php echo $products_a_row['is_booking'] == 1 ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="is_booking">Use inbuilt booking system</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="0" name="is_booking" id="is_booking_url" <?php echo $products_a_row['is_booking'] == 0 ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="is_booking_url">Use your own booking system</label>
                                                    </div>

                                                    <div class="form-group mt-2" id="booking_url_group" style="display:none;">
                                                        <input type="text" name="booking_url" id="booking_url" class="form-control" value="<?php echo $products_a_row['booking_url']; ?>" placeholder="Enter your booking system url...">
                                                    </div>
                                                </div>
                                                <!-- BOOKING SYSTEM END -->

                                                <!--FILED START-->
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="text" name="product_name" id="product_name"
                                                                   required="required" class="form-control"
                                                                   value="<?php echo $products_a_row['product_name']; ?>"
                                                                   placeholder="Product name *">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->
                                                <!--FILED START-->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <select onChange="getProductSubCategory(this.value);"
                                                                    name="category_id"
                                                                    id="category_id" class="chosen-select form-control">
                                                                <option value="">Select Category</option>
                                                                <?php
                                                                foreach (getAllProductCategories() as $categories_row) {
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
                                                            <select name="sub_category_id[]" id="sub_category_id"
                                                                    multiple
                                                                    class="chosen-select form-control">
                                                                <?php
                                                                foreach (getCategoryProductSubCategories($products_a_row['category_id']) as $sub_categories_row) {
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
                                                            <input type="text" name="product_price" id="product_price" onkeypress="return isNumber(event)"
                                                                   value="<?php echo $products_a_row['product_price']; ?>"
                                                                   required="required" class="form-control"
                                                                   placeholder="Price *">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="product_price_offer" onkeypress="return isNumber(event)"
                                                                   id="product_price_offer"
                                                                   value="<?php echo $products_a_row['product_price_offer']; ?>"
                                                                   class="form-control" placeholder="Offer (i.e)50%">
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
                                                         placeholder="Product Payment External Link"><?php echo $products_a_row['product_payment_link']; ?></textarea>
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
                                                          placeholder="Product details"><?php echo $products_a_row['product_description']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->
                                                <!--FILED START-->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Product images(max 5 images)</label>
                                                            <input type="file" name="gallery_image[]"
                                                                   class="form-control" accept="image/png, image/jpeg"
                                                                   multiple>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->
                                                
                                                <!--FILED START-->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="log">
                                                            <div class="login add-prod-high-oth">

                                                                <h4>Highlights</h4>
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
                                                                                               placeholder="(i.e) 1 Year Onsite Warranty">
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

                                                                <h4>Specifications</h4>
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
                                                                                        <input type="text"
                                                                                               class="form-control"
                                                                                               name="product_info_question[]"
                                                                                               value="<?php echo $tuple[0]; ?>"
                                                                                               placeholder="(i.e) Serial Number">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <div class="form-group">
                                                                                        <i class="material-icons">arrow_forward</i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-5">
                                                                                    <div class="form-group">
                                                                                        <input type="text"
                                                                                               class="form-control"
                                                                                               name="product_info_answer[]"
                                                                                               value="<?php echo $tuple[1]; ?>"
                                                                                               placeholder="(i.e) qwerty3421">
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
                                                         placeholder="Product Tags (i.e) electronics,laptop,hp,canon"><?php echo $products_a_row['product_tags']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->
                                            </li>
                                        </ul>
                                        <!--FILED START-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" name="product_submit" class="btn btn-primary">
                                                    Update Product
                                                </button>
                                            </div>
                                            <div class="col-md-12">
                                                <a href="profile.php" class="skip">Go to Dashboard >></a>
                                            </div>
                                        </div>
                                        <!--FILED END-->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
    CKEDITOR.replace('product_description');
</script>
<script>
    $(document).ready(function() {
        // Show or hide the booking details when the checkbox is toggled
        $("#booking").change(function() {
            if ($(this).is(':checked')) {
                $("#booking-details").show();
            } else {
                $("#booking-details").hide();
                // Ensure the booking URL input is hidden and cleared when the checkbox is unchecked
                $("#booking_url_group").hide();
                $("#booking_url").val('');
            }
        });

        // Clear the booking URL when the inbuilt booking system is selected
        $("#is_booking").change(function() {
            if ($(this).is(':checked')) {
                $("#booking_url").val('');
                $("#booking_url_group").hide();
            }
        });

        if ($("#is_booking_url").is(':checked')) {
            $("#booking_url_group").show();
            $("#booking_url").val();
        } else {
            $("#booking_url_group").hide();
        }

        // Show/hide the booking URL input based on the radio button selection
        $("#is_booking_url").change(function() {
            if ($(this).is(':checked')) {
                $("#booking_url_group").show();
            } else {
                $("#booking_url_group").hide();
                $("#booking_url").val('');
            }
        });
    });

    function getProductSubCategory(val) {
        $.ajax({
            type: "POST",
            url: "../product_sub_category_process.php",
            data: 'category_id=' + val,
            success: function (data) {
                $("#sub_category_id").html(data);
                $('#sub_category_id').trigger("chosen:updated");
            }
        });
    }
</script>
</body>

</html>