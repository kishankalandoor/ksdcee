<?php
// Test database connection and setup
require_once "dbconnection.php";

echo "<h2>KSDC Login System - Connection Test</h2>";

// Test database connection
if ($con) {
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
    
    // Check if table exists
    $result = mysqli_query($con, "SHOW TABLES LIKE 'tbl_login'");
    if(mysqli_num_rows($result) > 0) {
        echo "<p style='color: green;'>✅ Table 'tbl_login' exists!</p>";
        
        // Check if test user exists
        $check_user = mysqli_query($con, "SELECT username FROM tbl_login WHERE username = 'testuser'");
        if(mysqli_num_rows($check_user) > 0) {
            echo "<p style='color: green;'>✅ Test user 'testuser' exists!</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ Test user 'testuser' does not exist. You can create one through registration.</p>";
        }
        
        // Show all users (for testing)
        $all_users = mysqli_query($con, "SELECT id, username, useremail FROM tbl_login");
        if(mysqli_num_rows($all_users) > 0) {
            echo "<h3>Existing Users:</h3><ul>";
            while($row = mysqli_fetch_assoc($all_users)) {
                echo "<li>ID: " . $row['id'] . " | Username: " . $row['username'] . " | Email: " . $row['useremail'] . "</li>";
            }
            echo "</ul>";
        }
        
    } else {
        echo "<p style='color: red;'>❌ Table 'tbl_login' does not exist! Please run the setup_database.sql script.</p>";
    }
    
} else {
    echo "<p style='color: red;'>❌ Database connection failed!</p>";
    echo "<p>Error: " . mysqli_connect_error() . "</p>";
}

echo "<hr>";
echo "<p><a href='joinus.php'>Go to Login Page</a> | <a href='register.php'>Go to Registration Page</a></p>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>KSDC - Database Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { color: #333; }
        p { margin: 10px 0; }
        a { color: #007bff; text-decoration: none; margin-right: 20px; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
</body>
</html>
