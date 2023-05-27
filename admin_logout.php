<?php

session_start();

session_destroy();

session_unset();

header("Location: admin_login.php");

exit;