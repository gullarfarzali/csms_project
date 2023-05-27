<?php

// Check if the employee is not logged in or the login status is not true
if (!isset($_SESSION['EmployeeLoggedIn']) || $_SESSION['EmployeeLoggedIn'] !== true) {
    header("Location: emp_login.php"); // Redirect the employee to the login page
    exit();
}

?>