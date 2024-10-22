<?php
$log_file = __DIR__ . '/db_log.txt'; // Define log file path

function log_message($message) {
    global $log_file;
    file_put_contents($log_file, $message . PHP_EOL, FILE_APPEND);
}

$servername = "localhost";
$username = "root";
$password = "rootuser123";
$dbname = "attendance_system";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if database exists and create it if it doesn't
$db_check = $conn->query("SHOW DATABASES LIKE '$dbname'");
if ($db_check->num_rows == 0) {
    $sql = "CREATE DATABASE $dbname";
    if ($conn->query($sql) === TRUE) {
        log_message("Database created successfully");
    } else {
        die("Error creating database: " . $conn->error);
    }
}

// Select the database
$conn->select_db($dbname);

// Check if tables exist
$table_check = $conn->query("SHOW TABLES LIKE 'users'");
if ($table_check->num_rows == 0) {
    // Create tables
    $sql = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        is_admin TINYINT(1) DEFAULT 0,
        is_verified TINYINT(1) DEFAULT 0,
        notification TINYINT(1) DEFAULT 0,
        notification_type VARCHAR(50) DEFAULT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        name VARCHAR(100) DEFAULT NULL,
        age INT DEFAULT NULL,
        birthday DATE DEFAULT NULL,
        gender VARCHAR(10) DEFAULT NULL
    )";
    if ($conn->query($sql) === TRUE) {
        log_message("Table 'users' created successfully");
    } else {
        die("Error creating table: " . $conn->error);
    }

    $sql = "CREATE TABLE attendance (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        date DATE NOT NULL,
        status VARCHAR(10) NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    if ($conn->query($sql) === TRUE) {
        log_message("Table 'attendance' created successfully");
    } else {
        die("Error creating table: " . $conn->error);
    }

    $sql = "CREATE TABLE password_resets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        token VARCHAR(255) NOT NULL,
        token_expiry DATETIME NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    log_message("Executing query: $sql");
    if ($conn->query($sql) === TRUE) {
        log_message("Table 'password_resets' created successfully");
    } else {
        log_message("Error creating table 'password_resets': " . $conn->error);
        die("Error creating table: " . $conn->error);
    }
} else {
    // Modify the users table to include new columns if they don't exist
    $columns = [
        'username' => "VARCHAR(50) NOT NULL",
        'email' => "VARCHAR(255) NOT NULL",
        'password' => "VARCHAR(255) NOT NULL",
        'is_admin' => "TINYINT(1) DEFAULT 0",
        'is_verified' => "TINYINT(1) DEFAULT 0",
        'notification' => "TINYINT(1) DEFAULT 0",
        'notification_type' => "VARCHAR(50) DEFAULT NULL",
        'timestamp' => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
        'name' => "VARCHAR(100) DEFAULT NULL",
        'age' => "INT DEFAULT NULL",
        'birthday' => "DATE DEFAULT NULL",
        'gender' => "VARCHAR(10) DEFAULT NULL"
    ];
    foreach ($columns as $column => $definition) {
        $column_check = $conn->query("SHOW COLUMNS FROM users LIKE '$column'");
        if ($column_check->num_rows == 0) {
            $sql = "ALTER TABLE users ADD $column $definition";
            if ($conn->query($sql) === TRUE) {
                log_message("Column '$column' added to 'users' table successfully");
            } else {
                die("Error adding column '$column': " . $conn->error);
            }
        } else {
            // Alter existing column to allow NULL values
            $sql = "ALTER TABLE users MODIFY $column $definition";
            if ($conn->query($sql) === TRUE) {
                log_message("Column '$column' modified in 'users' table successfully");
            } else {
                die("Error modifying column '$column': " . $conn->error);
            }
        }
    }
    log_message("Database and tables already exist");
}

// Check if the default admin exists and insert if not
$admin_username = 'admin'; // Customize this if needed
$admin_password = 'admin'; // Customize this if needed
$admin_hash = password_hash($admin_password, PASSWORD_DEFAULT);
$admin_check = $conn->query("SELECT * FROM users WHERE username='$admin_username' AND is_admin=1");
if ($admin_check->num_rows == 0) {
    $sql = "INSERT INTO users (username, password, is_admin, is_verified, notification, notification_type, timestamp) VALUES ('$admin_username', '$admin_hash', 1, 1, 0, NULL, NULL)";
    if ($conn->query($sql) === TRUE) {
        log_message("Default admin account created successfully");
    } else {
        die("Error creating default admin account: " . $conn->error);
    }
} else {
    $admin = $admin_check->fetch_assoc();
    if ($admin['is_verified'] == 0) {
        $sql = "UPDATE users SET is_verified=1 WHERE username='$admin_username'";
        if ($conn->query($sql) === TRUE) {
            log_message("Default admin account verified successfully");
        } else {
            die("Error verifying default admin account: " . $conn->error);
        }
    } else {
        log_message("Default admin account already exists and is verified");
    }
}

log_message("Database setup complete");
?>
