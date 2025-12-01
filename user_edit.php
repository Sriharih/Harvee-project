<?php
require 'db.php';
session_start();
if (!isset($_SESSION['admin'])) { header("Location: admin_login.php"); }

$id = $_GET['id'];

if ($_POST) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $state = $_POST['state'];
    $city = $_POST['city'];

    $conn->query("UPDATE users SET name='$name', email='$email', state='$state', city='$city' WHERE id=$id");
    header("Location: admin_dashboard.php");
}

$result = $conn->query("SELECT * FROM users WHERE id=$id");
$row = $result->fetch_assoc();
?>

<form method="POST">
<input type="text" name="name" value="<?php echo $row['name'] ?>" required>
<input type="email" name="email" value="<?php echo $row['email'] ?>" required>
<input type="text" name="state" value="<?php echo $row['state'] ?>" required>
<input type="text" name="city" value="<?php echo $row['city'] ?>" required>
<button>Save Changes</button>
</form>
