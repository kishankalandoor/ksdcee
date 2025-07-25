<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "dbconnection.php";

header('Content-Type: application/json');

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    exit;
}

// Verify challenge (basic implementation)
if (!isset($_SESSION['passkey_challenge'])) {
    echo json_encode(['success' => false, 'message' => 'No challenge found in session']);
    exit;
}

$credential_id = $input['id'];
$authenticator_data = $input['response']['authenticatorData'];
$client_data_json = $input['response']['clientDataJSON'];
$signature = $input['response']['signature'];

try {
    // In a production system, you would:
    // 1. Verify the signature using the stored public key
    // 2. Validate the authenticator data
    // 3. Check the client data JSON
    
    // For this demo, we'll do a basic lookup
    $check_credential = mysqli_prepare($con, "SELECT user_id FROM user_passkeys WHERE credential_id = ?");
    
    if ($check_credential) {
        mysqli_stmt_bind_param($check_credential, "s", $credential_id);
        mysqli_stmt_execute($check_credential);
        $result = mysqli_stmt_get_result($check_credential);
        
        if (mysqli_num_rows($result) > 0) {
            $credential = mysqli_fetch_assoc($result);
            $user_id = $credential['user_id'];
            
            // Get user information
            $get_user = mysqli_prepare($con, "SELECT id, username, useremail FROM tbl_login WHERE id = ?");
            mysqli_stmt_bind_param($get_user, "i", $user_id);
            mysqli_stmt_execute($get_user);
            $user_result = mysqli_stmt_get_result($get_user);
            
            if (mysqli_num_rows($user_result) > 0) {
                $user = mysqli_fetch_assoc($user_result);
                
                // Log in the user
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $user['id'];
                $_SESSION["username"] = $user['username'];
                $_SESSION["email"] = $user['useremail'];
                
                // Clear the challenge
                unset($_SESSION['passkey_challenge']);
                
                echo json_encode(['success' => true, 'message' => 'Passkey login successful']);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found']);
            }
            
            mysqli_stmt_close($get_user);
        } else {
            echo json_encode(['success' => false, 'message' => 'Passkey not recognized']);
        }
        
        mysqli_stmt_close($check_credential);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}

mysqli_close($con);
?>
