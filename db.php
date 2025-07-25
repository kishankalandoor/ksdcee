<?php
$host = 'localhost';         // usually localhost
$dbname = 'ksdc';   // change to your DB name
$user = 'root';     // DB username (e.g., root)
$pass = '';     // DB password (e.g., "" if using XAMPP)

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
