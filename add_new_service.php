<?php

session_start();

require_once "admin_auth_check.php";

require __DIR__ . "database.php";

if (isset($_POST["submit"]) && isset($_POST["total"]) && isset($_POST["service_name"])) {
    $service_name = $_POST['service_name'];
    $total = $_POST['total'];
 
    $stmt = $mysqli->stmt_init();

    $sql = "INSERT INTO services (service_name, total) VALUES (?,?)";
    $stmt->prepare($sql);
    $stmt->bind_param("sd",$service_name,$total);
 
    if ($stmt->execute()) {
       header("Location: admin_dashboard.php?msg=New record created successfully");
    } else {
       echo "Failed: " . $mysqli->error;
    }
    $stmt->close();
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

    <link rel="stylesheet" href="add_new_service_s.css" />
  </head>
  <body>
    <!-- Navbar -->
    <nav
      class="navbar navbar-light text-white bg-primary justify-content-center fs-3 mb-5 py-3"
    >
      <h2>Manage Services</h2>
    </nav>

    <!-- Add a service form -->
    <div class="container">
      <div class="register">
        <h2 class="addService">Add New <span>Service</span></h2>

        <div class="registerform-main">
          <form action="add_new_service.php" method="POST">
            <div class="inputbox">
              <i class="fa-solid fa-briefcase"></i>
              <input
                type="text"
                name="service_name"
                class="box"
                placeholder="Enter Service"
                required
              />
            </div>
            <div class="inputbox">
                <i class="fa-solid fa-money-bill"></i>
              <input
                type="text"
                name="total"
                class="box"
                placeholder="Enter Price"
                required
              />
            </div>
            <button type="submit" class="btn btn-success" name="submit">
              Save
            </button>
          </form>
        </div>
        <div class="extras">
          <a href="admin_dashboard.php" class="back">Cancel</a>
        </div>
      </div>
    </div>
  </body>
</html>
