<?php
include "../includes/db.php";
include "../includes/auth_check.php";

$msg = "";

/* ================= PATIENT REGISTRATION ================= */
if(isset($_POST['register_patient'])){
    $pid   = trim($_POST['patient_id']);
    $name  = trim($_POST['full_name']);
    $age   = intval($_POST['age']);
    $sex   = $_POST['sex'];
    $phone = trim($_POST['phone']);
    $blood = trim($_POST['blood_group']);
    $cond  = trim($_POST['medical_condition']);

    if($pid && $name && $age && $sex){
        $stmt = $conn->prepare(
            "INSERT INTO patients 
            (patient_id,full_name,age,sex,phone,blood_group,medical_condition)
            VALUES (?,?,?,?,?,?,?)"
        );
        $stmt->bind_param("ssissss",
            $pid,$name,$age,$sex,$phone,$blood,$cond
        );
        $stmt->execute();
        $msg = "Patient registered successfully";
    } else {
        $msg = "Please fill all required fields";
    }
}

/* ================= PATIENT SEARCH ================= */
$results = [];
if(isset($_GET['search'])){
    $term = "%".trim($_GET['query'])."%";

    $stmt = $conn->prepare(
        "SELECT * FROM patients 
         WHERE patient_id LIKE ? OR full_name LIKE ?"
    );
    $stmt->bind_param("ss",$term,$term);
    $stmt->execute();
    $res = $stmt->get_result();
    $results = $res->fetch_all(MYSQLI_ASSOC);

    /* AUDIT LOG */
    $log = $conn->prepare(
        "INSERT INTO audit_logs (username,role,action,searched_value)
         VALUES (?,?,?,?)"
    );
    $action = "Patient Search";
    $log->bind_param("ssss",
        $_SESSION['username'],$_SESSION['role'],$action,$_GET['query']
    );
    $log->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Patients | Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    margin:0;
    font-family:Segoe UI, Arial;
    background:#f4f6f9;
}
.main{
    margin-left:230px;
    padding:30px;
}
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
    text-decoration:none;
    background:#34495e;
    color:#fff;
    padding:10px 18px;
    border-radius:6px;
    font-size:14px;
}
.card{
    background:#fff;
    padding:25px;
    border-radius:10px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
    margin-bottom:30px;
}
h2{
    margin-top:0;
    margin-bottom:15px;
    color:#0fb9a8;
}
input,select,textarea,button{
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
table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}
th,td{
    padding:10px;
    border-bottom:1px solid #ddd;
}
th{
    background:#0fb9a8;
    color:#fff;
}
.msg{
    background:#e6fff6;
    padding:12px;
    border-left:5px solid #0fb9a8;
    margin-bottom:15px;
}
</style>
</head>

<body>

<div class="main">

<!-- HEADER -->
<div class="header">
    <h1>Patient Management</h1>
    <a href="index.php" class="back-btn">← Back to Dashboard</a>
</div>

<!-- PATIENT REGISTRATION -->
<div class="card">
<h2>Register New Patient</h2>

<?php if($msg): ?>
<div class="msg"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<form method="POST">
<input name="patient_id" placeholder="Patient ID" required>
<input name="full_name" placeholder="Full Name" required>
<input type="number" name="age" placeholder="Age" required>

<select name="sex" required>
    <option value="">Select Sex</option>
    <option>Male</option>
    <option>Female</option>
</select>

<input name="phone" placeholder="Phone Number">
<input name="blood_group" placeholder="Blood Group">
<textarea name="medical_condition" placeholder="Medical Condition"></textarea>

<button name="register_patient">Register Patient</button>
</form>
</div>

<!-- PATIENT SEARCH -->
<div class="card">
<h2>Search Patient</h2>

<form method="GET">
<input name="query" placeholder="Patient ID or Full Name" required>
<button name="search">Search</button>
</form>

<?php if($results): ?>
<table>
<tr>
<th>Patient ID</th>
<th>Full Name</th>
<th>Age</th>
<th>Sex</th>

<?php if($_SESSION['role']==='admin'): ?>
<th>Phone</th>
<th>Blood Group</th>
<th>Medical Condition</th>
<?php endif; ?>
</tr>

<?php foreach($results as $r): ?>
<tr>
<td><?= htmlspecialchars($r['patient_id']) ?></td>
<td><?= htmlspecialchars($r['full_name']) ?></td>
<td><?= $r['age'] ?></td>
<td><?= $r['sex'] ?></td>

<?php if($_SESSION['role']==='admin'): ?>
<td><?= htmlspecialchars($r['phone']) ?></td>
<td><?= htmlspecialchars($r['blood_group']) ?></td>
<td><?= htmlspecialchars($r['medical_condition']) ?></td>
<?php endif; ?>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

</div>

</div>
</body>
</html>
