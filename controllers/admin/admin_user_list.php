<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
include '../../config/db.php';

// Fetch all user accounts
$sql = "SELECT * FROM users WHERE is_admin=0";
$result = $conn->query($sql);

// Handle deletion of user accounts
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user_id'])) {
    $delete_user_id = $_POST['delete_user_id'];
    $sql_delete = "DELETE FROM users WHERE id='$delete_user_id'";
    if ($conn->query($sql_delete) === TRUE) {
        echo "User account deleted successfully.";
        // Refresh the page to reflect changes
        header("Location: admin_user_list.php");
        exit();
    } else {
        echo "Error deleting user account: " . $conn->error;
    }
}

include '../../views/admin/admin_user_list.php';
?>
