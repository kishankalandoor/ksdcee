<?php
// Test login functionality
require_once "dbconnection.php";

echo "<h2>KSDC Login Test</h2>";

if ($con) {
    echo "<p style='color: green;'>✅ Database connected!</p>";
    
    // Test if we can fetch user data
    $test_username = "demo";
    $sql = "SELECT id, username, pass FROM tbl_login WHERE username = ?";
    
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("s", $test_username);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                echo "<p style='color: green;'>✅ User 'demo' found in database!</p>";
                echo "<p>User ID: " . $row['id'] . "</p>";
                echo "<p>Username: " . $row['username'] . "</p>";
                echo "<p>Password hash length: " . strlen($row['pass']) . " characters</p>";
                echo "<p>Password starts with: " . substr($row['pass'], 0, 10) . "...</p>";
                
                // Test password verification with a sample password
                $test_passwords = ['demo', 'password', '123456', 'demo123'];
                echo "<h3>Testing common passwords:</h3>";
                foreach($test_passwords as $test_pass) {
                    if (password_verify($test_pass, $row['pass'])) {
                        echo "<p style='color: green;'>✅ Password '$test_pass' matches!</p>";
                    } else {
                        echo "<p style='color: red;'>❌ Password '$test_pass' does not match.</p>";
                    }
                }
                
            } else {
                echo "<p style='color: red;'>❌ User not found!</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ Query execution failed!</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color: red;'>❌ Query preparation failed!</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Database connection failed!</p>";
}

echo "<hr>";
echo "<p><a href='joinus.php'>Go to Login Page</a></p>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>KSDC - Login Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { color: #333; }
        p { margin: 10px 0; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
</body>
</html>
