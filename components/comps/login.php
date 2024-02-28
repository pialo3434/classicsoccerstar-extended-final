<?php
session_start(); // Start the session at the beginning of your script

require '../../db.php'; // This will include db.php file and create a new database connection
require '../../reset_rewards_for_player.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Hash the input password
$hashed_password = hash('sha256', md5($password));

$sql = "SELECT * FROM player WHERE name = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $username, $hashed_password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['loggedin'] = true; // Set a session variable when the user logs in successfully
    $_SESSION['user_id'] = $user['player_id']; // Store the user's ID in the session

    reset_rewards_for_player($user['player_id']); // Call the function after a successful login
    echo 'success';
} else {
    echo 'Invalid credentials. ';
}

$conn->close(); // Close the connection
