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
                    <form action="insert_product.php" class="product_form" id="product_form" name="product_form"
                          method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="login-main add-list posr">
                                <div class="log-bor">&nbsp;</div>
                                <span class="udb-inst">Add Product</span>
                                <div class="log log-1">
                                    <div class="login">
                                        <ul>
                                            <li>
                                                <!--FILED START-->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <select name="user_code" id="user_code" class="chosen-select form-control"
                                                                    required="required">
                                                                <option value="" disabled selected>User Name</option>
                                                                <?php
                                                                foreach (getAllUser() as $ad_users_row) {
                                                                    ?>
                                                                    <option
                                                                        value="<?php echo $ad_users_row['user_code']; ?>"><?php echo $ad_users_row['first_name']; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FILED END-->
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
                                                                    <option value="<?php echo $city['city_slug']; ?>">
                                                                        <?php echo $city['city_name']; ?>
                                                                    </option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- BOOKING SYSTEM START -->
                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <div class="chbox">
                                                            <input type="checkbox" name="booking" id="booking">
                                                            <label for="booking">Booking System</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" id="booking-details" style="display:none;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="1" name="is_booking" id="is_booking">
                                                        <label class="form-check-label" for="is_booking">Use inbuilt booking system</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="0" name="is_booking" id="is_booking_url">
                                                        <label class="form-check-label" for="is_booking_url">Use your own booking system</label>
                                                    </div>

                                                    <div class="form-group mt-2" id="booking_url_group" style="display:none;">
                                                        <input type="text" name="booking_url" id="booking_url" class="form-control" value="" placeholder="Enter your booking system url...">
                                                    </div>
                                                </div>
                                                <!-- BOOKING SYSTEM END -->
                                                    
                                                <!--FILED START-->
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="text" name="product_name" id="product_name"
                                                                   required="required" class="form-control"
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
                                                <!--FILED START-->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <select data-placeholder="Select Sub Category"
                                                                    name="sub_category_id[]"
                                                                    id="sub_category_id" multiple
                                                                    class="chosen-select form-control">
                                                                <option value="">Select Sub Category</option>
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
                                                                   required="required" class="form-control" onkeypress="return isNumber(event)"
                                                                   placeholder="Price *">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="product_price_offer" onkeypress="return isNumber(event)"
                                                                   id="product_price_offer"
                                                                   class="form-control" placeholder="Offer (i.e) 50">
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
                                                         placeholder="Product Payment External Link"></textarea>
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
                                                          placeholder="Product details"></textarea>
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
                                                                   required="required"
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
                                                                    <li>
                                                                        <!--FILED START-->
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <input type="text"
                                                                                           name="product_highlights[]"
                                                                                           class="form-control"
                                                                                           placeholder="(i.e) 1 Year Onsite Warranty">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!--FILED END-->
                                                                    </li>

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
                                                                    <li>
                                                                        <!--FILED START-->
                                                                        <div class="row">
                                                                            <div class="col-md-5">
                                                                                <div class="form-group">
                                                                                    <input type="text"
                                                                                           name="product_info_question[]"
                                                                                           class="form-control"
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
                                                                                           name="product_info_answer[]"
                                                                                           class="form-control"
                                                                                           placeholder="(i.e) qwerty3421">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!--FILED END-->
                                                                    </li>

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
                                                         placeholder="Product Tags (i.e) electronics,laptop,hp,canon"></textarea>
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
                                                    Submit
                                                </button>
                                            </div>
                                            <div class="col-md-12">
                                                <a href="dashboard" class="skip">Go to User Dashboard >></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--FILED END-->
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
<script src="ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('product_description');
</script>
<script>
    function getCities(val) {
        $.ajax({
            type: "POST",
            url: "../city_process.php",
            data: 'country_id=' + val,
            success: function (data) {
                $("#city_id").html(data);
                $('#city_id').trigger("chosen:updated");
            }
        });
    }
</script>
</body>

</html>