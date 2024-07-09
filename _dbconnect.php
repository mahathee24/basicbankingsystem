<?php
$server = "localhost";
$username = "root";
$password = ""; // Replace with your actual password if set
$database = "tsf_bank";
$port = 3306;

// Create connection
$conn = mysqli_connect($server, $username, $password, $database, $port);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}

// Close connection
mysqli_close($conn);
?>
