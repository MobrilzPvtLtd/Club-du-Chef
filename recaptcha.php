<?php
// Your Google reCAPTCHA Secret Key
$secretKey = $RECAPTCHA_SECRET_KEY['RECAPTCHA_SECRET_KEY'];

// Response from the reCAPTCHA widget
$recaptchaResponse = $_POST['g-recaptcha-response'];

// Validate reCAPTCHA
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = [
    'secret' => $secretKey,
    'response' => $recaptchaResponse
];

// Use cURL to send the request to Google for verification
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Decode the response from Google reCAPTCHA API
$responseKeys = json_decode($response, true);

?>


