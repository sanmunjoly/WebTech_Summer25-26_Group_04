<?php
/**
 * LogoutController.php
 * Destroys the session and returns to the login page.
 */

session_start();
$_SESSION = [];
session_destroy();
setcookie(session_name(), "", time() - 3600, "/");
header("Location: login.php");
exit;
