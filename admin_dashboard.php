<?php
require 'db.php';
session_start();
if (!isset($_SESSION['admin'])) { header("Location: admin_login.php"); }

$nameFilter = $_GET['name'] ?? '';
$emailFilter = $_GET['email'] ?? '';
$stateFilter = $_GET['state'] ?? '';
$cityFilter  = $_GET['city'] ?? '';
$search      = $_GET['search'] ?? '';

// Pagination logic
$page  = $_GET['page'] ?? 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$where = "role='user'";
if ($search) $where .= " AND (name LIKE '%$search%' OR email LIKE '%$search%')";
if ($nameFilter)  $where .= " AND name='$nameFilter'";
if ($emailFilter) $where .= " AND email='$emailFilter'";
if ($stateFilter) $where .= " AND state='$stateFilter'";
if ($cityFilter)  $where .= " AND city='$cityFilter'";

$result = $conn->query("SELECT * FROM users WHERE $where ORDER BY name ASC LIMIT $limit OFFSET $offset");
$count  = $conn->query("SELECT id FROM users WHERE $where");
$totalUsers = $count->num_rows;
$totalPages = ceil($totalUsers / $limit);

// Fetch unique values for dropdown filters
$nameList  = $conn->query("SELECT DISTINCT name FROM users WHERE role='user' ORDER BY name ASC");
$emailList = $conn->query("SELECT DISTINCT email FROM users WHERE role='user' ORDER BY email ASC");
$stateList = $conn->query("SELECT DISTINCT state FROM users WHERE role='user' ORDER BY state ASC");
$cityList  = $conn->query("SELECT DISTINCT city FROM users WHERE role='user' ORDER BY city ASC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
body{font-family:Arial;padding:20px;background:#fafafa}
table{width:100%;border-collapse:collapse;background:#fff;margin-top:12px;box-shadow:0 0 6px rgba(0,0,0,0.1)}
th,td{padding:10px;border:1px solid #ccc}
select,input{padding:8px;border-radius:4px;border:1px solid #888;margin-right:8px}
.pagination a{margin:0 6px;text-decoration:none;color:#000;padding:6px 10px;border:1px solid #888;border-radius:4px}
</style>
</head>
<body>

<h2>All Users</h2>

<form>
<input type="text" name="search" placeholder="Search" value="<?php echo $search ?>">

<select name="name">
<option value="">Filter by Name</option>
<?php while ($n = $nameList->fetch_assoc()) { ?>
<option value="<?php echo $n['name'] ?>" <?php if($nameFilter==$n['name']) echo 'selected'; ?>>
<?php echo $n['name'] ?>
</option>
<?php } ?>
</select>

<select name="email">
<option value="">Filter by Email</option>
<?php while ($e = $emailList->fetch_assoc()) { ?>
<option value="<?php echo $e['email'] ?>" <?php if($emailFilter==$e['email']) echo 'selected'; ?>>
<?php echo $e['email'] ?>
</option>
<?php } ?>
</select>

<select name="state">
<option value="">Filter by State</option>
<?php while ($s = $stateList->fetch_assoc()) { ?>
<option value="<?php echo $s['state'] ?>" <?php if($stateFilter==$s['state']) echo 'selected'; ?>>
<?php echo $s['state'] ?>
</option>
<?php } ?>
</select>

<select name="city">
<option value="">Filter by City</option>
<?php while ($c = $cityList->fetch_assoc()) { ?>
<option value="<?php echo $c['city'] ?>" <?php if($cityFilter==$c['city']) echo 'selected'; ?>>
<?php echo $c['city'] ?>
</option>
<?php } ?>
</select>

<button>Apply Filters</button>
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

<div class="pagination">
<?php for($i=1; $i<=$totalPages; $i++){ ?>
<a href="?page=<?php echo $i ?>&search=<?php echo $search ?>&name=<?php echo $nameFilter ?>&email=<?php echo $emailFilter ?>&state=<?php echo $stateFilter ?>&city=<?php echo $cityFilter ?>">
<?php echo $i ?>
</a>
<?php } ?>
</div>

<br><a href='logout.php'>Logout Admin</a>
</body>
</html>
