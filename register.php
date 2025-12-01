<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $state = $_POST['state'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $pincode = trim($_POST['pincode']);
    $password = $_POST['password'];

    if (!preg_match("/^[A-Za-z ]{3,}$/", $name)) {
        die("Invalid name!");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format!");
    }

    $checkEmail = $conn->query("SELECT id FROM users WHERE email='$email'");
    if ($checkEmail->num_rows > 0) {
        die("Email already exists!");
    }

    if (!preg_match("/^[0-9]{10,15}$/", $phone)) {
        die("Invalid phone!");
    }

    if (!preg_match("/^[0-9]{4,10}$/", $pincode)) {
        die("Invalid pincode!");
    }

    if (!preg_match("/^(?=.*\d).{6,}$/", $password)) {
        die("Password must contain a number!");
    }

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $img = $_FILES['profile_image'];
    if ($img['size'] > 2 * 1024 * 1024) {
        die("Image too large!");
    }

    $allowed = ['image/jpeg','image/png'];
    if (!in_array($img['type'], $allowed)) {
        die("Only JPG or PNG!");
    }

    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
    $path = "assets/profile/" . uniqid() . "." . $ext;
    move_uploaded_file($img['tmp_name'], $path);

    $stmt = $conn->prepare("INSERT INTO users (name,email,phone,password,profile_image,address,state,city,country,pincode)
                           VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssssss", $name, $email, $phone, $passwordHash, $path, $address, $state, $city, $country, $pincode);

    if ($stmt->execute()) {
        echo "Registration Successful ✅ <a href='login.php'>Login Now</a>";
    } else {
        echo "Error!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<style>
body{font-family:Arial;background:#f2f2f2;display:flex;justify-content:center;align-items:center;height:100vh;margin:0}
form{background:#fff;padding:20px;border-radius:10px;box-shadow:0 0 10px rgba(0,0,0,0.2);width:300px}
input{width:100%;padding:8px;margin:8px 0;border:1px solid #ccc;border-radius:5px}
button{width:100%;padding:10px;background:#333;color:#fff;border:none;border-radius:5px}
</style>
</head>
<body>
<form method="POST" enctype="multipart/form-data">
<h3>User Register</h3>
<input type="text" name="name" placeholder="Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="text" name="phone" placeholder="Phone" required>
<input type="text" name="address" placeholder="Address">
<input type="text" name="state" placeholder="State" required>
<input type="text" name="city" placeholder="City" required>
<input type="text" name="country" placeholder="Country" required>
<input type="text" name="pincode" placeholder="Pincode" required>
<input type="file" name="profile_image" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit">Register</button>
</form>
</body>
</html>
