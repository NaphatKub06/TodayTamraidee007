<?php
include 'db.php';
checkLogin();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกประจำวัน</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="navbar">
        <div class="user-greeting">
            👋 สวัสดีครับ! คุณ <?php echo htmlspecialchars($_SESSION['username']); ?> <br/>🪧 ยินดีต้อนรับสู่เว็บไซต์ TodayTamraidee 
        </div>
        <a href="logout.php" class="btn-logout">ออกจากระบบ</a>
    </div>

    <div class="container">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">📅 บันทึกประจำวันของฉัน</h1>
            <a href="write.php" class="btn-primary" style="text-decoration: none; display: inline-block; width: auto; padding: 12px 40px; border-radius: 50px;">
                + เขียนบันทึกใหม่
            </a>
        </div>
        
        <?php
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM entries WHERE user_id = $user_id ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $items = json_decode($row['items'], true);
                ?>
                <div class="card-box">
                    <div class="entry-header">
                        <h3 class="entry-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                        <span class="entry-date">🕒 <?php echo date("d/m/Y H:i", strtotime($row['created_at'])); ?></span>
                    </div>
                    
                    <ul class="checklist">
                        <?php 
                        if ($items) {
                            foreach ($items as $item) {
                                echo "<li>" . htmlspecialchars($item) . "</li>";
                            }
                        }
                        ?>
                    </ul>

                    <div class="action-btn-group">
                        <a href="write.php?edit_id=<?php echo $row['id']; ?>" class="btn-edit">✏️ แก้ไข</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('ยืนยันการลบ?');">🗑️ ลบ</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='card-box' style='text-align:center; color:#888;'>ยังไม่มีบันทึก เริ่มต้นเขียนเรื่องราวของคุณวันนี้เลย!</div>";
        }
        ?>
    </div>

</body>
</html>