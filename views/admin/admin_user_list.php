<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
    <h1>Manage Users</h1>
    <table>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Age</th>
            <th>Birthday</th>
            <th>Gender</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['age']; ?></td>
            <td><?php echo $row['birthday']; ?></td>
            <td><?php echo $row['gender']; ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="delete_user_id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <script src="../../assets/js/scripts.js"></script>
</body>
</html>
