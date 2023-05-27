<?php

require __DIR__ . "\\..\\database.php";

session_start();

require_once "user_auth_check.php";

if(isset($_POST['device_name']) && isset($_POST['service_name'])){
// Retrieve form inputs
$device_name = $_POST['device_name'];
$service_name = $_POST['service_name'];

// Validate inputs
if (empty($device_name) || empty($service_name)) {
    // Handle validation error
    echo "Device name and service name are required.";
    exit;
}

// Sanitize the input to prevent SQL injection
$device_name = $mysqli->real_escape_string($device_name);
$service_name = $mysqli->real_escape_string($service_name);

// Retrieve the relevant service and device details
$sql = "SELECT service_id, total FROM services WHERE `service_name` = ?";
$stmt1 = $mysqli->prepare($sql);

$stmt1->bind_param("s", $service_name);
$stmt1->execute();

$stmt1->bind_result($service_id, $total);

if ($stmt1->fetch()) {
  $stmt1->close();
  $sql = "INSERT into devices (device_name, status_id, service_id) VALUES (?,6,?)";

  $stmt2 = $mysqli->prepare($sql);
  $stmt2->bind_param("si",$device_name,$service_id);
  $stmt2->execute();
  $device_id = $stmt2->insert_id;
  $stmt2->close();
  $sql = "INSERT into orders (total,user_id,device_id) VALUES(?,?,?)";

  $stmt3 = $mysqli->prepare($sql);
  $stmt3 -> bind_param("dii",$total,$_SESSION["user_id"],$device_id);
  $stmt3->execute();
  $stmt3->close();
} 
else {
  echo "No rows found.";
}

header("Location: user_dashboard.php?msg=Device added successfully");
exit;
// Close the database connection
$mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin crud</title>
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <style>
      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }

      body {
        font-family: "Open Sans", sans-serif;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background-color: #f2f2f2;
      }

      nav {
        align-items: center;
        display: flex;
        justify-content: center;
        padding: 20px 0;
        background-color: #0b2b53;
        border-radius: 4px;
      }

      nav h2 {
        color: white;
        background: transparent;
        border: 2px solid white;
        border-radius: 10px;
        padding: 5px 15px;
        font-weight: 700;
        font-size: 30px;
      }

      .container {
        display: flex;
        justify-content: center;
        height: 80vh;
      }

      .register {
        width: 800px;
        height: 390px;
        overflow: hidden;
        border-radius: 0 0 5px 5px;
        border: 2px solid #0b2b53;
        border-top: none;
        box-shadow: 15px 5px 30px rgba(0, 0, 0, 0.2);
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: repeat(9, 1fr);
      }

      .addService {
        color: #0b2b53;
        text-align: center;
        background: transparent;
        border-bottom: 2px solid #0b2b53;
        grid-row: 3 / span 1;
        grid-column: 2 / span 2;
      }

      .addService span {
        color: #a9cf1f;
      }

      .registerform-main {
        color: #ffffff;
        padding: 25px;
        padding-top: 0px;

        grid-row: 4 / span 5;
        grid-column: 2 / span 2;
      }

      .inputbox {
        border-radius: 3px;
        background: transparent;
        outline: none;
        border: 1px solid #0b2b53;
        width: 100%;
        height: 35px;
        margin: 30px 0;
        background: white;
      }

      .inputbox input, .inputbox select {
        background: transparent;
        width: 70%;
        outline: none;
        border: 0;
        padding-left: 5px;
        height: 100%;
      }



      option{
        border: none;
        outline: none;
        font-size: 14px;
        font-weight: 400;
      }
 

      ::placeholder {
        color: #04140e;
      }

      button {
        border: 1px solid #0b2b53;
        border-radius: 3px;
        padding: 12px;
        font-size: 18px;
        background: #fff;
        color: #04140e;
        cursor: pointer;

        grid-row: 8;
        grid-column: 2 / span 2;
      }

      button:hover {
        background-color: #cccccc;
        transition: all ease 0.5s;
      }

      #insidei, #insidei2 {
        color: #04140e;
        font-size: 15px;
        padding: 6px;
      }

      #insidei{
        padding: 8px;
      }

      .extras {
        display: flex;
        justify-content: center;

        grid-row: 9;
        grid-column: 2 / span 2;
      }

      .extras a {
        color: #04140e;
        font-size: 12px;
        margin: 10px 20px;
      }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav
      class="navbar navbar-light text-white bg-primary justify-content-center fs-3 mb-5 py-3"
    >
      <h2>Apply Requests</h2>
    </nav>

    <!-- Add an user form -->
    <div class="container">
      <div class="register">
        <h2 class="addService">Send New <span>Request</span></h2>

        <div class="registerform-main">
          <form action="request.php" method="POST">
            <div class="inputbox" id="inputbox">
              <i class="fa-solid fa-briefcase" id="insidei"></i>
              <input
                type="text"
                name="device_name"
                class="box"
                placeholder="Enter Device Name"
                required
              />
            </div>
            <div class="inputbox">
              <i class="fa-solid fa-laptop-code" id="insidei2"></i>
              <select class="form-control box" id="service_name" name="service_name" required>
              <?php
                $sql = "SELECT * FROM services";
                $result = $mysqli->query($sql);

                // Check if query is executed properly
                if(! $result) {
                    die("Invalid query: " . $mysqli->error($sql));
                }

                // Read data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<option value='".$row['service_name']."'>".$row['service_name']."</option>";
                }
              ?>
              </select>
            </div>
            <button type="submit" class="btn btn-success" name="submit">
              Send
            </button>
          </form>
        </div> 
        <div class="extras">
          <a href="user_dashboard.php" class="back">Cancel</a>
        </div>
      </div>
    </div>
  </body>
</html>
          
  