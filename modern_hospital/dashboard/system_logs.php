<?php
include "../includes/db.php";
include "../includes/auth_check.php";

/* BLOCK NON-ADMINS */
if($_SESSION['role'] !== 'admin'){
    header("Location: index.php");
    exit;
}

/* FETCH LOGS */
$logs = $conn->query(
    "SELECT * FROM audit_logs ORDER BY id DESC LIMIT 500"
);

if(!$logs){
    die("SQL Error: ".$conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>System Logs | Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    margin:0;
    font-family:Segoe UI, Arial, sans-serif;
    background:#f4f6f9;
}
.main{
    margin-left:240px;
    padding:30px;
}
.card{
    background:#fff;
    padding:25px;
    border-radius:14px;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
}
.top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}
h2{margin:0}
.back{
    text-decoration:none;
    color:#0fb9a8;
    font-weight:600;
}
table{
    width:100%;
    border-collapse:collapse;
}
th,td{
    padding:12px;
    border-bottom:1px solid #ddd;
    text-align:left;
}
th{
    background:#0fb9a8;
    color:#fff;
}
.role{
    padding:5px 10px;
    border-radius:15px;
    font-size:12px;
    color:#fff;
}
.admin{background:#2ecc71}
.officer{background:#3498db}
.empty{
    text-align:center;
    padding:20px;
    color:#777;
}
@media(max-width:768px){
    .main{margin-left:0}
}
</style>
</head>

<body>

<div class="main">

<div class="card">

<div class="top">
    <h2>System Audit Logs</h2>
    <a href="index.php" class="back">← Back to Dashboard</a>
</div>

<table>
<tr>
    <th>#</th>
    <th>Username</th>
    <th>Role</th>
    <th>Action</th>
    <th>Details</th>
    <th>Date</th>
</tr>

<?php if($logs->num_rows > 0): ?>
<?php while($log = $logs->fetch_assoc()): ?>
<tr>
    <td><?= $log['id'] ?></td>
    <td><?= htmlspecialchars($log['username']) ?></td>
    <td>
        <span class="role <?= $log['role']=='admin'?'admin':'officer' ?>">
            <?= strtoupper($log['role']) ?>
        </span>
    </td>
    <td><?= htmlspecialchars($log['action']) ?></td>
    <td><?= htmlspecialchars($log['searched_value'] ?? '-') ?></td>
    <td><?= $log['created_at'] ?></td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
    <td colspan="6" class="empty">No system logs found</td>
</tr>
<?php endif; ?>

</table>

</div>

</div>

</body>
</html>
