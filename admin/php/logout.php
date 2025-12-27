<?php
session_start();
session_unset();
session_destroy();
setcookie(session_name(), '', time()-3600, '/'); // حذف الكوكيز القديمة
header("Location: ../../htmnl/index.php");
exit;
?>
