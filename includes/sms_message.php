<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once './authenticate.php';

use Dotenv\Dotenv as Dotenv;

$Dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$Dotenv->load();

$donorName = isset($_SESSION['donorName']) ? $_SESSION['donorName'] : 'none';
// Now you can use $donorName variable wherever needed


$mobile_iden = $_ENV['IDEN']; // as you have copied from the url, explained above
$mobile_token = $_ENV['TOKEN']; // as per your creation of token

$addresses = '+254741816281'; // mobile number to send text to
$sms = 'hi' . $donorName;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

$headers = [];
$headers[] = 'Access-Token: ' . $mobile_token;
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
