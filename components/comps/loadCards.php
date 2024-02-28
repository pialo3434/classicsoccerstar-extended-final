<?php
session_start(); // Start the session at the beginning of your script

require '../../db.php'; // This will include db.php file and create a new database connection

$user_id = $_SESSION['user_id']; // Get the user_id from the session

$sql = "SELECT * FROM rewards WHERE user_id = ? ORDER BY day ASC"; // SQL query to get all rewards for the logged-in user
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query failed: " . $conn->error); // Print an error message if the query fails
}

$cards = array(); // Array to hold the cards

while ($row = $result->fetch_assoc()) {
    $card = array(
        'day' => $row['day'],
        'rewardType' => $row['reward_type'],
        'rewardValue' => $row['reward_value'],
        'imgSrc' => $row['imgSrc'],
        'reward' => $row['reward_details'],
        'reward_id' => $row['id'], // Add the reward_id to the card array
        'isClaimed' => $row['status'] == 1, // Add the claim status to the card array
        'can_claim_at' => $row['can_claim_at'] // Add the can_claim_at date to the card array
    );

    array_push($cards, $card); // Add the card to the cards array
}


$json = json_encode($cards); // Encode the cards array as JSON

echo $json;

$conn->close(); // Close the connection
