<?php

require __DIR__ . "database.php";

session_start();

require_once "admin_auth_check.php";



if (isset($_POST["submit"])) {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];
    $id = $_GET["id"];
            
    $sql = "UPDATE employees SET first_name=?, last_name=?, password_hash=?, email=?, date_of_birth=? WHERE employee_id = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);

    // Hashes the password against cyber attacks
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt->bind_param("sssssi", $first_name, $last_name, $password_hash, $email, $date_of_birth, $id);


    // Check if it is a valid email
    if (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        header("Location: admin_dashboard.php?msg=Valid email is required");
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
    } elseif (!$stmt->execute()) {
        die("Failed:" . $mysqli->error);
        header("Location: admin_dashboard.php?msg=Couldnt execute");
        exit;
    }
    $stmt->close();
    header("Location: admin_dashboard.php?msg=Data updated successfully");
    exit;
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

    <link rel="stylesheet" href="edit_employee_s.css" />
  </head>
  <body>
    <!-- Navbar -->
    <nav
      class="navbar navbar-light text-white bg-primary justify-content-center fs-3 mb-5 py-3"
    >
      <h2>Edit Employees</h2>
    </nav>

    <?php

      $id = $_GET["id"];

      $sql = "SELECT * FROM employees WHERE employee_id = ?";
      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param("i",$id);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $mysqli->close();
    ?>

    <!-- Edit an employee form -->
    <div class="container">
      <div class="register">
        <h2 class="updateEmployee">Update <span>Employee</span></h2>
        <div class="registerform-extra">
          <form action="edit_employee.php?id=<?php echo $row['employee_id']; ?>" method="POST">
            <div class="inputbox">
              <i class="fa-solid fa-file-signature"></i>
              <input
                type="text"
                id="first_name"
                name="first_name"
                class="form-control form-control-margin"
                value="<?php echo $row['first_name'] ?>"
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
                value="<?php echo $row['last_name'] ?>"
                required
              />
            </div>
            <div class="inputbox">
              <i class="fa-solid fa-calendar-days"></i>
              <input
                type="date"
                id="birthdate"
                name="date_of_birth"
                class="form-control form-control-margin"
                value="<?php echo $row['date_of_birth'] ?>"
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
                value="<?php echo $row['email'] ?>"
                required
              />
            </div>

            <div class="inputbox">
              <i class="fa-solid fa-key"></i>
              <input
                type="password"
                name="password"
                class="box"
                value="<?php echo $row['password_hash'] ?>"
                required
              />
            </div>
            <button type="submit" class="btn btn-success" name="submit">
              Update
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
