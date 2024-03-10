<!-- includes/authenticate.php -->
<?php
session_start();
require_once 'db_connection.php';

function login($username, $password) {
    global $db;

    $user = $db->users->findOne(['username' => $username, 'password' => $password]);

    if ($user) {
        $_SESSION['user_id'] = (string)$user['_id'];
        return true;
    } else {
        return false;
    }
}

function logout() {
    session_unset();
    session_destroy();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
?>
