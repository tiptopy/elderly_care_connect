<?php
require_once __DIR__ . '/vendor/autoload.php'; // Include Composer's autoloader
use MongoDB\Client; // Import MongoDB\Client class
use Dotenv\Dotenv as Dotenv; // Import Dotenv namespace

$Dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Create a new instance of Dotenv
$Dotenv->load(); // Load environment variables from .env file

$mongoClient = new MongoDB\Client("mongodb+srv://tiptopywafula:dmdlhNmFeQl2iGSA@cluster1.eqpw9zl.mongodb.net/?retryWrites=true&w=majority&appName=Cluster1"); // Create a new MongoDB client instance Default, mongodb://localhost:27017
$db = $mongoClient->elderly_care; // Select the 'elderly_care' database
?>