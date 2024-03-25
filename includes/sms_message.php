<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once './authenticate.php';

use Dotenv\Dotenv as Dotenv;

$Dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$Dotenv->load();

$donorName = $_POST['donorName'];
$donorPhone = $_POST['donorPhone'];
$donorAmount = $_POST['donorAmount'];
$creator_phone_number = $_POST['creator_phone_number'];
// Retrieve donor name from session

$mobile_iden = $_ENV['IDEN']; // as you have copied from the url, explained above
$mobile_token = $_ENV['TOKEN']; // as per your creation of token
$addresses = "+254" . substr($donorPhone, -9); // mobile number to send text to
$sms = "Greetings $donorName, your donation of KES $donorAmount was received. Thank you for your donation. May God bless you.";

if (!empty($_POST['creator_phone_number'])) {
    // Additional message for creator_phone_number
    $creator_phone_message = "Greetings, $donorName just made a donation of $donorAmount to one of your elderly profiles. Thank you.";
    $result_creator = sendSMS($creator_phone_number, $creator_phone_message, $mobile_iden, $mobile_token);
    // Handle result or errors for creator's message if necessary
}

// Sending message for donor
$result_donor = sendSMS($addresses, $sms, $mobile_iden, $mobile_token);

// Handle result or errors for donor's message if necessary

function sendSMS($addresses, $message, $mobile_iden, $mobile_token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$message\",\"target_device_iden\":\"$mobile_iden\"}}");

    $headers = [];
    $headers[] = 'Access-Token: ' . $mobile_token;
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    return $result;
}
