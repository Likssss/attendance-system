<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header("Location: /controllers/admin/admin_profile.php");
    exit();
} elseif (isset($_SESSION['user_id'])) {
    header("Location: /controllers/user/profile.php");
    exit();
} else {
    header("Location: ../views/user/login.php");
    exit();
}
?>
