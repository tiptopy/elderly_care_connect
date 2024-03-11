<?php
require_once '../includes/db_connection.php';
header("Content-Type: application/json");
$PaystackCallbackResponse = file_get_contents('php://input');
$logFile = "Paystackresponse.json";
$log = fopen($logFile, "a");
fwrite($log, $PaystackCallbackResponse);
fclose($log);

$webhookData = json_decode($PaystackCallbackResponse, true);

if ($webhookData) {
    try {
        //send sms
        require_once __DIR__ . '/sms_message.php';
        // Insert data into MongoDB
        $result = $db->transactions->insertOne($webhookData);

        if ($result->getInsertedCount() > 0) {
            echo "Webhook data inserted successfully.";
        } else {
            echo "Failed to insert webhook data.";
        }
    } catch (MongoDB\Driver\Exception\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No data received from webhook.";
}