<?php
session_start();
$_SESSION = [];
session_destroy();

setcookie("bloodbridge_admin", "", time() - 3600, "/");

header("Location: login.php");
exit();
?>
