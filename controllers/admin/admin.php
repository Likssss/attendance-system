<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
include '../../config/db.php';

// Fetch all attendance records
$sql = "SELECT users.username, attendance.id, attendance.date, attendance.status
        FROM attendance
        JOIN users ON attendance.user_id = users.id";
$result = $conn->query($sql);

// Handle deletion of attendance records
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_attendance_id'])) {
    $attendance_id = $_POST['delete_attendance_id'];
    $sql_delete = "DELETE FROM attendance WHERE id='$attendance_id'";
    if ($conn->query($sql_delete) === TRUE) {
        echo "Attendance record deleted successfully.";
        // Refresh the page to reflect changes
        header("Location: admin.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

include '../../views/admin/admin.php';
?>
