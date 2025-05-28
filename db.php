<?php
$host = 'localhost';
$user = 'root';
$pass = 'root';  
$db   = 'contact_manager';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
