<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <h1>User Login</h1>
    <form method="POST" action="../../controllers/user/login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
    </form>
    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <div>
        <a href="../../views/user/signup.php">User Sign Up</a> | 
        <a href="../../views/admin/admin_signup.php">Admin Sign Up</a> | 
        <a href="../../views/admin/admin_login.php">Admin Login</a> | 
        <a href="../../views/user/forgot_password.php">Forgot Password</a>
    </div>
</body>
</html>
