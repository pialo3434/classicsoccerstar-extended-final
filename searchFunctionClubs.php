<?php
require 'db.php'; // Your DB connection file

function searchClubs($searchTerm)
{
    global $conn;

    $sql = "SELECT club.club_id, club.name 
            FROM club 
            WHERE club.name LIKE ?
            ORDER BY club.name ASC"; // Order by club name

    $stmt = $conn->prepare($sql);
    $searchTerm = "%$searchTerm%";
    $stmt->bind_param("s", $searchTerm);

    $stmt->execute();
    $result = $stmt->get_result();

    $clubs = [];
    while ($row = $result->fetch_assoc()) {
        $clubs[] = $row;
    }

    echo json_encode($clubs); // Echo the JSON string
}

$searchTerm = $_GET['searchTerm'] ?? '';
searchClubs($searchTerm); // Call the function with the search term
