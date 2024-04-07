<?php
require_once __DIR__ . '/vendor/autoload.php'; // Include Composer's autoloader
use MongoDB\Client; // Import MongoDB\Client class

$mongoClient = new MongoDB\Client("mongodb+srv://tiptopywafula:dmdlhNmFeQl2iGSA@cluster1.eqpw9zl.mongodb.net/?retryWrites=true&w=majority&appName=Cluster1"); // Create a new MongoDB client instance
$db = $mongoClient->elderly_care; // Select the 'elderly_care' database
?>
