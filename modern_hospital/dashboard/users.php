<?php
include "../includes/db.php";
include "../includes/auth_check.php";

/* BLOCK NON-ADMINS */
if($_SESSION['role'] !== 'admin'){
    header("Location: index.php");
    exit;
}

$msg = "";

/* REGISTER HEALTH OFFICER */
if(isset($_POST['register_user'])){
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role     = $_POST['role'];

    if($username && $password && $role){
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
          "INSERT INTO users (username,password,role)
           VALUES (?,?,?)"
        );
        $stmt->bind_param("sss",$username,$hash,$role);
        $stmt->execute();

        $msg = "User registered successfully";
    } else {
        $msg = "All fields are required";
    }
}

/* FETCH USERS */
$users = $conn->query(
    "SELECT id,username,role FROM users ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Manage Staff | Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
*{box-sizing:border-box}
body{
    margin:0;
    font-family:Segoe UI, Arial;
    background:#f4f6f9;
}

/* ===== MAIN ===== */
.main{
    margin-left:240px;
    padding:30px;
}

/* ===== HEADER ===== */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}
.header h1{
    margin:0;
    color:#333;
}
.back-btn{
    background:#34495e;
    color:#fff;
    text-decoration:none;
    padding:10px 18px;
    border-radius:6px;
    font-size:14px;
}

/* ===== CARD ===== */
.card{
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
    margin-bottom:30px;
}
.card h2{
    margin-top:0;
    color:#0fb9a8;
}

/* ===== FORM ===== */
input,select,button{
    width:100%;
    padding:10px;
    margin:8px 0;
    border-radius:6px;
    border:1px solid #ccc;
}
button{
    background:#0fb9a8;
    color:#fff;
    border:none;
    font-size:15px;
    cursor:pointer;
}
button:hover{
    background:#0aa79a;
}

/* ===== TABLE ===== */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}
th,td{
    padding:12px;
    border-bottom:1px solid #ddd;
}
th{
    background:#0fb9a8;
    color:#fff;
}

/* ===== BADGES ===== */
.badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    color:#fff;
    font-weight:600;
}
.admin{background:#2ecc71}
.officer{background:#3498db}

/* ===== MESSAGE ===== */
.msg{
    background:#e6fff6;
    padding:12px;
    border-left:5px solid #0fb9a8;
    margin-bottom:15px;
}

/* ===== RESPONSIVE ===== */
@media(max-width:768px){
    .main{margin-left:0}
}
</style>
</head>

<body>

<div class="main">

<!-- HEADER -->
<div class="header">
    <h1>Staff Management</h1>
    <a href="index.php" class="back-btn">← Back to Dashboard</a>
</div>

<!-- REGISTER USER -->
<div class="card">
<h2>Register Staff Account</h2>

<?php if($msg): ?>
<div class="msg"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<form method="POST">
<input name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>

<select name="role" required>
    <option value="">Select Role</option>
    <option value="health_officer">Health Officer</option>
    <option value="admin">Admin</option>
</select>

<button name="register_user">Create User</button>
</form>
</div>

<!-- USER LIST -->
<div class="card">
<h2>Staff Accounts</h2>

<table>
<tr>
<th>Username</th>
<th>Role</th>
</tr>

<?php while($u = $users->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($u['username']) ?></td>
<td>
<span class="badge <?= $u['role']==='admin'?'admin':'officer' ?>">
<?= strtoupper($u['role']) ?>
</span>
</td>
</tr>
<?php endwhile; ?>

</table>
</div>

</div>

</body>
</html>
