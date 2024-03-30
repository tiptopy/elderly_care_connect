<?php
session_start(); // Start the session
require_once 'db_connection.php'; // Include the database connection

// Function to authenticate user login
function login($username, $password) {
    global $db; // Access global variable for database connection

    // Find user in the database based on provided username and password
    $user = $db->users->findOne(['username' => $username, 'password' => $password]);

    // If user is found, set the user ID in session and return true
    if ($user) {
        $_SESSION['user_id'] = (string)$user['_id'];
        return true;
    } else {
        return false; // Return false if user is not found
    }
}

// Function to log out the user
function logout() {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
}

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']); // Return true if user ID is set in session
}
?>
