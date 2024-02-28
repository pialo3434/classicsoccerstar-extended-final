<?php
$servername = "server.server.pt";
$username = "user";
$password = "pass";
$dbname = "db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    //echo "Successfully connected to the database.";
}

return $conn;
