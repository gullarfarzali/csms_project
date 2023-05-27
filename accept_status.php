<?php

require __DIR__ . "database.php";

session_start();

require_once "emp_auth_check.php";

if($_SERVER["REQUEST_METHOD"] === "POST") {
    // Update status_id in devices table
    $updateStatusSql = "UPDATE devices SET status_id = 1 WHERE status_id = 6 AND device_id = ?";
    $stmt = $mysqli->prepare($updateStatusSql);
    $stmt->bind_param("i", $_POST['device_id']);
    if (!$stmt->execute()) {
        echo "Error updating status: " . $stmt->error;
        exit();
    }
    $stmt->close();
    // Retrieve employee_id from employees table
    $selectEmployeeSql = "SELECT employee_id FROM employees WHERE email = ?";
    $stmt = $mysqli->prepare($selectEmployeeSql);
    $stmt->bind_param("s", $_SESSION['email']);
    if (!$stmt->execute()) {
        echo "Error retrieving employee ID: " . $stmt->error;
    }
    $stmt->bind_result($employee_id);
    $stmt->fetch();
    $stmt->close();

    // Update employee_id in devices table
    $updateEmployeeSql = "UPDATE devices SET employee_id = ? WHERE device_id = ?";
    $stmt = $mysqli->prepare($updateEmployeeSql);
    $stmt->bind_param("ii", $employee_id, $_POST['device_id']);
    if (!$stmt->execute()) {
        echo "Error updating employee ID: " . $stmt->error;
    }
    $stmt->close();

    header("Location: devices.php");
    exit();
}

?>
