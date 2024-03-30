<?php
require_once '../includes/db_connection.php'; // Include the database connection file
header("Content-Type: application/json"); // Set the response content type to JSON
$PaystackCallbackResponse = file_get_contents('php://input'); // Get the Paystack callback response
$logFile = "Paystackresponse.json"; // Define the log file path
$log = fopen($logFile, "a"); // Open the log file in append mode
fwrite($log, $PaystackCallbackResponse); // Write the callback response to the log file
fclose($log); // Close the log file

$webhookData = json_decode($PaystackCallbackResponse, true); // Decode the JSON data

if ($webhookData) {
    try {
        // Insert data into MongoDB
        $result = $db->transactions->insertOne($webhookData);

        // Check if data insertion was successful
        if ($result->getInsertedCount() > 0) {
            echo "Webhook data inserted successfully."; // Echo success message
        } else {
            echo "Failed to insert webhook data."; // Echo failure message
        }
    } catch (MongoDB\Driver\Exception\Exception $e) {
        echo "Error: " . $e->getMessage(); // Echo error message if an exception occurs
    }
} else {
    echo "No data received from webhook."; // Echo message if no data is received from webhook
}
?>
