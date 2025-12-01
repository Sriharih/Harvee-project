<?php
require 'db.php';
session_start();
if (!isset($_SESSION['admin'])) { header("Location: admin_login.php"); }

$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE id=$id");
header("Location: admin_dashboard.php");
?>
