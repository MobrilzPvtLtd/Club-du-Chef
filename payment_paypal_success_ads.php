<?php
if (file_exists('config/info.php')) {
    include('config/info.php');
}

$ads_enquiry_id = $_REQUEST['ads_enquiry_id'];
$paypal_transaction_id = $_REQUEST['paymentId']; // PayPal transaction ID
$amount_paid = $_REQUEST['amount']; // PayPal received amount
$item_currency = $_REQUEST['currency']; // PayPal received currency type

$all_points_enquiry = mysqli_query($conn, "SELECT * FROM  " . TBL . "all_ads_enquiry where all_ads_enquiry_id='" . $ads_enquiry_id . "'");
$all_points_enquiry_row = mysqli_fetch_array($all_points_enquiry);
$user_id = $all_points_enquiry_row['user_id'];  //User Id

$user_details = mysqli_query($conn, "SELECT * FROM  " . TBL . "users where user_id='" . $user_id . "'");
$user_details_row = mysqli_fetch_array($user_details);

$user_code = $user_details_row['user_code'];  //User Code

$transaction_mode = 'PayPal';

$transaction_qry = "INSERT INTO " . TBL . "point_transactions 
        ( user_code, point_enquiry_id , user_id, transaction_amount, transaction_mode, transaction_currency, transaction_cdt) 
        VALUES 
        ('$user_code', '$ads_enquiry_id', '$user_id', '$amount_paid', '$transaction_mode', '$item_currency', '$curDate')";


$transaction_res = mysqli_query($conn, $transaction_qry);
$TransactionID = mysqli_insert_id($conn);
$translastID = $TransactionID;

$traupqry = "UPDATE " . TBL . "point_transactions 
					  SET transaction_code = '$paypal_transaction_id' 
					  WHERE transaction_id = $translastID";

$traupres = mysqli_query($conn, $traupqry);

if ($traupres) {

    $lisupqry23 = "UPDATE " . TBL . "all_ads_enquiry 
                    SET payment_status = 'Paid', ad_enquiry_status = 'Active' 
                    WHERE all_ads_enquiry_id = $ads_enquiry_id";

    $lisupres23 = mysqli_query($conn, $lisupqry23);

    $_SESSION['status_msg'] = $Zitiziti['PAYPAL_PAY_SUCCESSFULL_USER_POINT_UPGRADE_SUCESS'];

    header('Location: db-post-ads');

}

