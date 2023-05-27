<?php

session_start();

session_destroy();

session_unset();

header("Location: user_login.php");

exit;