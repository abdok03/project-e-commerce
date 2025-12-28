<?php
session_start();
session_unset();
setcookie(session_name(), '', time() - 3600, '/');
session_destroy();
header("Location: ../html/login.php");  
exit;
