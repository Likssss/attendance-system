<?php
include '../../config/db.php';
$signup_success = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Use the date input type to ensure YYYY-MM-DD format
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)) {
        // Check if the username already exists
        $sql_check_username = "SELECT * FROM users WHERE username='$username'";
        $result_check_username = $conn->query($sql_check_username);
        if ($result_check_username->num_rows > 0) {
            $error_message = 'Username already exists. Please choose a different username.';
        }

        if (empty($error_message)) {
            $sql = "INSERT INTO users (name, age, birthday, gender, username, password, is_admin, is_verified, notification, notification_type, timestamp) VALUES ('$name', '$age', '$birthday', '$gender', '$username', '$password', 0, 1, 1, 'user_signup', NOW())";
            if ($conn->query($sql) === TRUE) {
                $signup_success = true;
            } else {
                $error_message = 'Error: ' . $conn->error;
            }
        }
    } else {
        $error_message = 'Invalid birthday format. Please use the calendar to select a date.';
    }
}

include '../../views/user/signup.php';
?>
