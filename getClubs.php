<?php
require 'db.php'; // Your DB connection file

function getClubs()
{
    global $conn;

    $sql = "SELECT club.club_id, club.name 
            FROM club 
            ORDER BY club.name ASC"; // Order by club name

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $clubs = [];
    $rank = 1;
    while ($row = $result->fetch_assoc()) {
        $row['rank'] = $rank; // Add the rank to the row data
        $clubs[] = $row;
        $rank++;
    }

    echo json_encode($clubs); // Echo the JSON string
}

getClubs(); // Call the function
