<?php

require __DIR__ . "database.php";

session_start();

require_once "emp_auth_check.php";

if($_SERVER["REQUEST_METHOD"]=== "POST") {

    $sql = "UPDATE devices SET status_id = 2 WHERE status_id = 6 and device_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i",$_POST['device_id']);
    $stmt->execute();
    header("Location: emp_dashboard.php");
    exit();
}

?>
