<?php
// Test Registration and Login Flow
include("dbconnection.php");

echo "<h2>KSDC Registration & Login Test</h2>";

if (!$con) {
    die("Database connection failed!");
}

echo "<div style='margin-bottom: 20px;'>";
echo "<h3>Current Database Status</h3>";

// Check table structure
$result = mysqli_query($con, "DESCRIBE tbl_login");
if ($result) {
    echo "<h4>Table Structure:</h4><ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li><strong>" . $row['Field'] . "</strong> - " . $row['Type'] . "</li>";
    }
    echo "</ul>";
}

// Show all users
$users_result = mysqli_query($con, "SELECT id, username, useremail, created_at FROM tbl_login ORDER BY created_at DESC");
if ($users_result && mysqli_num_rows($users_result) > 0) {
    echo "<h4>Registered Users:</h4>";
    echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Created At</th><th>Actions</th></tr>";
    while($row = mysqli_fetch_assoc($users_result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['useremail'] . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "<td><a href='?test_login=" . $row['username'] . "'>Test Login</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p><em>No users registered yet.</em></p>";
}

echo "</div>";

// Test login functionality
if (isset($_GET['test_login'])) {
    $test_username = $_GET['test_login'];
    echo "<h3>Testing Login for: " . htmlspecialchars($test_username) . "</h3>";
    
    // Get user data
    $stmt = mysqli_prepare($con, "SELECT id, username, useremail, pass FROM tbl_login WHERE username = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $test_username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            echo "<p><strong>User found:</strong></p>";
            echo "<ul>";
            echo "<li>ID: " . $row['id'] . "</li>";
            echo "<li>Username: " . $row['username'] . "</li>";
            echo "<li>Email: " . $row['useremail'] . "</li>";
            echo "<li>Password Hash: " . substr($row['pass'], 0, 20) . "... (truncated)</li>";
            echo "</ul>";
            
            // Test password verification
            echo "<form method='post'>";
            echo "<input type='hidden' name='test_user_id' value='" . $row['id'] . "'>";
            echo "<label>Test Password: <input type='password' name='test_password' placeholder='Enter password'></label>";
            echo "<button type='submit' name='verify_password'>Verify Password</button>";
            echo "</form>";
        } else {
            echo "<p style='color: red;'>User not found!</p>";
        }
        mysqli_stmt_close($stmt);
    }
}

// Handle password verification test
if (isset($_POST['verify_password'])) {
    $test_user_id = $_POST['test_user_id'];
    $test_password = $_POST['test_password'];
    
    $stmt = mysqli_prepare($con, "SELECT username, pass FROM tbl_login WHERE id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $test_user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $stored_hash = $row['pass'];
            
            echo "<h4>Password Verification Result for " . htmlspecialchars($row['username']) . ":</h4>";
            
            if (password_verify($test_password, $stored_hash)) {
                echo "<p style='color: green;'>✅ Password verification SUCCESSFUL!</p>";
            } else {
                echo "<p style='color: red;'>❌ Password verification FAILED!</p>";
                echo "<p><em>Note: If this is an old password, it might not be hashed. Checking plain text...</em></p>";
                if ($test_password === $stored_hash) {
                    echo "<p style='color: orange;'>⚠️ Plain text password match (insecure)</p>";
                } else {
                    echo "<p style='color: red;'>❌ No match with plain text either</p>";
                }
            }
        }
        mysqli_stmt_close($stmt);
    }
}

echo "<hr>";
echo "<h3>Quick Actions</h3>";
echo "<p><a href='register.php' target='_blank'>📝 Test Registration</a></p>";
echo "<p><a href='joinus.php' target='_blank'>🔐 Test Login</a></p>";
echo "<p><a href='welcome.php' target='_blank'>🏠 Dashboard (requires login)</a></p>";
echo "<p><a href='test_connection.php' target='_blank'>🔧 Connection Test</a></p>";

// Clean up test data option
echo "<hr>";
echo "<h3>⚠️ Admin Actions</h3>";
echo "<form method='post' onsubmit='return confirm(\"Are you sure you want to delete all test users?\");'>";
echo "<button type='submit' name='clean_test_data' style='background: #dc3545; color: white; border: none; padding: 8px 16px; border-radius: 4px;'>Clear All Test Users</button>";
echo "</form>";

if (isset($_POST['clean_test_data'])) {
    $delete_query = "DELETE FROM tbl_login WHERE username LIKE 'test%' OR useremail LIKE 'test%'";
    if (mysqli_query($con, $delete_query)) {
        echo "<p style='color: green;'>Test users cleared successfully!</p>";
        echo "<script>setTimeout(function(){ location.reload(); }, 1000);</script>";
    } else {
        echo "<p style='color: red;'>Error clearing test users: " . mysqli_error($con) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>KSDC - Registration & Login Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; }
        th, td { text-align: left; padding: 8px; }
        th { background-color: #f2f2f2; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
    </style>
</head>
<body>
</body>
</html>
