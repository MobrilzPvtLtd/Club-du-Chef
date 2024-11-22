<?php
include "header.php";

if (file_exists('config/user_authentication.php')) {
    include('config/user_authentication.php');
}
include "dashboard_left_pane.php";
?>
    <!--CENTER SECTION-->
    <div class="ud-main">
   <div class="ud-main-inn ud-no-rhs">
    <div class="ud-cen">
        <div class="log-bor">&nbsp;</div>
        <span class="udb-inst"><?php echo $Zitiziti['AD-DETAILS-PAID-ADS']; ?></span>
        <?php include('config/user_activation_checker.php'); ?>
        <div class="ud-cen-s2">
            <h2><?php echo $Zitiziti['AD-DETAILS-BANNER-ADS']; ?></h2>
            <?php include "page_level_message.php"; ?>
            <a href="post-your-ads" class="db-tit-btn db-tit-btn-2-ads"><?php echo $Zitiziti['AD-DETAILS-POST-YOUR-ADS']; ?></a>
            <a href="ad-details" class="db-tit-btn"><?php echo $Zitiziti['AD-DETAILS-PRICING-OTHER-DETAILS']; ?></a>
            <table class="responsive-table bordered">
                <thead>
                <tr>
                    <th><?php echo $Zitiziti['S_NO']; ?></th>
                    <th><?php echo $Zitiziti['AD-DETAILS-ADS-POSITION']; ?></th>
                    <th><?php echo $Zitiziti['COUPON-START-DATE-PLACEHOLDER']; ?></th>
                    <th><?php echo $Zitiziti['COUPON-END-DATE-PLACEHOLDER']; ?></th>
                    <th><?php echo $Zitiziti['DURATION']; ?></th>
                    <th><?php echo $Zitiziti['STATUS']; ?></th>
                    <th><?php echo "Payment Status" ?></th>
                    <th><?php echo $Zitiziti['VIEWS']; ?></th>
                    <th><?php echo $Zitiziti['CLICKS']; ?></th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody class="">
                <?php
                $si = 1;
                $session_user_id = $_SESSION['user_id'];
                foreach (getAllUserAdsEnquiry($session_user_id) as $row) {

                    $all_ads_price_id = $row['all_ads_price_id'];

                    $user_id = $row['user_id'];

                    $user_details_row = getUser($user_id);

                    $ads_price_details_row = getAdsPrice($all_ads_price_id);

                    ?>
                    <tr style='width:100vw'>
                        <td style='width:100%'><?php echo $si; ?></td>
                        <td style='width:100%' class='text-center'><?php echo $ads_price_details_row['ad_price_name']; ?></td>
                        <td style='width:100%'><?php echo dateFormatconverter($row['ad_start_date']);?></td>
                        <td style='width:100%'><?php echo dateFormatconverter($row['ad_end_date']);?></td>
                        <td style='width:100%'><?php echo $row['ad_total_days']; ?> <?php echo $Zitiziti['DAYS']; ?></td>
                        <td style='width:100%'><span class="db-list-ststus"><?php echo $row['ad_enquiry_status']; ?></span></td>
                        <td style='width:100%'>
                            <span class="btn <?php echo $row['payment_status'] == "Paid" ? 'btn-success' : 'btn-danger'; ?>" 
                                style="padding: 3px 10px; font-weight: 600; font-size: 11px; border-radius: 2px; border: 0 solid #d3d3d3;">
                                <?php echo $row['payment_status']; ?>
                            </span>
                        </td>
                        <td style='width:100%'><span class="db-list-rat">1k</span></td>
                        <td style='width:100%'><span class="db-list-rat">642</span></td>
                        <td style='width:100%'><a href="post-your-ads-edit.php?row=<?php echo $row['all_ads_enquiry_id']; ?>&path=1" class="db-list-edit">Edit</a></td>
                    </tr>
                    <?php
                    $si++;
                }
                ?>
                </tbody>
            </table>
            <div class="ud-notes">
                <p><?php echo $Zitiziti['DB-PAYMENTS-FOOTER-NOTES'];?>: <?php echo $Zitiziti['DB-PAYMENTS-FOOTER-NOTES-MESSAGE'];?></p>
            </div>
        </div>
    </div>
<?php
include "dashboard_right_pane.php";
?>