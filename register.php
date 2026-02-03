<?php
include 'db.php';

$errorMsg = "";

if (isset($_POST['register'])) {
    // รับค่าและป้องกัน SQL Injection ง่ายๆ
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // --- ส่วนที่ 1: เช็คก่อนว่ามีชื่อนี้หรือยัง ---
    $check_sql = "SELECT id FROM users WHERE username = '$username'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // ถ้าเจอข้อมูล แปลว่าชื่อซ้ำ!
        $errorMsg = "🚫 ชื่อนี้มีคนใช้แล้ว! กรุณาใช้ชื่ออื่น";
    } else {
        // --- ส่วนที่ 2: ถ้าไม่ซ้ำ ค่อยบันทึก ---
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            // สมัครสำเร็จ! เด้งไปหน้า Login พร้อมแจ้งเตือน
            echo "<script>
                alert('สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ');
                window.location = 'login.php';
            </script>";
            exit();
        } else {
            $errorMsg = "เกิดข้อผิดพลาดระบบ: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="login-body">

    <div class="card-box">
    <div class="login-card">
        <h2>📝 สมัครสมาชิกใหม่</h2>
        
        <?php if (!empty($errorMsg)): ?>
            <div style="
                background-color: #ffe6e6; 
                color: #d63031; 
                padding: 10px; 
                border-radius: 8px; 
                margin-bottom: 20px; 
                border: 1px solid #ff7675;
                font-weight: bold;
            ">
                <?php echo $errorMsg; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="username" placeholder="ตั้งชื่อผู้ใช้งาน" required 
                   value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            
            <input type="password" name="password" placeholder="ตั้งรหัสผ่าน" required>
            
            <button type="submit" name="register" style="background-color: #2196F3;">ยืนยันการสมัคร</button>
        </form>

        <p>มีบัญชีอยู่แล้ว? <a href="login.php" style="color: #2196F3;">เข้าสู่ระบบ</a></p>
    </div>

</body>
</html>