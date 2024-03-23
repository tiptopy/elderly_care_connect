<?php

require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv as Dotenv;
$Dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$Dotenv->load();

$donorName = $_POST['donorName'];
$donorPhone = $_POST['donorPhone'];
$donorAmount = $_POST['donorAmount'];
$creator_phone_number = $_POST['creator_phone_number'];

$baseUrl = $_ENV['BASE_URL'];
$phoneNumber = "+254". substr($donorPhone,-9); // mobile number to send text to
$message = "Greetings $donorName, your donation of KES $donorAmount was received. Thank you for your donation. May God bless you.";
$messageType = "text";
$apiKey = $_ENV['APIKEY'];

// Send message to donor
$data_donor = sendWhatsAppMessage($baseUrl, $phoneNumber, $message, $messageType, $apiKey);

// Check if creator_phone_number is not empty and send a different message
if (!empty($creator_phone_number)) {
    $creator_message = "Hello, a donation of KES $donorAmount was received from $donorName. Thank you.";
    $creator_phone_number = "+254". substr($creator_phone_number,-9);
    $data_creator = sendWhatsAppMessage($baseUrl, $creator_phone_number, $creator_message, $messageType, $apiKey);
    // Handle response for creator's message if necessary
}

// Handle response for donor's message if necessary
echo json_encode($data_donor);

function sendWhatsAppMessage($baseUrl, $phoneNumber, $message, $messageType, $apiKey) {
    $url = $baseUrl . "/whatsapp/send-message";

    $postData = json_encode(array(
        "phoneNumber" => $phoneNumber,
        "message" => $message,
        "type" => $messageType
    ));

    $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer " . $apiKey
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpCode == 200) {
        return json_decode($response, true);
    } else {
        echo "Error response code: " . $httpCode;
        return null;
    }
}
?>
