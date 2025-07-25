<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "dbconnection.php";

// GitHub OAuth configuration
$client_id = 'YOUR_GITHUB_CLIENT_ID';
$client_secret = 'YOUR_GITHUB_CLIENT_SECRET';
$redirect_uri = 'https://yourdomain.com/ksdc22/github-login-callback.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    
    // Exchange code for access token
    $token_url = 'https://github.com/login/oauth/access_token';
    $token_data = [
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $code,
        'redirect_uri' => $redirect_uri
    ];
    
    $options = [
        'http' => [
            'header' => [
                "Content-type: application/x-www-form-urlencoded\r\n",
                "Accept: application/json\r\n",
                "User-Agent: KSDC-App\r\n"
            ],
            'method' => 'POST',
            'content' => http_build_query($token_data)
        ]
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($token_url, false, $context);
    $token_info = json_decode($result, true);
    
    if (isset($token_info['access_token'])) {
        $access_token = $token_info['access_token'];
        
        // Get user information
        $user_url = 'https://api.github.com/user';
        $user_options = [
            'http' => [
                'header' => [
                    "Authorization: token $access_token\r\n",
                    "User-Agent: KSDC-App\r\n"
                ]
            ]
        ];
        
        $user_context = stream_context_create($user_options);
        $user_result = file_get_contents($user_url, false, $user_context);
        $user_info = json_decode($user_result, true);
        
        // Get user email
        $email_url = 'https://api.github.com/user/emails';
        $email_result = file_get_contents($email_url, false, $user_context);
        $emails = json_decode($email_result, true);
        
        $primary_email = '';
        foreach ($emails as $email) {
            if ($email['primary']) {
                $primary_email = $email['email'];
                break;
            }
        }
        
        if ($primary_email && isset($user_info['login'])) {
            try {
                // Check if user already exists
                $check_user = mysqli_prepare($con, "SELECT id, username, useremail FROM tbl_login WHERE useremail = ?");
                mysqli_stmt_bind_param($check_user, "s", $primary_email);
                mysqli_stmt_execute($check_user);
                $result = mysqli_stmt_get_result($check_user);
                
                if (mysqli_num_rows($result) > 0) {
                    // User exists, log them in
                    $user = mysqli_fetch_assoc($result);
                    
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $user['id'];
                    $_SESSION["username"] = $user['username'];
                    $_SESSION["email"] = $user['useremail'];
                    
                    header("Location: welcome.php");
                    exit;
                } else {
                    // Create new user account
                    $username = $primary_email; // Set username equal to email
                    $hashedPass = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT); // Generate random password
                    $github_id = $user_info['id'];
                    
                    $insert_query = mysqli_prepare($con, "INSERT INTO tbl_login (username, useremail, pass, github_id, auth_provider) VALUES (?, ?, ?, ?, 'github')");
                    
                    if ($insert_query) {
                        mysqli_stmt_bind_param($insert_query, "ssss", $username, $primary_email, $hashedPass, $github_id);
                        
                        if (mysqli_stmt_execute($insert_query)) {
                            $user_id = mysqli_insert_id($con);
                            
                            // Log in the new user
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $user_id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $primary_email;
                            
                            header("Location: welcome.php");
                            exit;
                        } else {
                            $error = "Failed to create account.";
                        }
                        mysqli_stmt_close($insert_query);
                    } else {
                        $error = "Database error.";
                    }
                }
                
                mysqli_stmt_close($check_user);
            } catch (Exception $e) {
                $error = "Server error: " . $e->getMessage();
            }
        } else {
            $error = "Failed to get user information from GitHub.";
        }
    } else {
        $error = "Failed to get access token from GitHub.";
    }
} else if (isset($_GET['error'])) {
    $error = "GitHub OAuth error: " . $_GET['error_description'];
} else {
    $error = "Invalid request.";
}

// If we reach here, there was an error
if (isset($error)) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Login Error</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 50px; }
            .error { color: red; background: #ffe6e6; padding: 20px; border-radius: 5px; }
            .retry { margin-top: 20px; }
            .retry a { color: #007bff; text-decoration: none; }
        </style>
    </head>
    <body>
        <div class='error'>
            <h3>Login Failed</h3>
            <p>$error</p>
        </div>
        <div class='retry'>
            <a href='joinus.php'>← Try Again</a>
        </div>
    </body>
    </html>";
}

mysqli_close($con);
?>
