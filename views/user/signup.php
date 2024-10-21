<?php if (!isset($signup_success)) { $signup_success = false; } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sign Up</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <style>
        #popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        #popup button {
            margin: 5px;
        }
    </style>
    <script>
        function showPopup() {
            document.getElementById('popup').style.display = 'block';
        }
        function hidePopup() {
            document.getElementById('popup').style.display = 'none';
        }
        function redirectToLogin() {
            window.location.href = 'login.php';
        }
    </script>
</head>
<body>
    <h1>User Sign Up</h1>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>
        <label for="birthday">Birthday:</label>
        <input type="date" id="birthday" name="birthday" required>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
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
        <a href="../../views/admin/admin_signup.php">Admin Sign Up</a>
    </div>
    <script src="../../assets/js/scripts.js"></script>
</body>
</html>
