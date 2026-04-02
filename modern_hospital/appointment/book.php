<?php
include "../includes/db.php";

$msg = "";

if(isset($_POST['book'])){
    $name  = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $dept  = trim($_POST['department']);
    $date  = $_POST['date'];
    $note  = trim($_POST['note']);

    if($name && $phone && $dept && $date){
        $stmt = $conn->prepare(
          "INSERT INTO appointments 
          (name,phone,department,appointment_date,note,status)
          VALUES (?,?,?,?,?, 'Pending')"
        );
        $stmt->bind_param("sssss",$name,$phone,$dept,$date,$note);
        $stmt->execute();
        $msg = "Appointment booked successfully!";
    } else {
        $msg = "All fields are required";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Book Appointment</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{font-family:Segoe UI;background:#f4f6f9}
.card{max-width:450px;margin:40px auto;background:#fff;
padding:25px;border-radius:10px}
input,select,textarea,button{
width:100%;padding:10px;margin:8px 0}
button{
background:#0fb9a8;color:#fff;border:none;
border-radius:6px
}
.msg{background:#e6fff6;padding:10px;margin-bottom:10px}
</style>
</head>

<body>

<div class="card">
<h2>Book Appointment</h2>

<?php if($msg): ?>
<div class="msg"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<form method="POST">
<input name="name" placeholder="Full Name" required>
<input name="phone" placeholder="Phone Number" required>

<select name="department" required>
<option value="">Select Department</option>
<option>Cardiology</option>
<option>Neurology</option>
<option>Pediatrics</option>
<option>Orthopedics</option>
<option>General Medicine</option>
</select>

<input type="date" name="date" required>
<textarea name="note" placeholder="Additional Notes"></textarea>

<button name="book">Submit</button>
</form>
</div>

</body>
</html>
