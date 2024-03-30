<?php
require_once __DIR__ . '/vendor/autoload.php'; // Include Composer's autoloader
use Dotenv\Dotenv as Dotenv; // Import Dotenv namespace

$Dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Create a new instance of Dotenv
$Dotenv->load(); // Load environment variables from .env file

$donorName = $_POST['donorName']; // Retrieve donor name from POST data
$donorPhone = $_POST['donorPhone']; // Retrieve donor phone number from POST data
$donorAmount = $_POST['donorAmount']; // Retrieve donation amount from POST data
$creator_phone_number = $_POST['creator_phone_number']; // Retrieve creator's phone number from POST data

$baseUrl = $_ENV['BASE_URL']; // Get base URL from environment variables
$phoneNumber = "+254" . substr($donorPhone, -9); // Format donor's phone number
$message = "Greetings $donorName, your donation of KES $donorAmount was received. Thank you for your donation. May God bless you."; // Create message for donor
$messageType = "text"; // Set message type
$apiKey = $_ENV['APIKEY']; // Get API key from environment variables

// Send message to donor
$data_donor = sendWhatsAppMessage($baseUrl, $phoneNumber, $message, $messageType, $apiKey);

// Check if creator_phone_number is not empty and send a different message
if (!empty($creator_phone_number)) {
    $creator_message = "Hello, a donation of KES $donorAmount was received from $donorName. Thank you.";
    $creator_phone_number = "+254" . substr($creator_phone_number, -9); // Format creator's phone number
    $data_creator = sendWhatsAppMessage($baseUrl, $creator_phone_number, $creator_message, $messageType, $apiKey);
    // Handle response for creator's message if necessary
}

// Handle response for donor's message if necessary
echo json_encode($data_donor);

// Function to send WhatsApp message
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
        echo "Error response code: " . $httpCode; // Echo error if HTTP response code is not 200
        return null;
    }
}
?>
