<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
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
            <li><a href="admin_profile.php">Profile</a></li>
            <li><a href="admin_manage.php">Manage Admins</a></li>
            <li><a href="admin_user_list.php">Manage Users</a></li>
            <li><a href="admin.php">Check All Attendance Records</a></li>
            <li><a href="../../controllers/logout/logout.php">Logout</a></li>
        </ul>

    </nav>
    <h1>Admin Profile</h1>
    <p>Username: <?php echo $admin['username']; ?></p>

    <h2>Notifications</h2>
    <?php if ($notif_result->num_rows > 0): ?>
        <ul>
            <?php while ($notif = $notif_result->fetch_assoc()): ?>
                <li>
                    New notification: 
                    <?php
                        if ($notif['notification_type'] == 'user_signup') {
                            echo "New user signed up at " . $notif['timestamp'];
                        } elseif ($notif['notification_type'] == 'admin_approval') {
                            echo "Admin approval request at " . $notif['timestamp'];
                        } elseif ($notif['notification_type'] == 'attendance_checked') {
                            $user_id = $notif['id'];
                            $user_sql = "SELECT username FROM users WHERE id='$user_id'";
                            $user_result = $conn->query($user_sql);
                            $user = $user_result->fetch_assoc();
                            echo $user['username'] . " checked for attendance at " . $notif['timestamp'];
                        } else {
                            echo "Unknown notification type";
                        }
                    ?>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No new notifications</p>
    <?php endif; ?>

    <script src="../../assets/js/scripts.js"></script>
</body>
</html>
