<?php

session_start();

session_destroy();

session_unset();

header("Location: \\csms\\index.html");

exit;