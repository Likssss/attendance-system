<?php if (!isset($signup_success)) { $signup_success = false; } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign Up</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <h1>Admin Sign Up</h1>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Sign Up</button>
    </form>
    <?php if ($signup_success): ?>
        <div id="popup">
            <p>Account created successfully. Would you like to login?</p>
            <button onclick="redirectToLogin()">Yes</button>
            <button onclick="hidePopup()">No</button>
        </div>
        <script>
            showPopup();
        </script>
    <?php elseif (!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <div>
        <a href="../../views/user/login.php">User Login</a> | 
        <a href="../../views/admin/admin_login.php">Admin Login</a> | 
        <a href="../../views/user/signup.php">User Sign Up</a>
    </div>
    <script src="../../assets/js/scripts.js"></script>
</body>
</html>
