<?php
include '../../config/db.php';

$log_file = __DIR__ . '/reset_password_log.txt'; // Ensure correct path

function log_message_reset_password($message) {
    global $log_file;
    file_put_contents($log_file, $message . PHP_EOL, FILE_APPEND);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    log_message_reset_password("POST request received");

    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "SELECT * FROM password_resets WHERE token='$token' AND token_expiry > NOW()";
    $result = $conn->query($sql);

    if ($result === false) {
        log_message_reset_password("SQL error: " . $conn->error);
        $message = "Database query error.";
    } elseif ($result->num_rows > 0) {
        log_message_reset_password("Token valid");

        $reset = $result->fetch_assoc();
        $email = $reset['email'];

        $sql_update = "UPDATE users SET password='$password' WHERE email='$email'";
        if ($conn->query($sql_update) === TRUE) {
            log_message_reset_password("Password updated successfully");

            $sql_delete = "DELETE FROM password_resets WHERE email='$email'";
            $conn->query($sql_delete);

            $message = "Password has been reset successfully.";
        } else {
            log_message_reset_password("Error resetting password: " . $conn->error);
            $message = "Error resetting password: " . $conn->error;
        }
    } else {
        log_message_reset_password("Invalid or expired token");
        $message = "Invalid or expired token.";
    }
}

include '../../views/user/reset_password.php';
log_message_reset_password("Message displayed to user: " . $message);
?>
