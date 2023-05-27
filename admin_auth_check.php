<?php

// Check if the admin is not logged in or the login status is not true
if (!isset($_SESSION['AdminLoggedIn']) || $_SESSION['AdminLoggedIn'] !== true) {
    header("Location: admin_login.php"); // Redirect the admin to the login page
    exit();
}

?>