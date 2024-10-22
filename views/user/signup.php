<?php if (!isset($signup_success)) { $signup_success = false; } ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sign Up</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <h1>User Sign Up</h1>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Sign Up</button>
    </form>
    <?php if ($signup_success): ?>
        <p style="color: green;">Account created successfully. Please login.</p>
    <?php elseif (!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <div>
        <a href="../../views/user/login.php">User Login</a> | 
        <a href="../../views/admin/admin_signup.php">Admin Sign Up</a> | 
        <a href="../../views/admin/admin_login.php">Admin Login</a>
    </div>
</body>
</html>
