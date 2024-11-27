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

include "../dashboard_left_pane.php";


?>
    <!--CENTER SECTION-->
    <div class="ud-main">
   <div class="ud-main-inn ud-no-rhs mt-5 w-100 d-flex justify-content-center">
    <div class="ud-cen">
        <div class="log-bor">&nbsp;</div>
        <span class="udb-inst"><?php echo $Zitiziti['ALL_JOBS']; ?></span>
        <?php include('../config/user_activation_checker.php'); ?>
        <div class="ud-cen-s2">
            <h2><?php echo $Zitiziti['JOB_DETAILS']; ?></h2>
            <?php include "../page_level_message.php"; ?>
            <a href="create-job" class="db-tit-btn"><?php echo $Zitiziti['ADD_NEW_JOB']; ?></a>
            <div class="table-responsive">
                <table class="table bordered">
                    <thead>
                        <tr>
                            <th><?php echo $Zitiziti['S_NO']; ?></th>
                            <th><?php echo $Zitiziti['JOB_NAME']; ?></th>
                            <th><?php echo $Zitiziti['JOB_APPLICANTS']; ?></th>
                            <th><?php echo $Zitiziti['JOB_APPLICANT_PROFILE']; ?></th>
                            <th><?php echo $Zitiziti['VIEWS']; ?></th>
                            <th><?php echo $Zitiziti['EDIT']; ?></th>
                            <th><?php echo $Zitiziti['DELETE']; ?></th>
                            <th><?php echo $Zitiziti['PREVIEW']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                    $si = 1;
                    foreach (getAllJobUser($_SESSION['user_id']) as $jobrow) {

                        $job_id = $jobrow['job_id'];

                    $applied_job_count = getCountJobAppliedJob($job_id);

                        ?>
                        <tr>
                            <td><?php echo $si; ?></td>
                            <td><?php echo $jobrow['job_title']; ?><span><?php echo dateFormatconverter($jobrow['job_cdt']); ?></span></td>
                            <td><span class="db-list-rat"><?php echo AddingZero_BeforeNumber($applied_job_count); ?></span></td>
                            <td><a href="db-jobs-applicant-profile?code=<?php echo $jobrow['job_code']; ?>" class="db-list-rat">View profiles</a></td>
                            <td><span class="db-list-rat"><?php echo AddingZero_BeforeNumber(job_pageview_count($jobrow['job_id'])); ?></span></td>
                            <td><a href="edit-job?row=<?php echo $jobrow['job_code']; ?>" class="db-list-edit"><?php echo $Zitiziti['EDIT']; ?></a></td>
                            <td><a href="delete-job?row=<?php echo $jobrow['job_code']; ?>" class="db-list-edit"><?php echo $Zitiziti['DELETE']; ?></a></td>
                            <td><a href="<?php echo $JOB_URL . urlModifier($jobrow['job_slug']); ?>" class="db-list-edit" target="_blank">Visibility</a>
                            </td>
                        </tr>
                        <?php
                        $si++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
include "../dashboard_right_pane.php";
?>