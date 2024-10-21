<?php
session_start();
include '../../config/db.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND is_admin=0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: profile.php");
            exit();
        } else {
            $error_message = 'Invalid password. Please try again.';
        }
    } else {
        $error_message = 'Invalid username. Please try again.';
    }
}

include '../../views/user/login.php';
