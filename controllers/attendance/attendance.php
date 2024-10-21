<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include '../../config/db.php';

$user_id = $_SESSION['user_id'];
$date = date('Y-m-d');

// Fetch attendance records
$sql = "SELECT * FROM attendance WHERE user_id='$user_id'";
$result = $conn->query($sql);

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "SELECT * FROM attendance WHERE user_id='$user_id' AND date='$date'";
    $check_existing = $conn->query($sql);

    if ($check_existing->num_rows == 0) {
        $sql = "INSERT INTO attendance (user_id, date, status) VALUES ('$user_id', '$date', 'Present')";
        if ($conn->query($sql) === TRUE) {
            // Update notification
            $sql_notification = "UPDATE users SET notification=1, notification_type='attendance_checked', timestamp=NOW() WHERE id='$user_id'";
            $conn->query($sql_notification);

            $response = ['status' => 'success', 'date' => $date, 'message' => 'Attendance marked for today.'];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to mark attendance. Please try again.'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Attendance already marked for today.'];
    }

    echo json_encode($response);
    exit();
}

include '../../views/attendance/attendance.php';
?>
