<?php
session_start();
// Destroy session
session_destroy();
// Clear cookies if any
if (isset($_COOKIE['user_login'])) {
    unset($_COOKIE['user_login']);
    setcookie('user_login', '', time() - 3600, '/');
}
// Redirect to login page
header("Location: login.php");
exit();
?>