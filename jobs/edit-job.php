<?php
include "job-config-info.php";
include "../header.php";

if (file_exists('../config/user_authentication.php')) {
    include('../config/user_authentication.php');
}

if (file_exists('../config/general_user_authentication.php')) {
    include('../config/general_user_authentication.php');
}

if (file_exists('../config/job_page_authentication.php')) {
    include('../config/job_page_authentication.php');
}

?>

<section class="<?php if ($footer_row['admin_language'] == 2) {
    echo "lg-arb";
} ?> login-reg job-form">
    <div class="container">
        <div class="row">
            <div class="login-main add-list">
                <div class="log-bor">&nbsp;</div>
                <span class="steps"><?php echo $Zitiziti['JOB-EDIT-THIS-JOB']; ?></span>
                <?php include "../page_level_message.php"; ?>
                <div class="log">
                    <?php
                    $job_codea = $_GET['row'];
                    $job_a_row = getJob($job_codea);

                    // Fetch query of booking_availability
                    $check_query = "SELECT * FROM " . TBL . "booking_availability WHERE booking_type_id = '{$job_a_row['job_id']}' AND is_available = 1 AND booking_type = 'job'";
                    $availability_day_result = mysqli_query($conn, $check_query);

                    $availability_days = [];
                    while ($availability = mysqli_fetch_assoc($availability_day_result)) {
                        $availability_days[$availability['day']] = $availability;
                    }
                    global $job_a_row;

                    $edit_a_row = $job_a_row; 

                    ?>
                    <form action="job_update.php" class="job_form" id="job_form" name="job_form"
                          method="post" enctype="multipart/form-data">

                        <input type="hidden" id="job_codea" value="<?php echo $job_codea; ?>"
                               name="job_codea" class="validate">
                        <input type="hidden" id="job_id" value="<?php echo $job_a_row['job_id']; ?>"
                               name="job_id" class="validate">
                        <input type="hidden" id="job_code"
                               value="<?php echo $job_a_row['job_code']; ?>"
                               name="job_code" class="validate">
                        <input type="hidden" id="company_logo_old"
                               value="<?php echo $job_a_row['company_logo']; ?>" name="company_logo_old"
                               class="validate">
                        
                        <div class="inn">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-TITLE-LABEL']; ?>*</label>
                                    <input type="text" value="<?php echo $job_a_row['job_title']; ?>" name="job_title" id="job_title" class="form-control" required>
                                </div>
                                <div class="form-group prfix-inp">
                                    <label class="tit"><?php echo $Zitiziti['JOB-SALARY-LABEL']; ?>*</label>
                                    <i class="prfix"><?php echo $footer_row['currency_symbol']; ?></i>
                                    <input type="text" required="required" onkeypress="return isNumber(event)" class="form-control" id="textInput" name="job_salary" value="<?php echo $job_a_row['job_salary']; ?>" >
                                </div>
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-NO-OF-OPENINGS-LABEL']; ?>*</label>
                                    <input type="text" value="<?php echo $job_a_row['no_of_openings']; ?>" onkeypress="return isNumber(event)" name="no_of_openings" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-INTERVIEW-DATE-LABEL']; ?></label>
                                    <input type="text" value="<?php echo date ('m/d/Y', strtotime($job_a_row['job_interview_date'])); ?>" name="job_interview_date" class="form-control" id="newdate">
                                </div>
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-INTERVIEW-TIME-LABEL']; ?></label>
                                    <input type="time" value="<?php echo $job_a_row['job_interview_time']; ?>" name="job_interview_time" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-INTERVIEW-ROLE-LABEL']; ?></label>
                                    <input type="text" value="<?php echo $job_a_row['job_role']; ?>" name="job_role" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-INTERVIEW-EDUCATIONAL-LABEL']; ?></label>
                                    <input type="text" value="<?php echo $job_a_row['educational_qualification']; ?>" name="educational_qualification" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['CITY']; ?></label>
                                    <select class="chosen-select" name="city_slug[]">
                                        <option value=""><?php echo $Zitiziti['JOB-SELECT-JOB-CITY-LABEL']; ?></option>
                                        <?php
                                        foreach (getAllCities() as $city) {
                                            if (strtolower($city['city_name']) == 'www') {
                                                continue;
                                            }
                                        ?>
                                            <option <?php echo in_array($city['city_slug'], (array)json_decode($job_a_row['city_slug'], true)) ? 'selected' : '' ?>
                                                value="<?php echo $city['city_slug']; ?>">
                                                <?php echo $city['city_name']; ?>
                                            </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-COMPANY-LOGO-LABEL']; ?></label>
                                    <div class="fil-img-uplo">
                                        <span class="dumfil"><?php echo $Zitiziti['UPLOAD_A_FILE'];  ?></span>
                                        <input type="file" name="company_logo" accept="image/*,.jpg,.jpeg,.png" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-CATEGORY-LABEL']; ?></label>
                                    <select onChange="getSubCategory(this.value);" class="chosen-select" name="category_id">
                                        <option value=""><?php echo $Zitiziti['SELECT_CATEGORY']; ?></option>
                                        <?php
                                        foreach (getAllJobCategories() as $categories_row) {
                                            ?>
                                            <option
                                                <?php if ($job_a_row['category_id'] == $categories_row['category_id']) {
                                                    echo "selected";
                                                } ?>
                                                value="<?php echo $categories_row['category_id']; ?>"><?php echo $categories_row['category_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-SUB-CATEGORY-LABEL']; ?></label>
                                    <select class="chosen-select" id="sub_category_id" name="sub_category_id">
                                        <?php
                                        foreach (getCategorySubCategories($job_a_row['category_id']) as $sub_categories_row) {
                                            if ($job_a_row['sub_category_id'] != 0) {
                                                ?>
                                                <option <?php
                                                if ($sub_categories_row['sub_category_id'] == $job_a_row['sub_category_id']) {
                                                    echo "selected";
                                                } ?>
                                                    value="<?php echo $sub_categories_row['sub_category_id']; ?>"><?php echo $sub_categories_row['sub_category_name']; ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value=""><?php echo $Zitiziti['SELECT_SUB_CATEGORY']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-TYPE-LABEL']; ?></label>
                                    <select class="chosen-select" name="job_type">
                                        <option <?php if ($job_a_row['job_type'] == 1) { echo "selected"; } ?> value="1"><?php echo $Zitiziti['JOB-PERMANENT']; ?></option>
                                        <option <?php if ($job_a_row['job_type'] == 2) { echo "selected"; } ?> value="2"><?php echo $Zitiziti['JOB-CONTRACT']; ?></option>
                                        <option <?php if ($job_a_row['job_type'] == 3) { echo "selected"; } ?> value="3"><?php echo $Zitiziti['JOB-PART-TIME']; ?></option>
                                        <option <?php if ($job_a_row['job_type'] == 4) { echo "selected"; } ?> value="4"><?php echo $Zitiziti['JOB-FREELANCE']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-YEARS-OF-EXPERIENCE-LABEL']; ?></label>
                                    <input type="text" onkeypress="return isNumber(event)" value="<?php echo $job_a_row['years_of_experience']; ?>" name="years_of_experience" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-CONTACT-NO-LABEL']; ?></label>
                                    <input type="text" onkeypress="return isNumber(event)" value="<?php echo $job_a_row['contact_number']; ?>" name="contact_number" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['COMP-PRO-EMAIL']; ?></label>
                                    <input type="email" value="<?php echo $job_a_row['contact_email_id']; ?>" name="contact_email_id" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['COMP-PRO-WEBSITE']; ?></label>
                                    <input type="text" value="<?php echo $job_a_row['contact_website']; ?>" name="contact_website" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-CONTACT-PERSON-LABEL']; ?></label>
                                    <input type="text" value="<?php echo $job_a_row['contact_person']; ?>" name="contact_person" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-INTERVIEW-LOCATION-LABEL']; ?></label>
                                    <input type="text" value="<?php echo $job_a_row['interview_location']; ?>" name="interview_location" class="form-control">
                                    <!-- INPUT TOOL TIP -->
                                    <div class="inp-ttip">
                                        <b>Map location</b>
                                        Get your interview location link from google map and use here.
                                    </div>
                                    <!-- END INPUT TOOL TIP -->
                                </div>
                            </div>

                            <div class="col-md-12">
                            <?php
                                include "../booking_system_edit.php";
                            ?>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-COMPANY-NAME-LABEL']; ?></label>
                                    <input type="text" value="<?php echo $job_a_row['job_company_name']; ?>" name="job_company_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-SKILL-SET-LABEL']; ?></label>
                                    <select class="chosen-select" multiple name="skill_set[]">
                                        <?php
                                        foreach (getAllJobSkill() as $skill_row) {
                                            ?>
                                            <option
                                                <?php $catArray = explode(',', $job_a_row['skill_set']);
                                                foreach ($catArray as $cat_Array) {
                                                    if ($skill_row['category_id'] == $cat_Array) {
                                                        echo "selected";

                                                    }

                                                } ?>
                                                value="<?php echo $skill_row['category_id']; ?>"><?php echo $skill_row['category_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-DESCRIPTION-LABEL']; ?></label>
                                    <textarea name="job_description" class="form-control"
                                              id="job_description"><?php echo $job_a_row['job_description']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="tit"><?php echo $Zitiziti['JOB-SMALL-DESCRIPTION-LABEL']; ?></label>
                                    <textarea name="job_small_description" class="form-control"><?php echo $job_a_row['job_small_description']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <button name="job_submit" class="blu-upp"><?php echo $Zitiziti['JOB-UPDATE-NOW']; ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include "../footer.php";
?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="../js/jquery.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<script type="text/javascript">var webpage_full_link = '<?php echo $webpage_full_link;?>';</script>
<script type="text/javascript">var login_url = '<?php echo $LOGIN_URL;?>';</script>
<script src="../js/custom.js"></script>
<script src="../js/select-opt.js"></script>
<script src="../js/jquery.validate.min.js"></script>
<script src="../js/custom_validation.js"></script>
<script>
    function getSubCategory(val) {
        var category_type = "job";
        $.ajax({
            type: "POST",
            url: "../sub_category_process.php",
            data: { category_id: val, category_type: category_type },
            success: function(data) {
                $("#sub_category_id").html(data);
                $('#sub_category_id').trigger("chosen:updated");
            }
        });
    }
</script>
<script>
    var slider = document.getElementById("salsli");
    var output = document.getElementById("salout");
    output.innerHTML = slider.value;

    slider.oninput = function () {
        output.innerHTML = this.value + "K";
    }
</script>
<script>
    function updateTextInput(val) {
        document.getElementById('textInput').value=val;
    }
</script>
<script src="../admin/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('job_description');
</script>

<?php
include "../script.php";
?>
</body>

</html>