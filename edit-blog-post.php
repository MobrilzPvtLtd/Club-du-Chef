<?php
include "header.php";

if (file_exists('config/user_authentication.php')) {
    include('config/user_authentication.php');
}

if (file_exists('config/general_user_authentication.php')) {
    include('config/general_user_authentication.php');
}

if (file_exists('config/blog_page_authentication.php')) {
    include('config/blog_page_authentication.php');
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
                <span class="steps"><?php echo $Zitiziti['EDIT_BLOG_POST']; ?></span>
                <div class="log">
                    <div class="login add-list-off">
                        <?php
                        $blog_codea = $_GET['code'];
                        $blogs_a_row = getBlog($blog_codea);

                        ?>
                        <h4><?php echo $Zitiziti['EDIT_THIS_BLOG_POST']; ?></h4>
                        <form action="blog_update.php" class="blog_edit_form" id="blog_edit_form" name="blog_edit_form"
                              method="post" enctype="multipart/form-data">

                            <input type="hidden" id="blog_id" value="<?php echo $blogs_a_row['blog_id']; ?>"
                                   name="blog_id" class="validate">
                            <input type="hidden" id="blog_image_old"
                                   value="<?php echo $blogs_a_row['blog_image']; ?>" name="blog_image_old"
                                   class="validate">

                            <ul>
                                <li>
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="blog_name"
                                                       value="<?php echo $blogs_a_row['blog_name']; ?>"
                                                       required="required" class="form-control"
                                                       placeholder="<?php echo $Zitiziti['POST_NAME']; ?>*">
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
                                                        <option <?php echo in_array($city['city_slug'], (array)json_decode($blogs_a_row['city_slug'], true)) ? 'selected' : '' ?>
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
                                                <select name="category_id"
                                                        id="category_id" class="chosen-select form-control">
                                                    <option value=""><?php echo $Zitiziti['SELECT_CATEGORY']; ?></option>
                                                    <?php
                                                    foreach (getAllBlogCategories() as $categories_row) {
                                                        ?>
                                                        <option <?php if ($blogs_a_row['category_id'] == $categories_row['category_id']) {
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
                                                <textarea name="blog_description" id="blog_description"
                                                          required="required" class="form-control"
                                                          placeholder="<?php echo $Zitiziti['POST_DETAILS']; ?>"><?php echo $blogs_a_row['blog_description'] ?></textarea>
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
                                                    <span class="dumfil"><?php echo $Zitiziti['UPLOAD_A_FILE'];  ?></span>
                                                    <input type="file" name="blog_image" accept="image/*,.jpg,.jpeg,.png" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--FILED END-->
                                    <!--FILED START-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div>
                                                <div class="chbox">
                                                    <input type="checkbox" name="isenquiry" id="evefmenab"
                                                           <?php if ($blogs_a_row['isenquiry'] == 1){ ?>checked="" <?php } ?>>
                                                    <label
                                                        for="evefmenab"><?php echo $Zitiziti['ENQUIRY_BOX_ENABLE']; ?></label>
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
                                    <button type="submit" name="blog_submit"
                                            class="btn btn-primary"><?php echo $Zitiziti['SAVE_CHANGES']; ?></button>
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
<script src="<?php echo $slash; ?>js/select-opt.js"></script>
<script type="text/javascript">var webpage_full_link = '<?php echo $webpage_full_link;?>';</script>
<script type="text/javascript">var login_url = '<?php echo $LOGIN_URL;?>';</script>
<script src="js/custom.js"></script>
<script src="admin/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('blog_description');
</script>
</body>

</html>