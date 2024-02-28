<?php
session_start(); // Start the session at the beginning of your script

require '../../db.php'; // This will include db.php file and create a new database connection

if (!isset($_SESSION['user_id'])) {
    echo json_encode(array('error' => 'User is not logged in.'));
    exit;
}

$user_id = $_SESSION['user_id']; // Get the user_id from the session
$reward_id = $_POST['reward_id']; // Get the reward_id from the POST data

$sql = "SELECT * FROM rewards WHERE id = ? AND user_id = ?"; // SQL query to get the reward
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $reward_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $reward = $result->fetch_assoc();

    $now = new DateTime(); // Get the current date and time
    $can_claim_at = new DateTime($reward['can_claim_at']); // Get the can_claim_at date

    if ($can_claim_at > $now) {
        echo json_encode(array('error' => 'Reward is not available yet. Please wait until the defined day...'));
        exit;
    }

    if ($reward['status'] == 0) { // Check if the reward has not been claimed yet
        $sql = "UPDATE rewards SET claim_date = NOW(), status = 1, next_claim = DATE_ADD(NOW(), INTERVAL 1 DAY) WHERE id = ? AND user_id = ?"; // SQL query to update the reward
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $reward_id, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            if ($reward['reward_type'] == 'stars') {
                addStars($user_id, $reward['reward_value']);
            } elseif ($reward['reward_type'] == 'coins') {
                addCoins($user_id, $reward['reward_value']);
            }

            echo json_encode(array('success' => 'Reward claimed successfully.'));
        } else {
            echo json_encode(array('error' => 'Failed to claim reward.'));
        }
    } else {
        echo json_encode(array('error' => 'Reward has already been claimed.'));
    }
} else {
    echo json_encode(array('error' => 'Reward not found.'));
}

$conn->close(); // Close the connection

function addStars($userId, $stars)
{
    global $conn; // Use the $conn object from the global scope

    // SQL query to update the user's star count
    $sql = "UPDATE player SET stars = stars + ? WHERE player_id = ?";

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $stars, $userId);
    $stmt->execute();
}

function addCoins($userId, $coins)
{
    global $conn; // Use the $conn object from the global scope

    // SQL query to update the user's coin count
    $sql = "UPDATE player SET silver = silver + ? WHERE player_id = ?";

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $coins, $userId);
    $stmt->execute();
}
