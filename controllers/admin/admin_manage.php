<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
include '../../config/db.php';

// Fetch all admin accounts
$sql = "SELECT * FROM users WHERE is_admin=1 AND is_verified=1";
$result = $conn->query($sql);

// Fetch pending admin approvals
$pending_sql = "SELECT * FROM users WHERE is_admin=1 AND is_verified=0";
$pending_result = $conn->query($pending_sql);

// Handle deletion and approval/denial of admin accounts
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_admin_id'])) {
        $delete_admin_id = $_POST['delete_admin_id'];
        $sql_delete = "DELETE FROM users WHERE id='$delete_admin_id'";
        if ($conn->query($sql_delete) === TRUE) {
            echo "Admin account deleted successfully.";
        } else {
            echo "Error deleting admin account: " . $conn->error;
        }
    } elseif (isset($_POST['approve_admin_id'])) {
        $approve_admin_id = $_POST['approve_admin_id'];
        $sql_approve = "UPDATE users SET is_verified=1 WHERE id='$approve_admin_id'";
        if ($conn->query($sql_approve) === TRUE) {
            echo "Admin approved successfully.";
        } else {
            echo "Error approving admin: " . $conn->error;
        }
    } elseif (isset($_POST['deny_admin_id'])) {
        $deny_admin_id = $_POST['deny_admin_id'];
        $sql_deny = "DELETE FROM users WHERE id='$deny_admin_id'";
        if ($conn->query($sql_deny) === TRUE) {
            echo "Admin request denied and user deleted.";
        } else {
            echo "Error denying admin: " . $conn->error;
        }
    }
    // Refresh the page to reflect changes
    header("Location: admin_manage.php");
    exit();
}
include '../../views/admin/admin_manage.php';
