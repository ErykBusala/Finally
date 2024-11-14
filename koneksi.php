<?php
$host = 'localhost';
$username = 'root'; // MySQL username
$password = ''; // Leave empty if the root user has no password
$database = 'finalp'; // Your new database
$port = 3308; // MySQL port

// Create connectionhg
$conn = new mysqli($host, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
