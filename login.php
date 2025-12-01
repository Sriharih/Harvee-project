<?php
require 'db.php';
session_start();

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email' AND role='user'");

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['id'];
            header("Location: dashboard.php");
        } else {
            echo "Wrong password ❌";
        }
    } else {
        echo "User not found ❌";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body style="font-family:Arial;display:flex;justify-content:center;align-items:center;height:100vh;background:#eee;margin:0">
<form method="POST" style="background:#fff;padding:20px;border-radius:8px;width:280px">
<h3>User Login</h3>
<input type="email" name="email" placeholder="Email" required style="width:100%;padding:8px;margin:6px 0;border-radius:4px;border:1px solid #ccc">
<input type="password" name="password" placeholder="Password" required style="width:100%;padding:8px;margin:6px 0;border-radius:4px;border:1px solid #ccc">
<button style="width:100%;padding:10px;background:#222;color:#fff;border:none;border-radius:4px;margin-top:8px">Login</button>
</form>
</body>
</html>
