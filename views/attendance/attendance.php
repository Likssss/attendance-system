<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
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
            <li><a href="../user/profile.php">Profile</a></li>
            <li><a href="../attendance/attendance.php">Attendance</a></li>
            <li><a href="../logout/logout.php">Logout</a></li>
        </ul>
    </nav>
    <h1>Attendance</h1>
    <button onclick="checkAttendance()">Check Attendance</button>
    <h2>Past Attendances</h2>
    <table id="attendance-table">
        <tr>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['status']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <script src="../../assets/js/scripts.js"></script>
    <script>
        function updateAttendanceTable(date) {
            const table = document.getElementById('attendance-table');
            const newRow = document.createElement('tr');
            const dateCell = document.createElement('td');
            const statusCell = document.createElement('td');
            dateCell.textContent = date;
            statusCell.textContent = 'Present';
            newRow.appendChild(dateCell);
            newRow.appendChild(statusCell);
            table.appendChild(newRow);
        }

        function checkAttendance() {
            fetch('../../controllers/attendance/attendance.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams()
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    updateAttendanceTable(data.date);
                } else {
                    console.error(data.message); // Debugging information
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>
