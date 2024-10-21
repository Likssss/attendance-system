<?php
session_start();
include '../../config/db.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND is_admin=1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            header("Location: admin_profile.php");
            exit();
        } else {
            $error_message = 'Invalid password. Please try again.';
        }
    } else {
        $error_message = 'Invalid username. Please try again.';
    }
}

include '../../views/admin/admin_login.php';
?>
