<?php
session_start();
include('dbconnection.php');

// GitHub OAuth callback handler
if (isset($_GET['code']) && !isset($_GET['error'])) {
    $code = $_GET['code'];
    
    // GitHub OAuth credentials (you need to set these up)
    $client_id = 'YOUR_GITHUB_CLIENT_ID';
    $client_secret = 'YOUR_GITHUB_CLIENT_SECRET';
    $redirect_uri = 'http://localhost/ksdc22/github-callback.php';
    
    // Exchange code for access token
    $token_url = 'https://github.com/login/oauth/access_token';
    $token_data = array(
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $code,
        'redirect_uri' => $redirect_uri
    );
    
    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\nAccept: application/json\r\n",
            'method' => 'POST',
            'content' => http_build_query($token_data)
        )
    );
    
    $context = stream_context_create($options);
    $token_response = file_get_contents($token_url, false, $context);
    $token_data = json_decode($token_response, true);
    
    if (isset($token_data['access_token'])) {
        // Get user information from GitHub
        $user_url = 'https://api.github.com/user';
        $user_options = array(
            'http' => array(
                'header' => "Authorization: token " . $token_data['access_token'] . "\r\nUser-Agent: KSDC-App\r\n"
            )
        );
        
        $user_context = stream_context_create($user_options);
        $user_response = file_get_contents($user_url, false, $user_context);
        $user_data = json_decode($user_response, true);
        
        // Get user email (if not public, fetch from emails endpoint)
        $email_url = 'https://api.github.com/user/emails';
        $email_context = stream_context_create($user_options);
        $email_response = file_get_contents($email_url, false, $email_context);
        $email_data = json_decode($email_response, true);
        
        $primary_email = '';
        foreach ($email_data as $email) {
            if ($email['primary']) {
                $primary_email = $email['email'];
                break;
            }
        }
        
        if (empty($primary_email) && !empty($user_data['email'])) {
            $primary_email = $user_data['email'];
        }
        
        if (!empty($primary_email)) {
            // Check if user already exists
            $check_user = mysqli_prepare($con, "SELECT * FROM tbl_login WHERE useremail = ?");
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
                header("location: welcome.php");
                exit;
            } else {
                // Create new user account
                $username = $user_data['login'] ?? $user_data['name'] ?? explode('@', $primary_email)[0];
                $github_id = $user_data['id'];
                
                // Generate a random password (user can change it later)
                $random_password = bin2hex(random_bytes(16));
                $hashed_password = password_hash($random_password, PASSWORD_DEFAULT);
                
                $insert_query = mysqli_prepare($con, "INSERT INTO tbl_login (username, useremail, pass, github_id, oauth_provider) VALUES (?, ?, ?, ?, 'github')");
                mysqli_stmt_bind_param($insert_query, "sssi", $username, $primary_email, $hashed_password, $github_id);
                
                if (mysqli_stmt_execute($insert_query)) {
                    $user_id = mysqli_insert_id($con);
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $user_id;
                    $_SESSION["username"] = $username;
                    $_SESSION["email"] = $primary_email;
                    $_SESSION["oauth_login"] = true;
                    header("location: welcome.php");
                    exit;
                } else {
                    $error = "Failed to create account. Please try again.";
                }
                mysqli_stmt_close($insert_query);
            }
            mysqli_stmt_close($check_user);
        } else {
            $error = "Could not retrieve email from GitHub. Please try again.";
        }
    } else {
        $error = "GitHub authentication failed. Please try again.";
    }
} else {
    $error = "GitHub authentication was cancelled or failed.";
}

// If there's an error, redirect back to registration page
if (isset($error)) {
    session_start();
    $_SESSION['oauth_error'] = $error;
    header("location: register.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GitHub Authentication - KSDC</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <h5 class="mt-3">Processing GitHub Authentication...</h5>
                        <p class="text-muted">Please wait while we verify your GitHub account.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
