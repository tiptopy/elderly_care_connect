<?php
require_once __DIR__ . '/vendor/autoload.php'; // Include Composer's autoloader
use MongoDB\Client; // Import MongoDB\Client class

$mongoClient = new MongoDB\Client("mongodb://localhost:27017"); // Create a new MongoDB client instance
$db = $mongoClient->elderly_care; // Select the 'elderly_care' database
?>
