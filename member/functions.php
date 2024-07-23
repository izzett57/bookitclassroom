<?php
session_start();
require_once '../assets/db_conn.php';
require_once '../assets/check-user-type.php';

define('SITE_URL', 'http://localhost:5500/guest/login.php'); // Adjust this to your local setup

function isLoggedIn() {
    return isset($_SESSION['ID']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../guest/login.php");
        exit();
    }
}

function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

function redirect($location) {
    header("Location: " . SITE_URL . "/" . $location);
    exit();
}
?>