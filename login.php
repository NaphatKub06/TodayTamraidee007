<?php
include 'db.php';
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // ตรวจสอบรหัสผ่าน (ที่ถูกเข้ารหัส)
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: index.php");
        } else {
            $error = "รหัสผ่านผิด!";
        }
    } else {
        $error = "ไม่พบผู้ใช้นี้!";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="login-body">
    <div class="card-box">
    <div class="login-card">
        <h2>🔐 เข้าสู่ระบบ</h2>
        
        <?php if(isset($error)) echo "<p style='color:red; font-size:14px;'>$error</p>"; ?>

        <form method="post">
            <input type="text" name="username" placeholder="ชื่อผู้ใช้งาน" required>
            <input type="password" name="password" placeholder="รหัสผ่าน" required>
            <button type="submit" name="login">เข้าสู่ระบบ</button>
        </form>

        <p>ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิกที่นี่</a></p>
    </div>

</body>
</html>