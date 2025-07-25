<?php
$host = 'localhost';         // usually localhost
$db_name = 'ksdc';   // change to your DB name
$user = 'root';     // DB username (e.g., root)
$pass = '';     // DB password (e.g., "" if using XAMPP)

$con = mysqli_connect($host, $user, $pass, $db_name);

 // if ($con->connect_error) {
   //   die("Connection failed: " . $con->connect_error);
 // }
 
 ?>
