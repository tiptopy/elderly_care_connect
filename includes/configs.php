<?php
require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv as Dotenv;
$Dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$Dotenv->load();
$SecretKey = $_ENV['PAYSTACK_SECRET']; // Add your secret key here. Remember to change this to your live secret key in production
$PublicKey = $_ENV['PAYSTACK_PUBLIC']; // Add your public key here. Remember to change this to your live public key in production
