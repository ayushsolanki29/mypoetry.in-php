<?php
include 'php/config.php';
$txt_id = $_POST['txt_id'];

// SQL query to fetch autocomplete suggestions
$sql = "SELECT DISTINCT txt_id FROM `payment-details` WHERE txt_id LIKE '$txt_id%'";
$result = $con->query($sql);

// Process and display the autocomplete suggestions
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Output each suggestion as a clickable item
        echo "<div class='suggestion' onclick='selectSuggestion(\"" . $row["txt_id"] . "\")'>" . $row["txt_id"] . "</div>";
    }
} else {
    echo "No suggestions found.";
}

$con->close();
?>
