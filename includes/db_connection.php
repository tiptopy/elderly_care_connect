<!-- includes/db_connection.php -->
<?php
require_once __DIR__ . '/vendor/autoload.php';
use MongoDB\Client;

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$db = $mongoClient->elderly_care;
?>
