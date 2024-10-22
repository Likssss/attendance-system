<?php
include '../../config/db.php';

$log_file = __DIR__ . '/forgot_password_log.txt'; // Ensure correct path

function log_message_forgot_password($message) {
    global $log_file;
    file_put_contents($log_file, $message . PHP_EOL, FILE_APPEND);
}

function log_all_emails() {
    global $conn;
    $result = $conn->query("SELECT email FROM users");
    if ($result) {
        log_message_forgot_password("Available emails in the database:");
        while ($row = $result->fetch_assoc()) {
            log_message_forgot_password($row['email']);
        }
    } else {
        log_message_forgot_password("Error retrieving emails: " . $conn->error);
    }
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    log_message_forgot_password("POST request received");

    $email = $_POST['email'];

    if (empty($email)) {
        log_message_forgot_password("Email field is empty");
        $message = "Please provide an email.";
    } else {
        log_all_emails(); // Log all emails before checking
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result === false) {
            log_message_forgot_password("SQL error: " . $conn->error);
            $message = "Database query error.";
        } elseif ($result->num_rows > 0) {
            log_message_forgot_password("Email found");

            $user = $result->fetch_assoc();
            $token = bin2hex(random_bytes(50));
            $token_expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

            $sql_token = "INSERT INTO password_resets (email, token, token_expiry) VALUES ('$email', '$token', '$token_expiry')";
            if ($conn->query($sql_token) === TRUE) {
                $reset_link = "http://localhost:3000/views/user/reset_password.php?token=$token";
                log_message_forgot_password("Reset link: $reset_link");
                // mail($email, "Password Reset Request", "Click the link to reset your password: $reset_link");
                $message = "A password reset link has been sent to your email.";
            } else {
                log_message_forgot_password("Error generating reset link: " . $conn->error);
                $message = "Error generating reset link: " . $conn->error;
            }
        } else {
            log_message_forgot_password("Email not found");
            $message = "Email not found in the system.";
        }
    }
}

include '../../views/user/forgot_password.php';
log_message_forgot_password("Message displayed to user: " . $message);
