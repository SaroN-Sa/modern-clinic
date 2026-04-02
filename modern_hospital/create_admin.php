<?php
session_start();

/* DB CONNECTION */
$conn = new mysqli("localhost","root","","modern_hospital");
if($conn->connect_error){
    die("Database connection failed");
}

$message = "";

/* CHECK IF ADMIN EXISTS */
$check = $conn->query("SELECT id FROM users WHERE role='admin' LIMIT 1");
$adminExists = ($check->num_rows > 0);

/* HANDLE FORM SUBMISSION */
if(isset($_POST['register']) && !$adminExists){
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if($username=="" || $password=="" || $confirm==""){
        $message = "All fields are required";
    } elseif($password !== $confirm){
        $message = "Passwords do not match";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users (username,password,role) VALUES (?,?,?)"
        );
        $role = "admin";
        $stmt->bind_param("sss",$username,$hash,$role);
        $stmt->execute();

        $message = "Admin registered successfully. You can login now.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Register Admin | Hospital System</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    font-family:Segoe UI;
    background:linear-gradient(to right,#0fb9a8,#0aa79a);
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}
.box{
    background:#fff;
    width:420px;
    padding:35px;
    border-radius:12px;
    box-shadow:0 15px 40px rgba(0,0,0,.25);
}
h2{text-align:center;color:#0fb9a8;margin-bottom:20px}
input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:6px;
    border:1px solid #ccc;
}
button{
    width:100%;
    padding:12px;
    background:#0fb9a8;
    color:#fff;
    border:none;
    border-radius:25px;
    font-size:16px;
    cursor:pointer;
}
.msg{
    padding:10px;
    border-radius:6px;
    text-align:center;
    margin-bottom:10px;
}
.error{background:#ffe0e0;color:#900}
.success{background:#e0fff2;color:#006644}
.note{
    font-size:13px;
    text-align:center;
    margin-top:10px;
    color:#666;
}
</style>
</head>

<body>

<div class="box">
<h2>Admin Registration</h2>

<?php if($message): ?>
<div class="msg <?= $adminExists ? 'error':'success' ?>">
    <?= htmlspecialchars($message) ?>
</div>
<?php endif; ?>

<?php if($adminExists): ?>
<div class="msg error">
    Admin already exists. Registration is disabled.
</div>
<?php else: ?>

<form method="POST">
<input type="text" name="username" placeholder="Admin Username" required>
<input type="password" name="password" placeholder="Password" required>
<input type="password" name="confirm" placeholder="Confirm Password" required>
<button name="register">Register Admin</button>
</form>

<div class="note">
⚠ After registering admin, protect or delete this file.
</div>

<?php endif; ?>
</div>

</body>
</html>
