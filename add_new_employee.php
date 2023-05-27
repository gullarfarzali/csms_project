<?php

session_start();

require_once "admin_auth_check.php";

require __DIR__ . "database.php";

if(isset($_POST['submit'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];

    // Hashes the password against cyber attacks
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO employees (first_name, last_name, password_hash, email, date_of_birth)
        VALUES (?,?,?,?,?)";
    $stmt = $mysqli->stmt_init();
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssss", $first_name, $last_name, $password_hash, $email, $date_of_birth);

    // Check if it is a valid email
    if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        header("Location: admin_dashnoard.php?msg=Valid email is required");
        $stmt->close();
    }
    //Check if password contains at least 8 characters
    elseif(strlen($_POST["password"]) < 8) {
        header("Location: admin_dashboard.php?msg=Password must contain at least 8 characters");
        $stmt->close();
    //Check if password characters match at least one of the letters
    } elseif(! preg_match("/[a-z]/i", $_POST["password"])) {
        header("Location: admin_dashboard.php?msg=Password must contain at least one letter");
        $stmt->close();
    // Check if password contains at least one number
    } elseif(! preg_match("/[0-9]/", $_POST["password"])) {
        header("Location: admin_dashboard.php?msg=Password must contain at least one number");
        $stmt->close();
    } else {
        $stmt->execute();
        header("Location: admin_dashboard.php?msg=New record created successfully");
        $stmt->close();
    }
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

    <link rel="stylesheet" href="add_new_employee_s.css" />
  </head>
  <body>
    <!-- Navbar -->
    <nav
      class="navbar navbar-light text-white bg-primary justify-content-center fs-3 mb-5 py-3"
    >
      <h2>Manage Employees</h2>
    </nav>

    <!-- Add an employee form -->
    <div class="container">
      <div class="register">
          <h2 class="addEmployee">Add New <span>Employee</span></h2>
        <div class="registerform-extra">
          <form action="add_new_employee.php" method="POST">
            <div class="inputbox">
              <i class="fa-solid fa-file-signature"></i>
              <input
                type="text"
                id="first_name"
                name="first_name"
                class="form-control form-control-margin"
                placeholder="Enter Firstname"
                required
              />
            </div>

            <div class="inputbox">
              <i class="fa-solid fa-file-signature"></i>
              <input
                type="text"
                id="last_name"
                name="last_name"
                class="form-control form-control-margin"
                placeholder="Enter Lastname"
                required
              />
            </div>
            <div class="inputbox">
              <i class="fa-solid fa-calendar-days"></i>
              <input
                type="date"
                id="date_of_birth"
                name="date_of_birth"
                class="form-control form-control-margin"
                required
              />
            </div>
        </div>
        <div class="registerform-main">
            <div class="inputbox">
              <i class="fa-solid fa-user"></i>
              <input
                type="email"
                name="email"
                class="box"
                placeholder="Enter Email"
                required
              />
            </div>
            <div class="inputbox">
              <i class="fa-solid fa-key"></i>
              <input
                type="password"
                name="password"
                class="box"
                placeholder="Enter Password"
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
