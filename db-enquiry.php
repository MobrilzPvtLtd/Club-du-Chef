<?php
include "header.php";

if (file_exists('config/user_authentication.php')) {
    include('config/user_authentication.php');
}

if (file_exists('config/listing_page_authentication.php')) {
    include('config/listing_page_authentication.php');
}

include "dashboard_left_pane.php";
?>

    <!--CENTER SECTION-->
    <div class="ud-main">
   <div class="ud-main-inn ud-no-rhs">
    <div class="ud-cen">
        <div class="log-bor">&nbsp;</div>
        <span class="udb-inst"><?php echo $Zitiziti['LEADS']; ?></span>
        <?php include('config/user_activation_checker.php'); ?>
        <div class="ud-cen-s2">
            <h2><?php echo $Zitiziti['ENQUIRY_DETAILS']; ?></h2>
            <?php include "page_level_message.php"; ?>
            <table class="responsive-table bordered" id="myTable">
                <thead>
                <tr>
                    <th><?php echo $Zitiziti['S_NO']; ?></th>
                    <th><?php echo $Zitiziti['NAME']; ?></th>
                    <th><?php echo $Zitiziti['EMAIL']; ?></th>
                    <th><?php echo $Zitiziti['PHONE']; ?></th>
                    <th><?php echo $Zitiziti['MESSAGE']; ?></th>
                    <th><?php echo $Zitiziti['PAGE_NAME']; ?></th>
                    <th><?php echo $Zitiziti['TRACKING_ID']; ?></th>
                    <th><?php echo $Zitiziti['URL']; ?></th>
                    <th><?php echo $Zitiziti['DELETE']; ?></th>
                </tr>
                </thead>
                <tbody>

                <?php
                $si = 1;
                $session_user_id = $_SESSION['user_id'];
                foreach (getUserEnquiries($session_user_id) as $enquiries_row) {

                    $enquiry_listing_id = $enquiries_row['listing_id'];
                    $enquiry_event_id = $enquiries_row['event_id'];
                    $enquiry_blog_id = $enquiries_row['blog_id'];
                    $enquiry_product_id = $enquiries_row['product_id'];

                    $listing_enquiry_row = getAllListingUserListing($session_user_id,$enquiry_listing_id);
                    $event_enquiry_row = getEvent($enquiry_event_id);
                    $blog_enquiry_row = getBlog($enquiry_blog_id);
                    $product_enquiry_row = getIdProduct($enquiry_product_id);

                    ?>
                    <tr>
                        <td><?php echo $si; ?></td>
                        <td><?php echo $enquiries_row['enquiry_name']; ?>
                            <span><?php echo dateFormatconverter($enquiries_row['enquiry_cdt']); ?></span>
                        </td>
                        <td><?php echo $enquiries_row['enquiry_email']; ?></td>
                        <td><?php echo $enquiries_row['enquiry_mobile']; ?></td>
                        <td><?php echo $enquiries_row['enquiry_message']; ?></td>
                        <td><?php
                            if($enquiry_listing_id != 0){
                                echo $listing_enquiry_row['listing_name'];
                            }else if($enquiry_event_id != 0){
                                echo $event_enquiry_row['event_name'];
                            } elseif($enquiry_blog_id != 0){
                                echo $blog_enquiry_row['blog_name'];
                            }elseif($enquiry_product_id != 0){
                                echo $product_enquiry_row['product_name'];
                            } else{
                                echo "N/A";
                            }
                            ?></td>
                        <td><?php echo $enquiries_row['enquiry_source']; ?></td>
                        <td><?php echo $LISTING_URL . urlModifier($listing_enquiry_row['listing_slug'])."?src=".$enquiries_row['enquiry_source']; ?></td>
                        <td><a href="enquiry_trash.php?messageenquirymessageenquirymessageenquirymessageenquiry=<?php echo $enquiries_row['enquiry_id']; ?>" class="db-list-edit"><?php echo $Zitiziti['DELETE']; ?></a></td>
                    </tr>
                    <?php
                    $si++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
if (isset($_GET['ledname_1'])) {
    trashFolderNew($_GET['ledname_1']);
}
include "dashboard_right_pane.php";
?>