<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "password";
    $dbname = "csms";

    // Create connection
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Check connection
    if($mysqli->connect_errno) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    return $mysqli;
?> 