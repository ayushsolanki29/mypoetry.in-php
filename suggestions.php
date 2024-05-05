<?php
include "auth/config.php";

if(isset($_POST['query'])){
    $query = $_POST['query'];

    // Perform database query to fetch suggestions based on $query
    // Assuming 'title' is the column you want to match against in category_card table
    $sql = "SELECT title FROM category_card WHERE title LIKE '%$query%'";
    $result = mysqli_query($con, $sql);

    $suggestions = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions[] = $row['title'];
    }
    
    // Output suggestions as list items if suggestions are found
    if (!empty($suggestions)) {
        foreach($suggestions as $suggestion){
            echo '<div class="suggestion-item"><li> <a class="text-dark" href="poetry-details.php?category=' . urlencode($suggestion) . '">' . $suggestion . '</a></li></div>';
        }
    }else{
        echo '<div class="suggestion-item"><li style="background-color:#fff;cursor:pointer:none;">No results found</li> <li><a class="text-dark" href="poetry-details.php?category=*">Check category Page</li></div>';
    
    }
}
?>
