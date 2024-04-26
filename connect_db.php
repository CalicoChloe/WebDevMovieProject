<?php
// Database credentials
$servername = "localhost";
$username = "guest";
$password = "cin3ph!le";
$database = "movies";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
