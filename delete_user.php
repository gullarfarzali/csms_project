<?php

session_start();

require_once "admin_auth_check.php";

require __DIR__ . "\\..\\database.php";

$user_id = isset($_GET["user_id"]) ? $_GET["user_id"] : null;


// Delete associated orders
$sqlOrders = "DELETE FROM orders WHERE user_id = ?";
$stmtOrders = $mysqli->prepare($sqlOrders);
$stmtOrders->bind_param("i", $user_id);
$stmtOrders->execute();

// Delete the user
$sqlService = "DELETE FROM users WHERE user_id = ?";
$stmtService = $mysqli->prepare($sqlService);
$stmtService->bind_param("i", $user_id);
$stmtService->execute();


if ($stmtService->affected_rows > 0) {
  header("Location: admin_dashboard.php?msg=Data deleted successfully");
  exit;
} else {
  die ("Failed to delete the user: " . $mysqli->error );
}

$mysqli->close();

?>