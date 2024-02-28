<?php
require 'db.php'; // Your DB connection file

function getPlayers($type)
{
    global $conn;

    $class = null;
    switch ($type) {
        case 'attackers':
            $class = 1;
            break;
        case 'midfielders':
            $class = 2;
            break;
        case 'defenders':
            $class = 3;
            break;
        case 'goalkeepers':
            $class = 4;
            break;
    }

    $sql = "SELECT player.name, player.player_id, player.club_id, IFNULL(club.name, 'No Club') AS club_name, player.skill 
            FROM player 
            LEFT JOIN club ON player.club_id = club.club_id";

    if ($class !== null) {
        $sql .= " WHERE player.class = ?";
    }

    $sql .= " ORDER BY player.skill DESC";

    $stmt = $conn->prepare($sql);
    if ($class !== null) {
        $stmt->bind_param("i", $class);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $players = [];
    while ($row = $result->fetch_assoc()) {
        $row['skill'] = $row['skill'] / 500; // Conversion for points
        $players[] = $row;
    }

    echo json_encode($players); // Echo the JSON string
}

$type = $_GET['type'] ?? 'global';
getPlayers($type); // Call the function with the type
