<?php

session_start();

require_once "admin_auth_check.php";

require __DIR__ . "database.php";

// Delete associated devices first
$sqlDevices = "DELETE FROM devices WHERE service_id = ?";
$stmtDevices = $mysqli->prepare($sqlDevices);
$stmtDevices->bind_param("i", $_GET['id']);
$stmtDevices->execute();

// Delete the employee
$sqlService = "DELETE FROM services WHERE service_id = ?";
$stmtService = $mysqli->prepare($sqlService);
$stmtService->bind_param("i", $_GET['id']);
$stmtService->execute();


if ($stmtService->affected_rows > 0) {
  header("Location: manage_services.php?msg=Data deleted successfully");
} else {
  die ("Failed to delete the service: " . $mysqli->error );
}

$mysqli->close();

?>
