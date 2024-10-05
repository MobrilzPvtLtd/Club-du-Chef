<?php
if (file_exists('config/info.php')) {
    include('config/info.php');
}

if (file_exists('config/user_authentication.php')) {
    include('config/user_authentication.php');
}
require __DIR__  . '/vendor/autoload.php';

$user_id = $_SESSION['user_id'];

if (isset($user_id)) {

    $user_details_row = getUser($user_id); //Fetch Logged In user data
    $user_plan = $user_details_row['user_plan']; //Fetch of Logged In user Plan

    $user_plan_type = getPlanType($user_plan); //Fetch Logged In User Plan details and data
}else{

    header('Location: index');
    exit;
}

$footer_row = getAllFooter();

$ads_enquiry_id = $_SESSION['ads_enquiry_id'];
$ad_total_cost = $_SESSION['ad_total_cost']; 

$admin_paypal_currency_code = $footer_row['admin_paypal_currency_code']; // Admin Paypal Currency Code

$link_with_payment_failure = $webpage_full_link. "point_payment_paypal_failure";  //URL Payment Failure Link
$link_with_payment_success = $webpage_full_link. "payment_paypal_success_ads" . '?' . 'ads_enquiry_id'. '=' .$ads_enquiry_id . '&amount=' . $ad_total_cost . '&currency=' . $admin_paypal_currency_code;


$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AYdXiaWIIrog7CKW0ylN6N6R9bCT1oZe5aPv3DD4b7pwX8f4OFNB-YzqPyax2abaWRTyWbnJtlels5m2',     // ClientID
        'EHXJM6uhRnExFegzVmsVRmslM8oWmgENlj-uXILINpbC7lx-q2YYdwUcZ2ULuD7QK36TCymssa69WpXB'      // ClientSecret
    )
);


$payer = new \PayPal\Api\Payer();
$payer->setPaymentMethod('paypal');

$amount = new \PayPal\Api\Amount();
$amount->setTotal($ad_total_cost);
$amount->setCurrency($admin_paypal_currency_code);

$transaction = new \PayPal\Api\Transaction();
$transaction->setAmount($amount);

$redirectUrls = new \PayPal\Api\RedirectUrls();
$redirectUrls->setReturnUrl($link_with_payment_success)
    ->setCancelUrl($link_with_payment_failure);

$payment = new \PayPal\Api\Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setTransactions(array($transaction))
    ->setRedirectUrls($redirectUrls);

try {
    $payment->create($apiContext);
    header('Location: ' . $payment->getApprovalLink());
    exit;
    // echo $payment;

    // echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
}
catch (\PayPal\Exception\PayPalConnectionException $ex) {
    echo $ex->getData();
}