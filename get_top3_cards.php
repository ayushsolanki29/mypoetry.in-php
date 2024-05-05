<?php

include "auth/config.php";

// Your SQL query to fetch top3 cards
$top3_cards = "SELECT * FROM top3_cards";
$result = mysqli_query($con, $top3_cards);

$response = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
