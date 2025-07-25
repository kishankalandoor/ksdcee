<?php
session_start();
header('Content-Type: application/json');

// Generate a random challenge for passkey authentication
$challenge = base64_encode(random_bytes(32));

// Store challenge in session for verification
$_SESSION['passkey_challenge'] = $challenge;

// Return WebAuthn authentication options
$options = [
    'success' => true,
    'challenge' => $challenge,
    'timeout' => 60000,
    'rpId' => $_SERVER['HTTP_HOST'],
    'allowCredentials' => [], // Could be populated with user's existing credentials
    'userVerification' => 'required'
];

echo json_encode($options);
?>
