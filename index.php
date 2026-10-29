<?php
// Start or resume session
session_start();
// If already logged in go to dashboard
// If not logged in go to login
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
} else {
    header("Location: login.php");
}
exit();
?>