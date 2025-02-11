<?php
session_start();
session_unset();
session_destroy();

header("Location: /quiz-night/admin/auth/login.php");
exit();


