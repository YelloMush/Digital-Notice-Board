<?php
$host = 'localhost';
$user = 'root';         // default for XAMPP
$password = '';         // default is empty in XAMPP
$database = 'notice_board';  // make sure this DB exists in phpMyAdmin

$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
