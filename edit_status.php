<?php

require __DIR__ . "\\..\\database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  $status = $_POST['selectedValue'];
  $device_id = $_POST['id'];
  $comments = $_POST['comments'];

  $sql = "SELECT status_id FROM statuses WHERE status_name = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("s", $status);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  $status_id = $row['status_id'];

  $sql = "UPDATE devices SET status_id = ?, comments = ? WHERE device_id = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("isi", $status_id, $comments, $device_id);
  $stmt->execute();

  header('Location: manage_statuses.php');
  exit();
}
?>
