<?php

session_start();

require_once "admin_auth_check.php";

require __DIR__ . "\\..\\database.php";

// Delete associated devices first
$sqlDevices = "DELETE FROM devices WHERE employee_id = ?";
$stmtDevices = $mysqli->prepare($sqlDevices);
$stmtDevices->bind_param("i", $_SESSION['employee_id']);
$stmtDevices->execute();

// Delete the employee
$sqlEmployee = "DELETE FROM employees WHERE employee_id = ?";
$stmtEmployee = $mysqli->prepare($sqlEmployee);
$stmtEmployee->bind_param("i", $_SESSION['employee_id']);
$stmtEmployee->execute();


if ($stmtEmployee->affected_rows > 0) {
  header("Location: admin_dashboard.php?msg=Data deleted successfully");
} else {
  echo "Failed to delete the employee.";
}

$mysqli->close();

?>