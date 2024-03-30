<?php
require_once __DIR__ . '/vendor/autoload.php'; // Include Composer's autoloader
use Dotenv\Dotenv as Dotenv; // Import Dotenv namespace

$Dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Create a new instance of Dotenv
$Dotenv->load(); // Load environment variables from .env file

$SecretKey = $_ENV['PAYSTACK_SECRET']; // Retrieve secret key from environment variables

$PublicKey = $_ENV['PAYSTACK_PUBLIC']; // Retrieve public key from environment variables
?>
