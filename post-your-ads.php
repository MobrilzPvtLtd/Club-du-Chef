<?php
include "header.php";
?>
<!-- START -->
<!--PRICING DETAILS-->
<section class="<?php if ($footer_row['admin_language'] == 2) {
    echo "lg-arb";
} ?> login-reg">
    <div class="container">
        <div class="row">
                <div class="login-main add-list">
                    <?php
                    if(!isset($_SESSION['user_code']) && empty($_SESSION['user_code'])) {
                        ?>
                        <div class="coup-sec-log">
                            <h4><?php echo $Zitiziti['AD-DETAILS-SIGN-IN-POST-YOUR-ADS']; ?></h4>
                            <p><?php echo $Zitiziti['AD-DETAILS-SIGN-IN-POST-YOUR-ADS-P-TAG']; ?></p>
                            <a href="<?php echo $LOGIN_URL; ?>"><?php echo $Zitiziti['COUPON-NO-LOGIN-SIGN-IN-NOW']; ?></a>
                        </div>
                        <?php
                    }else {
                    ?>
                    <div class="log-bor">&nbsp;</div>
                    <span class="steps"><?php echo $Zitiziti['AD-DETAILS-CREATE-NEW-ADS']; ?></span>
                    <div class="log">
                        <div class="login">

                            <h4><?php echo $Zitiziti['AD-DETAILS-SUBMIT-YOUR-ADS']; ?></h4>
                            <form name="create_ads_form" id="create_ads_form" method="post" action="new_ads_insert.php"
                                  enctype="multipart/form-data">
                                <input type="hidden" value="" name="ad_total_days" id="ad_total_days" class="validate">
                                <input type="hidden" value="" name="ad_cost_per_day" id="ad_cost_per_day"
                                       class="validate">
                                <input type="hidden" value="" name="ad_total_cost" id="ad_total_cost" class="validate">
                                <ul>
                                    <li>
                                        <!--FILED START-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group ca-sh-user">
                                                    <select name="all_ads_price_id" required="required"
                                                            class="form-control"
                                                            id="adposi">
                                                        <option value=""><?php echo $Zitiziti['AD-DETAILS-CHOOSE-ADS-POSITION']; ?></option>
                                                        <?php
                                                        foreach (getAllActiveAdsPrice() as $row) {
                                                            ?>
                                                            <option myTag="<?php echo $row['ad_price_cost']; ?>"
                                                                    value="<?php echo $row['all_ads_price_id']; ?>"><?php echo $row['ad_price_name']; ?>
                                                                (<?php echo $row['ad_price_cost']; ?><?php echo $footer_row['currency_symbol']; ?>
                                                                /per day)
                                                            </option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <a href="ad-details" class="frmtip" target="_blank"><?php echo $Zitiziti['AD-DETAILS-PRICING-DETAILS']; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--FILED END-->
                                        <!--FILED START-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                <input type="text" id="stdate" autocomplete="off" name="ad_start_date" class="form-control" placeholder="Ad start date (MM/DD/YYYY)" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!--FILED END-->
                                        <!--FILED START-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                <input type="text" id="endate" autocomplete="off" name="ad_end_date" class="form-control" placeholder="Ad end date (MM/DD/YYYY)" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!--FILED END-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group ca-sh-user">
                                                <select name="listing_id" required class="form-control" id="listing_id">
                                                    <option value="">Choose Ads List</option>
                                                    <?php
                                                    foreach (getAllListingUser($_SESSION['user_id']) as $row) {
                                                        $enquiry = getAdsListingIdEnquiry($row['listing_id']);
                                                        if ($row['listing_id'] != $enquiry['listing_id']) {
                                                    ?>
                                                        <option value="<?php echo $row['listing_id']; ?>"><?php echo $row['listing_name']; ?>
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
                                        <!--FILED START-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Ad Image 1</label>
                                                    <input type="file" name="ad_image_1[]" class="form-control"
                                                        placeholder="Ad 1">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="form-group">
                                                    <input type="text" name="image_1_link" class="form-control"
                                                        placeholder="Ad Image 1 Link...">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Ad Image 2</label>
                                                    <input type="file" name="ad_image_2[]" class="form-control"
                                                        placeholder="Ad 2">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="form-group">
                                                    <input type="text" name="image_2_link" class="form-control"
                                                        placeholder="Ad Image 2 Link...">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Ad Image 3</label>
                                                    <input type="file" name="ad_image_3[]" class="form-control"
                                                        placeholder="Ad 3">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="form-group">
                                                    <input type="text" name="image_3_link" class="form-control"
                                                        placeholder="Ad Image 3 Link...">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Ad Image 4</label>
                                                    <input type="file" name="ad_image_4[]" class="form-control"
                                                        placeholder="Ad 4">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="form-group">
                                                    <input type="text" name="image_4_link" class="form-control"
                                                        placeholder="Ad Image 4 Link...">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="ad-pri-cal">
                                                    <ul>
                                                        <li>
                                                            <div>
                                                                <span><?php echo $Zitiziti['PROMOTE-BUSINESS-TOTAL-DAYS']; ?></span>
                                                                <h5 class="ad-tdays">0</h5>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <span><?php echo $Zitiziti['PROMOTE-BUSINESS-COST-PER-DAY']; ?></span>
                                                                <h5><?php if($footer_row['currency_symbol_pos']== 1){ echo $footer_row['currency_symbol']; } ?><b
                                                                        class="ad-pocost">0</b><?php if($footer_row['currency_symbol_pos']== 2){ echo $footer_row['currency_symbol']; } ?></h5>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <span><?php echo $Zitiziti['TAX']; ?></span>
                                                                <h5><?php if($footer_row['currency_symbol_pos']== 1){ echo $footer_row['currency_symbol']; } ?>4<?php if($footer_row['currency_symbol_pos']== 2){ echo $footer_row['currency_symbol']; } ?></h5>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <span><?php echo $Zitiziti['PROMOTE-BUSINESS-TOTAL-COST']; ?></span>
                                                                <h5><?php if($footer_row['currency_symbol_pos']== 1){ echo $footer_row['currency_symbol']; } ?><b
                                                                        class="ad-tcost">0</b><?php if($footer_row['currency_symbol_pos']== 2){ echo $footer_row['currency_symbol']; } ?></h5>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!--FILED END-->
                                    </li>
                                </ul>
                                <!--FILED START-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" name="create_ad_submit" class="btn btn-primary"><?php echo $Zitiziti['AD-DETAILS-PUBLISH-THIS-AD'];?></button>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="dashboard" class="skip"><?php echo $Zitiziti['GO_TO_USER_DASHBOARD']; ?> >></a>
                                    </div>
                                </div>
                                <!--FILED END-->
                            </form>
                            <div class="ud-notes">
                                <p><b><?php echo $Zitiziti['DB-PAYMENTS-FOOTER-NOTES']; ?>:</b> <?php echo $Zitiziti['AD-DETAILS-NOTES-MESSAGE']; ?></p>
                            </div>
                        </div>
                    </div>
                        <?php
                    }
                    ?>
                </div>
        </div>
    </div>
</section>

<!--END PRICING DETAILS-->
<?php
include "footer.php";
?>

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
</body>

</html>