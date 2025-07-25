<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "dbconnection.php";

header('Content-Type: application/json');

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['email'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    exit;
}

$email = $input['email'];
$name = $input['name'] ?? '';
$google_id = $input['google_id'] ?? '';

try {
    // Check if user already exists
    $check_user = mysqli_prepare($con, "SELECT id, username, useremail FROM tbl_login WHERE useremail = ?");
    mysqli_stmt_bind_param($check_user, "s", $email);
    mysqli_stmt_execute($check_user);
    $result = mysqli_stmt_get_result($check_user);
    
    if (mysqli_num_rows($result) > 0) {
        // User exists, log them in
        $user = mysqli_fetch_assoc($result);
        
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $user['id'];
        $_SESSION["username"] = $user['username'];
        $_SESSION["email"] = $user['useremail'];
        
        echo json_encode(['success' => true, 'message' => 'Login successful']);
    } else {
        // Create new user account
        $username = $email; // Set username equal to email
        $hashedPass = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT); // Generate random password
        
        $insert_query = mysqli_prepare($con, "INSERT INTO tbl_login (username, useremail, pass, google_id, auth_provider) VALUES (?, ?, ?, ?, 'google')");
        
        if ($insert_query) {
            mysqli_stmt_bind_param($insert_query, "ssss", $username, $email, $hashedPass, $google_id);
            
            if (mysqli_stmt_execute($insert_query)) {
                $user_id = mysqli_insert_id($con);
                
                // Log in the new user
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $user_id;
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;
                
                echo json_encode(['success' => true, 'message' => 'Account created and logged in successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create account']);
            }
            mysqli_stmt_close($insert_query);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    }
    
    mysqli_stmt_close($check_user);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}

mysqli_close($con);
?>
