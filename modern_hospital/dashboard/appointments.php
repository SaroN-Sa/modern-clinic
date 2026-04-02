<?php
include __DIR__ . "/../includes/db.php";
include __DIR__ . "/../includes/auth_check.php";

/* ================= STATUS UPDATE ================= */
if (isset($_GET['action'], $_GET['id'])) {

    $allowed = ['Approved', 'Cancelled', 'Completed', 'Pending'];

    $id = intval($_GET['id']);
    $status = $_GET['action'];

    if (in_array($status, $allowed)) {
        $stmt = $conn->prepare(
            "UPDATE appointments SET status=? WHERE id=?"
        );

        if ($stmt) {
            $stmt->bind_param("si", $status, $id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

/* ================= FETCH APPOINTMENTS ================= */
$res = $conn->query(
    "SELECT id, full_name, phone, department, appointment_date, status
     FROM appointments
     ORDER BY id DESC"
);

if (!$res) {
    die("SQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Appointments | Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
*{box-sizing:border-box}
body{
    margin:0;
    font-family:Segoe UI, Arial;
    background:#f4f6f9;
    color:#333;
}
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

/* ===== STATUS BADGES ===== */
.status{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    color:#fff;
}
.Pending{background:#f39c12}
.Approved{background:#2ecc71}
.Cancelled{background:#e74c3c}
.Completed{background:#3498db}

/* ===== ACTION BUTTONS ===== */
.btn{
    padding:6px 10px;
    border-radius:6px;
    color:#fff;
    text-decoration:none;
    font-size:13px;
    margin-right:5px;
}
.approve{background:#2ecc71}
.cancel{background:#e74c3c}

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
    <h1>Appointment Management</h1>
    <a href="index.php" class="back-btn">← Back to Dashboard</a>
</div>

<!-- APPOINTMENTS TABLE -->
<div class="card">

<table>
<tr>
<th>Name</th>
<th>Phone</th>
<th>Department</th>
<th>Date</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php if($res->num_rows > 0): ?>
<?php while($a = $res->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($a['full_name']) ?></td>
<td><?= htmlspecialchars($a['phone']) ?></td>
<td><?= htmlspecialchars($a['department']) ?></td>
<td><?= $a['appointment_date'] ?></td>
<td>
    <span class="status <?= $a['status'] ?>">
        <?= $a['status'] ?>
    </span>
</td>
<td>
    <a class="btn approve"
       href="?action=Approved&id=<?= $a['id'] ?>">Approve</a>

    <a class="btn cancel"
       href="?action=Cancelled&id=<?= $a['id'] ?>">Cancel</a>
</td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
<td colspan="6" style="text-align:center;">No appointments found</td>
</tr>
<?php endif; ?>

</table>

</div>
</div>

</body>
</html>
