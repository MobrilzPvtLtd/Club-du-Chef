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
                    <span class="udb-inst">Edit Listing Sub Category</span>
                    <div class="log log-1">
                        <div class="login">
                            <h4>Edit Listing Sub Category</h4>
                            <?php include "../page_level_message.php"; ?>
                            <?php
                            $sub_category_id=$_GET['row'];
                            $row= getSubCategory($sub_category_id);

                            ?>
                            <form name="sub_category_form" id="sub_category_form" method="post" action="update_sub_category.php" enctype="multipart/form-data" class="cre-dup-form cre-dup-form-show">
                                <input type="hidden" class="validate" id="sub_category_id" name="sub_category_id" value="<?php echo $row['sub_category_id']; ?>" required="required">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <select name="type" onChange="getCategory(this.value);" required="required" class="chosen-select form-control">
                                                <option value="">Select Type</option>
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
                                            <label for="type">Category</label>
                                            <select name="category_id" class="form-control" id="category_name">
                                                <?php
                                                // foreach (getAllCategories() as $row_1) {

                                                    ?>
                                                    <!-- <option <?php if($row_1['category_id']== $row['category_id']){ echo "selected"; } ?> -->
                                                        <!-- value="<?php echo $row_1['category_id']; ?>"><?php echo $row_1['category_name']; ?></option> -->
                                                    <?php
                                                // }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <br>
                                <ul>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="text" value="<?php echo $row['sub_category_name']; ?>" name="sub_category_name" class="form-control" placeholder="Sub category name *" required>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <button type="submit" name="sub_category_submit" class="btn btn-primary">Update</button>
                            </form>
                            <div class="col-md-12">
                                    <a href="admin-all-sub-category.php" class="skip">Go to All Listing Sub Category >></a>
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
    <script>
        function getCategory(val) {
            $.ajax({
                type: "POST",
                url: "../sub_category_process.php",
                data: 'type=' + val,
                success: function(data) {
                    $("#category_name").html(data);
                }
            });
        }
        $(document).ready(function() {
            var selectedType = $("select[name='type']").val();
            if (selectedType) {
                getCategory(selectedType);
            }
        });
    </script>
</body>

</html>