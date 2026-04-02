<?php
include __DIR__ . "/includes/db.php";

$msg = "";
$error = "";

if (isset($_POST['book'])) {

    $name       = trim($_POST['name'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $date       = $_POST['date'] ?? '';
    $message    = trim($_POST['message'] ?? '');

    $today = date("Y-m-d");

    if ($name === "" || $phone === "" || $department === "" || $date === "") {
        $error = "All fields are required";
    }
    elseif ($date < $today) {
        $error = "Appointment date cannot be in the past";
    }
    else {

        $stmt = $conn->prepare(
            "INSERT INTO appointments
             (full_name, phone, department, appointment_date, message)
             VALUES (?, ?, ?, ?, ?)"
        );

        if (!$stmt) {
            die("SQL Error: " . $conn->error);
        }

        $stmt->bind_param(
            "sssss",
            $name,
            $phone,
            $department,
            $date,
            $message
        );

        $stmt->execute();
        $stmt->close();

        $msg = "Appointment booked successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book Appointment | Modern Hospital</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    font-family:Segoe UI, sans-serif;
    background:#f4f6f9;
}
.card{
    max-width:450px;
    margin:40px auto;
    background:#fff;
    padding:25px;
    border-radius:10px;
    box-shadow:0 10px 25px rgba(0,0,0,.1);
}
h2{
    text-align:center;
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
    cursor:pointer;
    font-size:16px;
}
.msg{
    background:#e6fff6;
    padding:10px;
    margin-bottom:10px;
    border-radius:6px;
    color:#046b4f;
    text-align:center;
}
.error{
    background:#ffe0e0;
    color:#900;
    padding:10px;
    margin-bottom:10px;
    border-radius:6px;
    text-align:center;
}
.back-btn{
    display:block;
    text-align:center;
    margin-top:15px;
}
.back-btn a{
    text-decoration:none;
    color:#0fb9a8;
    font-weight:600;
}
</style>
</head>

<body>

<div class="card">
<h2>Book Appointment</h2>

<?php if ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($msg): ?>
    <div class="msg"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="text" name="phone" placeholder="Phone Number" required>

    <select name="department" required>
        <option value="">Select Department</option>
        <option>Cardiology</option>
        <option>Neurology</option>
        <option>Pediatrics</option>
        <option>Orthopedics</option>
        <option>General Medicine</option>
    </select>

    <input type="date"
           name="date"
           min="<?= date('Y-m-d') ?>"
           required>

    <textarea name="message" placeholder="Additional Message (optional)"></textarea>

    <button type="submit" name="book">Submit</button>
</form>

<div class="back-btn">
    <a href="index.php">← Back to Home</a>
</div>
</div>

</body>
</html>
