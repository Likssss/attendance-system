<?php
include '../../config/db.php';

$signup_success = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the username already exists
    $sql_check_username = "SELECT * FROM users WHERE username='$username'";
    $result_check_username = $conn->query($sql_check_username);
    if ($result_check_username->num_rows > 0) {
        $error_message = 'Username already exists. Please choose a different username.';
    }

    if (empty($error_message)) {
        $sql = "INSERT INTO users (username, password, is_admin, is_verified, notification, notification_type, timestamp) VALUES ('$username', '$password', 1, 0, 1, 'admin_approval', NOW())";
        if ($conn->query($sql) === TRUE) {
            $signup_success = true;
        } else {
            $error_message = 'Error: ' . $conn->error;
        }
    }
}

include '../../views/admin/admin_signup.php';
?>
