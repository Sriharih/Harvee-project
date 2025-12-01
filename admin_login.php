<?php
session_start();

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email === "admin@123" && $password === "12345678") {
        $_SESSION['admin'] = true;
        header("Location: admin_dashboard.php");
    } else {
        echo "Invalid Admin Credentials ❌";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Admin Login</title></head>
<body style="font-family:Arial;display:flex;justify-content:center;align-items:center;height:100vh;background:#ddd;margin:0">
<form method="POST" style="background:#fff;padding:20px;border-radius:8px;width:280px">
<h3>Admin Login</h3>
<input type="email" name="email" placeholder="Admin ID" required style="width:100%;padding:8px;margin:6px 0;border-radius:4px;border:1px solid #ccc">
<input type="password" name="password" placeholder="Password" required style="width:100%;padding:8px;margin:6px 0;border-radius:4px;border:1px solid #ccc">
<button style="width:100%;padding:10px;background:#000;color:#fff;border:none;border-radius:4px;margin-top:8px">Login</button>
</form>
</body>
</html>
