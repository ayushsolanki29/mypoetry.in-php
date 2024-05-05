<?php
$username = "root";
$password = "";
$server = 'localhost';
$db = "mypoerty_main";
$domain = "http://localhost/frontend-mypoerty";

// $username = "mypoetry_dreamcreation";
// $password = 'h?b{6E@m$z78';
// $server = 'localhost';
// $db = "mypoetry_main";
// $domain = "https://mypoetry.in";

$con  = mysqli_connect($server,$username,$password,$db);

if (!$con) {
    echo "Connection unsuccessful";
    die("Not Connected " . mysqli_connect_error());
} 

if (!isset($_COOKIE['viewed'])) {
    // Update database and set cookie
    $sql = "UPDATE settings SET `data-value` = `data-value` + 1 WHERE id = 1";
    $con->query($sql);

    setcookie('viewed', '1', time() + (5 * 24 * 60 * 60));
}


?>