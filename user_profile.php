<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); }

$id = $_SESSION['user'];
$result = $conn->query("SELECT * FROM users WHERE id=$id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head><title>User Profile</title></head>
<body style="font-family:Arial;display:flex;justify-content:center;align-items:center;height:100vh;background:#f1f1f1;margin:0">
<div style="background:#fff;padding:20px;border-radius:10px;width:280px;box-shadow:0 0 6px rgba(0,0,0,0.1)">
<img src="<?php echo $row['profile_image'] ?>" width="100" style="border-radius:50%">
<h3><?php echo $row['name'] ?></h3>
<p>Email: <?php echo $row['email'] ?></p>
<p>Phone: <?php echo $row['phone'] ?></p>
<p>State: <?php echo $row['state'] ?></p>
<p>City: <?php echo $row['city'] ?></p>
<p>Pincode: <?php echo $row['pincode'] ?></p>
<br><a href='logout.php'>Logout</a>
</div>
</body>
</html>
