<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
include '../../config/db.php';

$admin_id = $_SESSION['admin_id'];
$sql = "SELECT * FROM users WHERE id='$admin_id'";
$result = $conn->query($sql);
$admin = $result->fetch_assoc();

// Check for notifications
$notif_sql = "SELECT * FROM users WHERE notification=1 ORDER BY timestamp DESC";
$notif_result = $conn->query($notif_sql);

include '../../views/admin/admin_profile.php';
?>
