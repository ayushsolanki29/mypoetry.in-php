<?php
$username = "root";
$password = "";
$server = 'localhost';
$db = "mypoerty_main";
$domain = "http://localhost/frontend-mypoerty/";

// $username = "mypoetry_dreamcreation";
// $password = 'h?b{6E@m$z78';
// $server = 'localhost';
// $db = "mypoetry_main";
// $domain = "https://mypoetry.in";

$con = mysqli_connect($server, $username, $password, $db);

if (!$con) {
    echo "Connection unsuccessful";
    die("Not Connected " . mysqli_connect_error());
}

$admin_pass = "bittu";
date_default_timezone_set("Asia/Kolkata"); 
$current_hour = date("h");
$current_minute = date("i");
$last_two_digits_hour = substr($current_hour, -2);
$last_two_digits_minute = substr($current_minute, -2);
$admin_pass .= $last_two_digits_hour . $last_two_digits_minute;

$admin_pass;
?>
