<?php
function reset_rewards()
{
    // Import your database connection
    require './db.php';

    // Truncate the rewards table
    $conn->query("TRUNCATE TABLE rewards");

    // Get all users from the player table
    $stmt = $conn->prepare("SELECT player_id, skill, level FROM player");
    $stmt->execute();
    $result = $stmt->get_result();
    $players = $result->fetch_all(MYSQLI_ASSOC);

    // Define the rewards and their probabilities
    $rewards = array("stars" => 0.65, "coins" => 0.45);  // 65% chance for stars, 45% chance for coins

    // Map reward types to image file names
    $reward_images = array("stars" => "./assets/star_trophy.png", "coins" => "./assets/silver_trophy.png");

    // Define phrases for each reward type
    $reward_phrases = array(
        "stars" => array(
            "low" => array("A small constellation of", "A few stars twinkled into your account, totalling"),
            "medium" => array("A galaxy of", "A sparkling cluster of"),
            "high" => array("A supernova of", "An astronomical amount of")
        ),
        "coins" => array(
            "low" => array("A few coins clinked into your account, totalling", "A small handful of"),
            "medium" => array("A bag of", "A decent stash of"),
            "high" => array("A treasure chest bursting with", "A king's ransom of")
        )
    );

    // Get the current date
    $current_date = date('Y-m-d');

    // Get the day of the week (0 for Sunday, 1 for Monday, ..., 6 for Saturday)
    $day_of_week = date('w', strtotime($current_date));

    // Loop through each player
    foreach ($players as $player) {
        // Generate 7 random rewards for each player
        for ($day = 1; $day <= 7; $day++) {
            // Select a random reward type based on their probabilities
            $rand = mt_rand() / mt_getrandmax();  // generate a random number between 0 and 1
            $cumulative = 0.0;
            foreach ($rewards as $type => $probability) {
                $cumulative += $probability;
                if ($rand < $cumulative) {
                    $reward_type = $type;
                    break;
                }
            }

            // Calculate the reward value based on the player's skill level, level, and the reward type
            $reward_value = ($reward_type == "stars") ? mt_rand(15, 40) : round((($player['skill'] * mt_rand(2, 5)) + ($player['level'] * mt_rand(5, 10))) * 2.2);
            // random value between 15 and 40 for stars, (skill * random value between 2 and 5 + level * random value between 5 and 10) * level * 0.2 for coins

            // Determine the reward level based on the reward value
            $reward_level = ($reward_value < 30) ? "low" : (($reward_value < 60) ? "medium" : "high");


            // Get the image file name for the reward type
            $imgSrc = $reward_images[$reward_type];

            // Select a random phrase for the reward type and level
            $reward_phrase = $reward_phrases[$reward_type][$reward_level][array_rand($reward_phrases[$reward_type][$reward_level])];

            // Calculate the can_claim_at date based on the current date and the day of the reward
            $can_claim_at = date('Y-m-d', strtotime("$current_date +" . ($day - $day_of_week) . " day"));

            // Prepare the SQL statement
            $stmt = $conn->prepare("INSERT INTO rewards (day, reward_details, user_id, reward_type, reward_value, imgSrc, status, can_claim_at) VALUES (?, ?, ?, ?, ?, ?, 0, ?)");

            // Prepare the parameters
            if ($reward_type == "coins") {
                // If the reward type is coins, adjust the reward value to represent coins instead of silver
                $reward_value_display = $reward_value / 100; // Convert silver to coins
                $reward_details = "$reward_phrase $reward_value_display coins";
            } else {
                // For other reward types (e.g., stars), keep the reward value as is
                $reward_details = "$reward_phrase $reward_value $reward_type";
            }

            // Bind the parameters
            $stmt->bind_param("isssiss", $day, $reward_details, $player['player_id'], $reward_type, $reward_value, $imgSrc, $can_claim_at);

            // Execute the statement
            $stmt->execute();
        }
    }
    echo "reset_rewards function executed successfully";
}

// Call the function
reset_rewards();
