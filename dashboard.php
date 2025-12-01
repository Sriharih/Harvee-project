<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); }
echo "Welcome User ✔ <br><a href='logout.php'>Logout</a>";
?>
