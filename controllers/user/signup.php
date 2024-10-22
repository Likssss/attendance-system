<?php
include '../../config/db.php';
$signup_success = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the username or email already exists
    $sql_check = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result_check = $conn->query($sql_check);
    if ($result_check->num_rows > 0) {
        $error_message = 'Username or email already exists. Please choose a different one.';
    }

    if (empty($error_message)) {
        $sql = "INSERT INTO users (username, email, password, is_admin, is_verified, notification, notification_type, timestamp) VALUES ('$username', '$email', '$password', 0, 0, 1, 'user_signup', NOW())";
        if ($conn->query($sql) === TRUE) {
            $signup_success = true;
        } else {
            $error_message = 'Error: ' . $conn->error;
        }
    }
}

include '../../views/user/signup.php';
