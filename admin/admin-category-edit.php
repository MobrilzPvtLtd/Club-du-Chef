<?php
include "header.php";
?>

<?php if($footer_row['admin_listing_show'] != 1 || $admin_row['admin_category_options'] != 1){
    header("Location: profile.php");
}
?>
    
    <!-- START -->
    <section>
        <div class="ad-com">
            <div class="ad-dash leftpadd">
                 <section class="login-reg">
		<div class="container">
			<div class="row">
                <div class="login-main add-list add-ncate">
                     <div class="log-bor">&nbsp;</div>
                    <span class="udb-inst">Edit Listing Category</span>
                    <div class="log log-1">
                        <div class="login">
                            <h4>Edit this Listing Category</h4>
                            <?php include "../page_level_message.php"; ?>
                            <?php
                            $category_id=$_GET['row'];
                            $row= getCategory($category_id);
                            ?>
                             <form name="category_form" id="category_form" method="post" action="update_category.php" enctype="multipart/form-data" class="cre-dup-form cre-dup-form-show">
                                 <input type="hidden" class="validate" id="category_id" name="category_id" value="<?php echo $row['category_id']; ?>" required="required">
                                 	<input type="hidden" class="validate" id="category_image_old" name="category_image_old" value="<?php echo $row['category_image']; ?>" required="required">

                                 <ul>
                                     <li>
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="city">City</label>
                                                    <select data-placeholder="<?php echo "Select Your City"; ?>" name="city_slug[]" id="city_slug" required="required" class="chosen-select form-control">
                                                        <?php
                                                        foreach (getAllCities() as $city) {
                                                            if (strtolower($city['city_name']) == 'www') {
                                                                continue;
                                                            }
                                                            ?>
                                                            <option <?php echo in_array($city['city_slug'], (array)json_decode($row['city_slug'], true)) ? 'selected' : '' ?>
                                                                value="<?php echo $city['city_slug']; ?>">
                                                                <?php echo $city['city_name']; ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="type">Type</label>
                                                    <select name="type" id="type" required="required" class="chosen-select form-control">
                                                        <option value="">Select Category</option>
                                                        <option value="listing" <?php echo $row['type'] == 'listing' ? 'selected' : '' ?>>Listing</option>
                                                        <option value="expert" <?php echo $row['type'] == 'expert' ? 'selected' : '' ?>>Expert</option>
                                                        <option value="job" <?php echo $row['type'] == 'job' ? 'selected' : '' ?>>Job</option>
                                                        <option value="product" <?php echo $row['type'] == 'product' ? 'selected' : '' ?>>Product</option>
                                                        <option value="event" <?php echo $row['type'] == 'event' ? 'selected' : '' ?>>Event</option>
                                                        <option value="blog" <?php echo $row['type'] == 'blog' ? 'selected' : '' ?>>Blog</option>
                                                        <option value="place" <?php echo $row['type'] == 'place' ? 'selected' : '' ?>>Place</option>
                                                        <option value="news" <?php echo $row['type'] == 'news' ? 'selected' : '' ?>>News</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                  <input type="text" class="form-control"  id="category_name" name="category_name" value="<?php echo $row['category_name']; ?>"  placeholder="Category name *" required>
                                                </div>
                                            </div>
                                        </div>
                                          <!--FILED START-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Choose category image</label>
                                                  <input type="file" class="form-control" name="category_image" id="category_image">
                                                </div>
                                            </div>
                                        </div>
                                        <!--FILED END-->
                                     </li>
                                 </ul>
                                <button type="submit" name="category_submit" class="btn btn-primary">Update</button>
                            </form>
                            <div class="col-md-12">
                                    <a href="admin-all-category.php" class="skip">Go to All Listing Category >></a>
                                </div>
                            <div class="ud-notes">
                                <p><b>Notes:</b> Hi, Category image size like 640x480 PX. You better to upload compressed images because it's affected page loading time. <br>Image compressing tool: <a href="https://tinypng.com" target="_blank">tinypng.com</a></p>
                    </div>

                        </div>
                    </div>
                </div>
			</div>
		</div>
	</section>

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
    <script src="js/admin-custom.js"></script> <script src="../js/select-opt.js"></script>
</body>

</html>