<?php
session_start(); // เริ่มต้น session ทุกครั้งที่เรียกใช้ไฟล์นี้
$conn = new mysqli("localhost", "root", "", "journal_app");
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ฟังก์ชันตรวจสอบว่าล็อกอินหรือยัง
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}
?>

