<?php
require 'db.php'; // Your DB connection file
session_start(); // Start the session

function invitePlayer($receiverId)
{
    global $conn;

    // Check if the logged-in user is a club owner
    $sql = "SELECT club_rank, club_id, last_message_date, attempts_to_send FROM player WHERE player_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['club_rank'] != 1) {
        echo "You are not a club owner.";
        return;
    }

    // Check if the player has sent a message in the last minute
    if ($row['last_message_date'] != NULL) {
        $lastMessageDate = new DateTime($row['last_message_date']);
        $now = new DateTime();
        if ($lastMessageDate->diff($now)->i < 1) {
            echo "You must wait 1 minute between each message.";
            return;
        }
    }

    // Check if the player has reached the limit of 10 messages
    if ($row['attempts_to_send'] >= 10) {
        echo "You have reached your limit of 10 messages.";
        return;
    }

    // Get the club name
    $sql = "SELECT name FROM club WHERE club_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $row['club_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $club = $result->fetch_assoc();

    // Send the invite
    $sql = "INSERT INTO message (sender, reciver, type, subject, message, send_date, readed) VALUES (?, ?, 2, ?, ?, NOW(), 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $_SESSION['user_id'], $receiverId, $club['name'], $club['name']);
    $stmt->execute();

    // Update the last_message_date and attempts_to_send fields
    $sql = "UPDATE player SET last_message_date = NOW(), attempts_to_send = attempts_to_send + 1 WHERE player_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();

    echo "Invite sent.";
}

$receiverId = $_GET['receiverId'] ?? '';
invitePlayer($receiverId); // Call the function with the receiver's ID
