<?php

session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    require __DIR__ . "\\..\\database.php";

    // Retrieve the submitted credentials
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT password_hash FROM employees WHERE email = ? ";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        //Verify password
        $row = $result->fetch_assoc();
        // Access the password_hash value from the fetched row
        $hashedPassword = $row['password_hash'];
        if (password_verify($password,$hashedPassword)){
            //Login successful
            $_SESSION['email'] = $email; // Set the email in the session
            $_SESSION['password'] = $hashedPassword;
            $_SESSION['EmployeeLoggedIn'] = true;
            $stmt->close();
            $mysqli->close();
            header("Location: emp_dashboard.php"); // Redirect to the dashboard page or any other authenticated page
            exit();
        }
        else {
            // Login failed
            $stmt->close();
            $mysqli->close();
            header("Location: emp_login.php?msg=Invalid input"); // Redirect back to the login page with an error flag
            exit();
        }
    } else {
        // Login failed
        $stmt->close();
        $mysqli->close();
        header("Location: emp_login.php?msg=Invalid input"); // Redirect back to the login page with an error flag
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Employee Login page</title>
    <link rel="stylesheet" href="styleEmployeeLogin.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <script
      src="https://kit.fontawesome.com/86b5c3aa15.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <div class="container">
      <div class="login">
        <div class="side">
          <h1>Welcome Back!</h1>
        </div>
        <div class="loginform">
          <h1>Login</h1>
          <form action="emp_login.php" class="form" method="POST">
            <div class="inputbox">
              <i class="fa-solid fa-user"></i>
              <input
                type="email"
                name="email"
                class="email"
                placeholder="Enter Email"
                required
              />
            </div>
            <div class="inputbox">
              <i class="fa-solid fa-key"></i>
              <input
                type="password"
                name="password"
                class="password"
                placeholder="Enter Password"
                required
              />
            </div>

            <button>Login</button>
          </form>
          <div class="extras">
            <a href="../index.html">Back</a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
