<?php
// Redirect to login if not authenticated
function requireAuth() {
    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        $_SESSION['error'] = "Please login to access this page";
        header("Location: ../users/login.php");
        exit;
    }
}

// Check if user is logged in (returns boolean)
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Check if current user is admin
function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}
?>
