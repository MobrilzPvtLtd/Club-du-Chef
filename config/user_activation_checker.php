<?php
if ($user_details_row['user_status'] == 'Inactive') {
    ?>
    <div class="log-error use-act-err">
        <p>
            <?php
            if ($user_details_row['user_type'] == "Service Provider") {
                echo $Zitiziti['USER_NOT_ACTIVATED_MESSAGE'];
            } else {
                echo $Zitiziti['GENERAL_USER_NOT_ACTIVATED_MESSAGE'];
            }
            ?>
        </p>
    </div>
    <?php
}
?>