<?php
include "../includes/db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* PREVENT RE-LOGIN */
if(isset($_SESSION['user_id'])){
    header("Location: ../dashboard/index.php");
    exit;
}

$error = "";

if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if($username === "" || $password === ""){
        $error = "All fields are required";
    } else {
        $stmt = $conn->prepare(
            "SELECT id,password,role FROM users WHERE username=? LIMIT 1"
        );
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows === 1){
            $stmt->bind_result($id,$hash,$role);
            $stmt->fetch();

            if(password_verify($password,$hash)){
                $_SESSION['user_id']  = $id;
                $_SESSION['username'] = $username;
                $_SESSION['role']     = $role;

                header("Location: ../dashboard/index.php");
                exit;
            } else {
                $error = "Invalid username or password";
            }
        } else {
            $error = "Invalid username or password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Staff Login | MediCare</title>
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
.login-box{
    background:#fff;
    width:380px;
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
.error{
    background:#ffe0e0;
    color:#900;
    padding:10px;
    margin-bottom:10px;
    border-radius:6px;
    text-align:center;
}
.back{
    text-align:center;
    margin-top:15px;
}
.back a{
    text-decoration:none;
    color:#0fb9a8;
    font-weight:600;
}
</style>
</head>

<body>

<div class="login-box">
<h2>Staff Portal Login</h2>

<?php if($error): ?>
<div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>

<div class="back">
<a href="../index.php">← Back to Website</a>
</div>
</div>

</body>
</html>
