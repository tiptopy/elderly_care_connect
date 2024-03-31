<?php
require_once __DIR__ . '/vendor/autoload.php'; // Include Composer's autoloader
require_once './authenticate.php'; // Include authentication functions

use Dotenv\Dotenv as Dotenv; // Import Dotenv namespace

$Dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Create a new instance of Dotenv
$Dotenv->load(); // Load environment variables from .env file

$donorName = $_POST['donorName']; // Retrieve donor name from POST data
$donorPhone = $_POST['donorPhone']; // Retrieve donor phone number from POST data
$donorAmount = $_POST['donorAmount']; // Retrieve donation amount from POST data
$creator_phone_number = $_POST['creator_phone_number']; // Retrieve creator's phone number from POST data

$mobile_iden = $_ENV['IDEN']; // Get mobile identifier from environment variables
$mobile_token = $_ENV['TOKEN']; // Get mobile token from environment variables
$addresses = "+254" . substr($donorPhone, -9); // Format mobile number to send text to
$sms = "Greetings $donorName, your donation of KES $donorAmount was received. Thank you for your donation. May God bless you."; // Create SMS message for donor

if (!empty($_POST['creator_phone_number'])) {
    // Additional message for creator_phone_number
    $creator_phone_message = "Greetings, $donorName just made a donation of KES $donorAmount to one of your elderly profiles. Thank you.";
    $result_creator = sendSMS($creator_phone_number, $creator_phone_message, $mobile_iden, $mobile_token);
    // Handle result or errors for creator's message if necessary
}

// Sending message for donor
$result_donor = sendSMS($addresses, $sms, $mobile_iden, $mobile_token);
// Handle result or errors for donor's message if necessary

// Function to send SMS
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
        echo 'Error:' . curl_error($ch); // Echo error if cURL fails
    }
    curl_close($ch); // Close cURL session
    return $result; // Return cURL result
}
?>
