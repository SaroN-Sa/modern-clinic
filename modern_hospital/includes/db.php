<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "modern_hospital";

/* ===== SESSION SAFE START ===== */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ===== DATABASE CONNECTION ===== */
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed");
}
