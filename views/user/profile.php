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
            <li><a href="../../controllers/logout/logout.php">Logout</a></li>
        </ul>
    </nav>
    <h1>User Profile</h1>

    <?php if (!empty($success_message)): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <!-- Display mode -->
    <div id="profile-display">
        <p>Username: <?php echo $user['username']; ?></p>
        <p>Name: <?php echo $user['name']; ?></p>
        <p>Age: <?php echo $user['age']; ?></p>
        <p>Birthday: <?php echo $user['birthday']; ?></p>
        <p>Gender: <?php echo $user['gender']; ?></p>
        <button onclick="toggleEdit(true)">Edit Profile</button>
    </div>

    <!-- Edit mode -->
    <div id="profile-edit" style="display:none;">
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo $user['age']; ?>" required>
            <label for="birthday">Birthday:</label>
            <input type="date" id="birthday" name="birthday" value="<?php echo $user['birthday']; ?>" required onchange="calculateAge()">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php if ($user['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($user['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if ($user['gender'] == 'Other') echo 'selected'; ?>>Other</option>
            </select>
            <button type="submit">Save</button>
            <button type="button" onclick="toggleEdit(false)">Cancel</button>
        </form>
    </div>

    <script src="../../assets/js/scripts.js"></script>
    <script>
        function toggleEdit(editMode) {
            document.getElementById('profile-display').style.display = editMode ? 'none' : 'block';
            document.getElementById('profile-edit').style.display = editMode ? 'block' : 'none';
        }

        function calculateAge() {
            const birthday = new Date(document.getElementById('birthday').value);
            const today = new Date();
            let age = today.getFullYear() - birthday.getFullYear();
            const monthDiff = today.getMonth() - birthday.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthday.getDate())) {
                age--;
            }
            document.getElementById('age').value = age;
        }
    </script>
</body>
</html>
