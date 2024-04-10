<?php
include 'configs.php'; // Include configuration file
require_once '../includes/db_connection.php'; // Include the database connection file
require_once '../includes/authenticate.php';

if (isset($_GET['reference'])) {
    $referenceId = $_GET['reference'];
    if ($referenceId == '') {
        header("Location: ../index.php"); // Redirect to index page if reference ID is empty
    } else {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/$referenceId",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $SecretKey",
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err; // Echo cURL error if occurred
        } else {
            $data = json_decode($response);
            if ($data->status == true) {
                // save transaction details if verification is successful
                $transaction_message = $data->message;
                $paid_reference = $data->data->reference;
                $message = $data->data->message;
                $gateway_response = $data->data->gateway_response;
                $receipt_number = $data->data->receipt_number;

            } else {
                // Display error message if verification fails
                echo $transaction_message = $data->message;
            }
            if ($data) {
                try {
                    // Insert data into MongoDB
                    $result = $db->transactions->insertOne($data);
                    if (isset($_SESSION['profile_id'])) {
                        $donation_to = $db->transactions->updateOne(['data.reference' => $data->data->reference], ['$set' => [
                            'DonationTo' => $_SESSION['profile_id']
                        ]]);
                    }
                    // Check if data insertion was successful
                    if (!($result->getInsertedCount() > 0)) {
                        echo "Failed to insert webhook data."; // Echo failure message
                    }
                } catch (MongoDB\Driver\Exception\Exception $e) {
                    echo "Error: " . $e->getMessage(); // Echo error message if an exception occurs
                }
            } else {
                echo "No data received from webhook."; // Echo message if no data is received from webhook
            }
        }
    }
} else {
    header("Location: ../index.php"); // Redirect to index page if reference ID is not set
}

?>

<link rel="stylesheet" href="../css/verification.css">
</head>

<body>
    <div class="homepage-container">
        <div class="notification-box">
            <?php if (isset($transaction_message)) : ?>
                <p><?php echo $transaction_message; ?></p>
                <?php if (isset($paid_reference)) : ?>
                    <p>Reference: <?php echo $paid_reference; ?></p>
                <?php endif; ?>
                <?php if (isset($message)) : ?>
                    <p>Message: <?php echo $message; ?></p>
                <?php endif; ?>
                <?php if (isset($gateway_response)) : ?>
                    <p>Gateway Response: <?php echo $gateway_response; ?></p>
                <?php endif; ?>
                <?php if (isset($receipt_number)) : ?>
                    <p>Receipt Number: <?php echo $receipt_number; ?></p>
                <?php endif; ?>
            <?php else : ?>
                <p>No transaction details available.</p>
            <?php endif; ?>
            <a href="../index.php" class="create-profile-link">Return Home</a>
        </div>
    </div>
</body>

</html>