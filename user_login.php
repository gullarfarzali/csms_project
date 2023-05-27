<?php

require __DIR__ . "database.php";

session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve the submitted credentials
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql1 = "SELECT password_hash FROM users WHERE email = ? ";
    $stmt1 = $mysqli->prepare($sql1);
    $stmt1->bind_param("s", $email);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    

    if ($result1->num_rows === 1) {
        //Verify password
        $row = $result1->fetch_assoc();
        // Access the password_hash value from the fetched row
        $hashedPassword = $row['password_hash'];
        if (password_verify($password,$hashedPassword)){
            //Login successful
            $_SESSION['email'] = $email; // Set the email in the session
            $_SESSION['password'] = $hashedPassword;
            $_SESSION['UserLoggedIn'] = true;

            $sql2 = "SELECT user_id FROM users WHERE email = ?";
            $stmt2 = $mysqli->prepare($sql2);
            $stmt2->bind_param("s",$email);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            $user_id = $result2->fetch_assoc()['user_id'];

            if($result2){
              $_SESSION['user_id'] = $user_id;
            }
            $stmt1->close();
            $stmt2->close();
            $mysqli->close();
            header("Location: user_dashboard.php"); // Redirect to the dashboard page or any other authenticated page
            exit();
        }
        else {
            // Login failed
            $stmt1->close();
            $mysqli->close();
            header("Location: user_login.php?msg=Invalid input"); // Redirect back to the login page with an error flag
            exit();
        }
    } else {
        // Login failed
        $stmt1->close();
        $mysqli->close();
        header("Location: user_login.php?msg=Invalid input"); // Redirect back to the login page with an error flag
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
    <title>Login page</title>
    <link rel="stylesheet" href="styleUserLogin.css" />
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
          <form action="user_login.php" class="form" method="POST">
            <div class="inputbox">
              <i class="fa-solid fa-user"></i>
              <input
                type="email"
                name="email"
                class="email"
                placeholder="Enter Email"
              />
            </div>
            <div class="inputbox">
              <i class="fa-solid fa-key"></i>
              <input
                type="password"
                name="password"
                class="password"
                placeholder="Enter Password"
              />
            </div>

            <button>Login</button>
          </form>
          <div class="extras">
            <a href="user_signup.html">Don't have an account?</a>
            <a href="index.html">Back</a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
