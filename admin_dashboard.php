<?php
require 'db.php';
session_start();
if (!isset($_SESSION['admin'])) { header("Location: admin_login.php"); }

$search = $_GET['search'] ?? '';
$query = "SELECT * FROM users WHERE role='user' AND
         (name LIKE '%$search%' OR email LIKE '%$search%' OR state LIKE '%$search%' OR city LIKE '%$search%')
         ORDER BY name ASC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
body{font-family:Arial;padding:20px;background:#fafafa}
table{width:100%;border-collapse:collapse;background:#fff;box-shadow:0 0 10px rgba(0,0,0,0.1)}
th,td{padding:10px;border:1px solid #ccc}
input{padding:8px;width:300px;border-radius:4px;border:1px solid #888;margin-bottom:10px}
</style>
</head>
<body>
<h2>All Users (Sorted Order)</h2>

<form>
<input type="text" name="search" placeholder="Search (name/email/state/city)" value="<?php echo $search ?>">
</form>

<table>
<th>Name</th><th>Email</th><th>State</th><th>City</th><th>Actions</th>
<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
<td><?php echo $row['name'] ?></td>
<td><?php echo $row['email'] ?></td>
<td><?php echo $row['state'] ?></td>
<td><?php echo $row['city'] ?></td>
<td>
<a href="user_view.php?id=<?php echo $row['id'] ?>">View</a> |
<a href="user_edit.php?id=<?php echo $row['id'] ?>">Edit</a> |
<a href="user_delete.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
</td>
</tr>
<?php } ?>
</table>

<br><a href='logout.php'>Logout Admin</a>
</body>
</html>
