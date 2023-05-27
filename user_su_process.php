<?php
    if (empty($_POST["first_name"]) || empty($_POST["last_name"]) || empty($_POST["password"]) || empty($_POST["password_confirmation"]) || empty($_POST["date_of_birth"])) {
        die("All fields are required");
    }

    // Check if it is a valid email
    if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        die("Valid email is required");
    }

    if (strlen($_POST["password"]) < 8) {
        die("Password must be at least 8 characters");
    }
    // Check if password characters match at least one of the letters
    if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
        die("Password must contain at least one letter");
    }
    // Check if password characters match at least one of the numbers
    if ( ! preg_match("/[0-9]/", $_POST["password"])) {
        die("Password must contain at least one number");
    }

    if($_POST["password"] !== $_POST["password_confirmation"]) {
        die("Passwords must match");
    }

    // Hashes the password against cyber attacks
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    //include database connection file
    $mysqli = require __DIR__ . "database.php";

    $sql = "INSERT INTO users (first_name, last_name, password_hash, email, date_of_birth)
            VALUES (?, ?, ?, ?, ?)";

    // stmt_init() initializes a statement and returns and object for use with prepare stmt
    $stmt = $mysqli->stmt_init();

    // Prepare the statement for execution
    if( ! $stmt->prepare($sql)) {
        die("SQL error:" . $mysqli->error);
    }
    
    $stmt->bind_param("sssss", $_POST["first_name"], $_POST["last_name"], $password_hash, $_POST["email"], $_POST["date_of_birth"]);

    if ($stmt->execute()) {
        header("Location: user_login.php");
        exit;
    }
    else {
        if($mysqli->errno === 1062) {
            die ("Email already taken");
        }
        else {
            die(" " . $mysqli->errno);
        }
    }
?>

