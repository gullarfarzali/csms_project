<?php

// Check if the user is not logged in or the login status is not true
if (!isset($_SESSION['UserLoggedIn']) || $_SESSION['UserLoggedIn'] !== true) {
    header("Location: user_login.php"); // Redirect the user to the login page
    exit();
}

?>