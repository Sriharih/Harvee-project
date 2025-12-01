<?php
require 'db.php';
session_start();
if (!isset($_SESSION['admin'])) { header("Location: admin_login.php"); }

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE id=$id");
$row = $result->fetch_assoc();
?>

<h3>User Details</h3>
<p>Name: <?php echo $row['name'] ?></p>
<p>Email: <?php echo $row['email'] ?></p>
<p>State: <?php echo $row['state'] ?></p>
<p>City: <?php echo $row['city'] ?></p>
<img src="<?php echo $row['profile_image'] ?>" width="120">
<br><a href="admin_dashboard.php">Back</a>
