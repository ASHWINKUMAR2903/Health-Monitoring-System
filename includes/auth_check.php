<?php
// Include this at the very top (before any HTML) of any page
// that should only be visible to logged-in users.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    $_SESSION['msg'] = 'You must log in first';
    header('Location: login.php');
    exit;
}
