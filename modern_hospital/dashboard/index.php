<?php
include "../includes/db.php";
include "../includes/auth_check.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard | MediCare Hospital</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root{
    --primary:#0fb9a8;
    --dark:#0b1c2d;
    --light:#f4f6f9;
    --white:#ffffff;
    --shadow:0 6px 18px rgba(0,0,0,.08);
}

*{box-sizing:border-box}
body{
    margin:0;
    font-family:Segoe UI, Arial, sans-serif;
    background:var(--light);
    color:#333;
}

/* ================= SIDEBAR ================= */
.sidebar{
    width:240px;
    background:linear-gradient(180deg,#0b1c2d,#102a44);
    height:100vh;
    position:fixed;
    color:#fff;
    padding-top:25px;
}
.sidebar h2{
    text-align:center;
    color:var(--primary);
    margin-bottom:40px;
    letter-spacing:1px;
}
.sidebar a{
    display:flex;
    align-items:center;
    gap:12px;
    color:#cfd8dc;
    padding:14px 28px;
    text-decoration:none;
    font-size:15px;
    transition:.3s;
}
.sidebar a:hover{
    background:var(--primary);
    color:#fff;
}

/* ================= MAIN ================= */
.main{
    margin-left:240px;
    padding:30px;
}

/* ================= TOPBAR ================= */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}
.topbar h1{
    margin:0;
    font-size:24px;
}
.badge{
    background:var(--primary);
    color:#fff;
    padding:8px 18px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}

/* ================= CARDS ================= */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:20px;
    margin-bottom:30px;
}
.card{
    background:var(--white);
    padding:25px;
    border-radius:14px;
    box-shadow:var(--shadow);
    transition:.3s;
}
.card:hover{
    transform:translateY(-4px);
}
.card h3{
    margin:0 0 10px;
    color:var(--primary);
}
.card p{
    margin:0;
    font-size:14px;
    line-height:1.6;
}
.card a{
    display:inline-block;
    margin-top:15px;
    text-decoration:none;
    color:var(--primary);
    font-weight:600;
}

/* ================= INFO ================= */
.info{
    background:var(--white);
    padding:25px;
    border-radius:14px;
    box-shadow:var(--shadow);
}
.info p{
    margin:10px 0;
    line-height:1.6;
}

/* ================= RESPONSIVE ================= */
@media(max-width:768px){
    .sidebar{
        position:relative;
        width:100%;
        height:auto;
    }
    .main{
        margin-left:0;
    }
}
</style>
</head>

<body>

<!-- ================= SIDEBAR ================= -->
<div class="sidebar">
    <h2>MediCare</h2>

    <a href="index.php">🏠 Dashboard</a>
    <a href="patients.php">👤 Patients</a>
    <a href="appointments.php">📅 Appointments</a>

    <?php if($_SESSION['role'] === 'admin'): ?>
        <a href="users.php">🛠 Manage Staff</a>
        <a href="system_logs.php">📊 System Logs</a>
    <?php endif; ?>

    <a href="../auth/logout.php">🚪 Logout</a>
</div>

<!-- ================= MAIN ================= -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>
        <span class="badge"><?= strtoupper($_SESSION['role']) ?></span>
    </div>

    <!-- QUICK ACTION CARDS -->
    <div class="cards">

        <div class="card">
            <h3>Patient Management</h3>
            <p>
                Register new patients, search medical records,
                and update patient information.
            </p>
            <a href="patients.php">Go to Patients →</a>
        </div>

        <div class="card">
            <h3>Appointments</h3>
            <p>
                View appointment requests, approve, cancel,
                or manage schedules efficiently.
            </p>
            <a href="appointments.php">View Appointments →</a>
        </div>

        <?php if($_SESSION['role'] === 'admin'): ?>
        <div class="card">
            <h3>Staff Management</h3>
            <p>
                Create, edit, or delete staff accounts
                and assign system roles.
            </p>
            <a href="users.php">Manage Staff →</a>
        </div>
        <?php endif; ?>

    </div>

    <!-- SYSTEM INFO -->
    <div class="info">
        <h3>System Overview</h3>

        <p>
            This Hospital Management System is designed to securely
            manage patient records, appointments, and staff accounts
            using role-based access control.
        </p>

        <?php if($_SESSION['role'] === 'admin'): ?>
            <p>
                <b>Administrator Access:</b><br>
                You have full control over the system including
                creating, editing, and deleting all records.
            </p>
        <?php else: ?>
            <p>
                <b>Health Officer Access:</b><br>
                You can view and manage patient records
                with limited permissions.
            </p>
        <?php endif; ?>
    </div>

</div>

</body>
</html>
