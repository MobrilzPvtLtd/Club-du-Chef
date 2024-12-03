<?php
include "header.php";
?>
<?php if($admin_row['admin_ads_options'] != 1){
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
                <div class="login-main add-list posr">
                     <div class="log-bor">&nbsp;</div>
                    <span class="udb-inst">Edit ads</span>
                    <div class="log log-1">
                        <div class="login">
                            <h4>Edit this Ad</h4>
                            <?php include "../page_level_message.php"; ?>
                            <?php
                            $path = $_GET['path'];
                            $all_ads_enquiry_id = $_GET['row'];
                            $row = getAdsEnquiry($all_ads_enquiry_id);
                            ?>
                            <form name="edit_ads_form" id="edit_ads_form" method="post" action="update_ads.php" enctype="multipart/form-data">
                                <input type="hidden" class="validate" id="all_ads_enquiry_id" name="all_ads_enquiry_id" value="<?php echo $row['all_ads_enquiry_id']; ?>" required="required">
                                <input type="hidden" class="validate" id="ad_enquiry_photo_old" name="ad_enquiry_photo_old" value="<?php echo $row['ad_enquiry_photo']; ?>" required="required">
                                <input type="hidden" value="<?php echo $row['ad_total_days']; ?>" name="ad_total_days" id="ad_total_days" class="validate">
                                <input type="hidden" value="<?php echo $row['ad_cost_per_day']; ?>" name="ad_cost_per_day" id="ad_cost_per_day" class="validate">
                                <input type="hidden" value="<?php echo $row['ad_total_cost']; ?>" name="ad_total_cost" id="ad_total_cost" class="validate">
                                <input type="hidden" value="<?php echo $path; ?>" name="path" id="path" class="validate">
                                <ul>
                                    <li>
                                        <!--FILED START-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <select name="user_id" required="required" class="chosen-select form-control" id="user_id">
                                                        <option value="">Choose a user *</option>
                                                        <?php
                                                        foreach (getAllUser() as $user_row) {

                                                            ?>
                                                            <option <?php if ($user_row['user_id'] == $row['user_id']) {
                                                                echo "selected";
                                                            } ?>
                                                                value="<?php echo $user_row['user_id']; ?>"><?php echo $user_row['first_name']; ?></option>
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
                                                <div class="form-group ca-sh-user">
                                                    <select name="all_ads_price_id" required="required" class="form-control chosen-select" id="adposi">
                                                        <option value="">Choose Ads Position *</option>
                                                        <?php
                                                        foreach (getAllActiveAdsPrice() as $ad_row) {
                                                            ?>
                                                            <option <?php if ($ad_row['all_ads_price_id'] == $row['all_ads_price_id']) {
                                                                echo "selected";
                                                            } ?> myTag = "<?php echo $ad_row['ad_price_cost']; ?>"
                                                                value="<?php echo $ad_row['all_ads_price_id']; ?>"><?php echo $ad_row['ad_price_name']; ?> (<?php echo $ad_row['ad_price_cost']; ?><?php echo $footer_row['currency_symbol']; ?>/per day)</option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <a href="../ad-details.php" class="frmtip" target="_blank">Pricing details</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--FILED END-->
                                        <!--FILED START-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="text" id="stdate" name="ad_start_date" value="<?php echo $row['ad_start_date']; ?>" class="form-control" placeholder="Ad start date (MM/DD/YYYY)" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!--FILED END-->
                                        <!--FILED START-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="text" id="endate" name="ad_end_date" value="<?php echo $row['ad_end_date']; ?>" class="form-control" placeholder="Ad end date (MM/DD/YYYY)" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group ca-sh-user">
                                                <select name="listing_id" required class="form-control" id="listing_id">
                                                    <option value="">Choose Ads List</option>
                                                    <?php
                                                    foreach (getAllListingUser($_SESSION['user_id']) as $ad_row) {
                                                        $enquiry = getAdsListingIdEnquiry($ad_row['listing_id']);
                                                        if ($ad_row['listing_id'] != $enquiry['listing_id'] || $ad_row['listing_id'] == $row['listing_id']) {
                                                    ?>
                                                        <option value="<?php echo $ad_row['listing_id']; ?>" <?php echo $ad_row['listing_id'] == $row['listing_id'] ? 'selected' : '' ?>><?php echo $ad_row['listing_name']; ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    }
                                                    ?>
                                                </select>
                                                    <a href="db-all-listing" class="frmtip" target="_blank">All Ads List</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--FILED END-->
                                        <!--FILED START-->
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Choose Ad image</label>
                                                    <input type="file" name="ad_enquiry_photo" class="form-control" >
                                                </div>
                                            </div>
                                        </div> -->
                                        <!--FILED END-->
                                        <!--FILED START-->
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea  id="ad_link"  name="ad_link" class="form-control" placeholder="Advertisement External link" required><?php echo $row['ad_link']; ?></textarea>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!--FILED END-->
                                        <!--FILED START-->
                                        <li>
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label>Ad Image 1</label>
                                                        <input type="file" name="ad_image_1[]" class="form-control" placeholder="Ad 1">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <img src="<?php echo $slash; ?>images/ads/<?php if ($row['ad_image_1'] != NULL || !empty($row['ad_image_1'])) {
                                                        echo $row['ad_image_1'];
                                                    } else {
                                                        echo "ads1.jpg";
                                                    } ?>" alt="" width="100px" style="margin-top: 40px;">
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <div class="form-group">
                                                        <input type="text" name="image_1_link" class="form-control" value="<?php echo $row['image_1_link']; ?>" placeholder="Ad Image 1 Link...">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label>Ad Image 2</label>
                                                        <input type="file" name="ad_image_2[]" class="form-control" placeholder="Ad 2">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <img src="<?php echo $slash; ?>images/ads/<?php if ($row['ad_image_2'] != NULL || !empty($row['ad_image_2'])) {
                                                        echo $row['ad_image_2'];
                                                    } else {
                                                        echo "ads1.jpg";
                                                    } ?>" alt="" width="100px" style="margin-top: 40px;">
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <div class="form-group">
                                                        <input type="text" name="image_2_link" class="form-control" value="<?php echo $row['image_2_link']; ?>" placeholder="Ad Image 2 Link...">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label>Ad Image 3</label>
                                                        <input type="file" name="ad_image_3[]" class="form-control"
                                                            placeholder="Ad 3">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <img src="<?php echo $slash; ?>images/ads/<?php if ($row['ad_image_3'] != NULL || !empty($row['ad_image_3'])) {
                                                        echo $row['ad_image_3'];
                                                    } else {
                                                        echo "ads1.jpg";
                                                    } ?>" alt="" width="100px" style="margin-top: 40px;">
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <div class="form-group">
                                                        <input type="text" name="image_3_link" class="form-control" value="<?php echo $row['image_3_link']; ?>" placeholder="Ad Image 3 Link...">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label>Ad Image 4</label>
                                                        <input type="file" name="ad_image_4[]" class="form-control"
                                                            placeholder="Ad 4">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <img src="<?php echo $slash; ?>images/ads/<?php if ($row['ad_image_4'] != NULL || !empty($row['ad_image_4'])) {
                                                        echo $row['ad_image_4'];
                                                    } else {
                                                        echo "ads1.jpg";
                                                    } ?>" alt="" width="100px" style="margin-top: 40px;">
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <div class="form-group">
                                                        <input type="text" name="image_4_link" class="form-control" value="<?php echo $row['image_4_link']; ?>" placeholder="Ad Image 4 Link...">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                <div class="ad-pri-cal">
                                                    <ul>
                                                        <li>
                                                            <div>
                                                                <span>Total days</span>
                                                                <h5 class="ad-tdays">0</h5>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <span>Cost Per Day</span>
                                                                <h5><?php if($footer_row['currency_symbol_pos']== 1){ echo $footer_row['currency_symbol']; } ?><b class="ad-pocost"><?php echo $row['ad_total_days']; ?></b><?php if($footer_row['currency_symbol_pos']== 2){ echo $footer_row['currency_symbol']; } ?></h5>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <span>Tax</span>
                                                                <h5><?php if($footer_row['currency_symbol_pos']== 1){ echo $footer_row['currency_symbol']; } ?>4<?php if($footer_row['currency_symbol_pos']== 2){ echo $footer_row['currency_symbol']; } ?></h5>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <span>Total Cost</span>
                                                                <h5><?php if($footer_row['currency_symbol_pos']== 1){ echo $footer_row['currency_symbol']; } ?><b class="ad-tcost"><?php echo $row['ad_total_cost']; ?></b><?php if($footer_row['currency_symbol_pos']== 2){ echo $footer_row['currency_symbol']; } ?></h5>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!--FILED END-->
                                    </li>
                                </ul>
                                <!--FILED START-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" name="edit_ad_submit" class="btn btn-primary">Publish this Ad</button>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="profile.php" class="skip">Go to User Dashboard >></a>
                                    </div>
                                </div>
                                <!--FILED END-->
                            </form>
                            <div class="ud-notes">
                                <p><b>Notes:</b> Hi, Before submit your <b>Ads</b> please check the <b>available date</b> because previous Ads running in same date. Kindly check this manually</p>
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
    <script src="../js/select-opt.js"></script>
    <script src="js/admin-custom.js"></script> 
</body>

</html>