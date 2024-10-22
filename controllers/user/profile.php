<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include '../../config/db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];

    $sql_update = "UPDATE users SET name='$name', age='$age', birthday='$birthday', gender='$gender', username='$username' WHERE id='$user_id'";
    if ($conn->query($sql_update) === TRUE) {
        $success_message = "Profile updated successfully.";
    } else {
        $error_message = "Error updating profile: " . $conn->error;
    }

    // Refresh the user data
    $sql = "SELECT * FROM users WHERE id='$user_id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}

include '../../views/user/profile.php';
