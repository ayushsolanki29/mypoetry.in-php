<?php
 include 'auth/config.php';

session_start();

header('location:index.php');

if (isset($_COOKIE['rememberme'])) {
    $token = $_COOKIE['rememberme'];
    setcookie('rememberme', '', time() - 3600, '/');
    $query = "DELETE FROM rememberme_tokens WHERE token = ? AND user_id = ?";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        $user_id = $_SESSION['user_id'];
        mysqli_stmt_bind_param($stmt, "si", $token, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($con);
}

session_unset();
session_destroy();
header("Location: login.php");
exit;
?>