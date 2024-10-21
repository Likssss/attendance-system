<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <nav>
        <div class="hamburger" onclick="toggleMenu()">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <ul class="menu" id="menu">
            <li><a href="profile.php">Profile</a></li>
            <li><a href="../attendance/attendance.php">Attendance</a></li>
            <li><a href="../logout/logout.php">Logout</a></li>
        </ul>
    </nav>
    <h1>User Profile</h1>
    <p>Username: <?php echo $user['username']; ?></p>
    <p>Name: <?php echo $user['name']; ?></p>
    <p>Age: <?php echo $user['age']; ?></p>
    <p>Birthday: <?php echo $user['birthday']; ?></p>
    <p>Gender: <?php echo $user['gender']; ?></p>
    <script src="../../assets/js/scripts.js"></script>
</body>
</html>
