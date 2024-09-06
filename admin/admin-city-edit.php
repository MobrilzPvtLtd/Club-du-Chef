<?php
include "header.php";
?>
<?php if ($footer_row['admin_listing_show'] != 1 || $admin_row['admin_city_options'] != 1) {
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
                            <span class="udb-inst">Edit City</span>
                            <div class="log log-1">
                                <div class="login">
                                    <h4>Edit this City</h4>
                                    <?php include "../page_level_message.php"; ?>
                                    <?php
                                    $city_id = $_GET['row'];
                                    $row = getCity($city_id);

                                    ?>
                                    <form name="city_form" id="city_form" method="post" action="update_city.php"
                                        enctype="multipart/form-data" class="cre-dup-form cre-dup-form-show">
                                        <input type="hidden" class="validate" id="city_id" name="city_id"
                                            value="<?php echo $row['city_id']; ?>" required="required">

                                        <ul>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>City Name</label>
                                                            <input type="text" name="city_name"
                                                                value="<?php echo $row['city_name']; ?>"
                                                                class="form-control" placeholder="city name *" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label>City Logo 1</label>
                                                            <input type="file" name="city_logo_1[]" class="form-control" placeholder="Logo 1">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img src="<?php echo $slash; ?>images/cityimage/<?php if ($row['city_logo_1'] != NULL || !empty($row['city_logo_1'])) {
                                                            echo $row['city_logo_1'];
                                                        } else {
                                                            echo "ads1.jpg";
                                                        } ?>" alt="" width="100px" style="margin-top: 40px;">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label>City Logo 2</label>
                                                            <input type="file" name="city_logo_2[]" class="form-control" placeholder="Logo 2">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img src="<?php echo $slash; ?>images/cityimage/<?php if ($row['city_logo_2'] != NULL || !empty($row['city_logo_2'])) {
                                                            echo $row['city_logo_2'];
                                                        } else {
                                                            echo "ads1.jpg";
                                                        } ?>" alt="" width="100px" style="margin-top: 40px;">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label>Ad Image 1</label>
                                                            <input type="file" name="ad_image_1[]" class="form-control" placeholder="Ad 1">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img src="<?php echo $slash; ?>images/cityimage/<?php if ($row['ad_image_1'] != NULL || !empty($row['ad_image_1'])) {
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
                                                        <img src="<?php echo $slash; ?>images/cityimage/<?php if ($row['ad_image_2'] != NULL || !empty($row['ad_image_2'])) {
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
                                                        <img src="<?php echo $slash; ?>images/cityimage/<?php if ($row['ad_image_3'] != NULL || !empty($row['ad_image_3'])) {
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
                                                        <img src="<?php echo $slash; ?>images/cityimage/<?php if ($row['ad_image_4'] != NULL || !empty($row['ad_image_4'])) {
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
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label>Ad Image 5</label>
                                                            <input type="file" name="ad_image_5[]" class="form-control"
                                                                placeholder="Ad 5">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img src="<?php echo $slash; ?>images/cityimage/<?php if ($row['ad_image_5'] != NULL || !empty($row['ad_image_5'])) {
                                                            echo $row['ad_image_5'];
                                                        } else {
                                                            echo "ads1.jpg";
                                                        } ?>" alt="" width="100px" style="margin-top: 40px;">
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <div class="form-group">
                                                            <input type="text" name="image_5_link" class="form-control" value="<?php echo $row['image_5_link']; ?>" placeholder="Ad Image 5 Link...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label>Ad Image 6</label>
                                                            <input type="file" name="ad_image_6[]" class="form-control"
                                                                placeholder="Ad 6">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img src="<?php echo $slash; ?>images/cityimage/<?php if ($row['ad_image_6'] != NULL || !empty($row['ad_image_6'])) {
                                                            echo $row['ad_image_6'];
                                                        } else {
                                                            echo "ads1.jpg";
                                                        } ?>" alt="" width="100px" style="margin-top: 40px;">
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <div class="form-group">
                                                            <input type="text" name="image_6_link" class="form-control" value="<?php echo $row['image_6_link']; ?>" placeholder="Ad Image 6 Link...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label>Ad Image 7</label>
                                                            <input type="file" name="ad_image_7[]" class="form-control"
                                                                placeholder="Ad 7">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img src="<?php echo $slash; ?>images/cityimage/<?php if ($row['ad_image_7'] != NULL || !empty($row['ad_image_7'])) {
                                                            echo $row['ad_image_7'];
                                                        } else {
                                                            echo "ads1.jpg";
                                                        } ?>" alt="" width="100px" style="margin-top: 40px;">
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <div class="form-group">
                                                            <input type="text" name="image_7_link" class="form-control" value="<?php echo $row['image_7_link']; ?>" placeholder="Ad Image 7 Link...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label>Ad Image 8</label>
                                                            <input type="file" name="ad_image_8[]" class="form-control"
                                                                placeholder="Ad 8">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img src="<?php echo $slash; ?>images/cityimage/<?php if ($row['ad_image_8'] != NULL || !empty($row['ad_image_8'])) {
                                                            echo $row['ad_image_8'];
                                                        } else {
                                                            echo "ads1.jpg";
                                                        } ?>" alt="" width="100px" style="margin-top: 40px;">
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <div class="form-group">
                                                            <input type="text" name="image_8_link" class="form-control" value="<?php echo $row['image_8_link']; ?>" placeholder="Ad Image 8 Link...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <button type="submit" name="city_submit" class="btn btn-primary">Update</button>
                                    </form>
                                    <div class="col-md-12">
                                        <a href="admin-all-city.php" class="skip">Go to All City >></a>
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
<script src="js/admin-custom.js"></script>
<script src="../js/select-opt.js"></script>
</body>

</html>