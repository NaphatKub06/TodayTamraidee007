<?php
include 'db.php';
checkLogin();

$id = "";
$title = "";
$items = [""]; 
$mode = "create";

if (isset($_GET['edit_id'])) {
    $mode = "edit";
    $id = $_GET['edit_id'];
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM entries WHERE id=$id AND user_id=$user_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $title = $row['title'];
    $items = json_decode($row['items'], true);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เขียนบันทึก</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="navbar">
        <div class="user-greeting">
            📝 โหมดเขียนบันทึก
        </div>
        <a href="index.php" style="color: #666; text-decoration: none; font-weight: bold;">ยกเลิก / กลับหน้าหลัก</a>
    </div>

    <div class="container" style="max-width: 600px;"> <div class="card-box">
            <h2 style="text-align: center; color: #333; margin-bottom: 20px;">
                <?php echo ($mode == 'edit') ? '✏️ แก้ไขบันทึก' : '✨ บันทึกเรื่องราววันนี้'; ?>
            </h2>
            
            <form action="save_entry.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                
                <label style="font-weight: bold; color: #555;">หัวข้อเรื่อง:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" placeholder="เช่น วันนี้ไปคาเฟ่มา..." required style="font-weight: bold;">
                
                <div id="list-container" style="margin-top: 20px;">
                    <label style="font-weight: bold; color: #555;">รายการเหตุการณ์ / สิ่งที่ทำ:</label>
                    <?php foreach ($items as $item): ?>
                        <div class="list-item">
                            <input type="text" name="items[]" value="<?php echo htmlspecialchars($item); ?>" placeholder="• พิมพ์รายการที่นี่..." required>
                            <button type="button" onclick="this.parentElement.remove()" class="btn-del-item">✕</button>
                        </div>
                    <?php endforeach; ?>
                </div>

                <script>
                function addList() {
                    const div = document.createElement('div');
                    div.className = 'list-item';
                    div.innerHTML = `
                        <input type="text" name="items[]" placeholder="• พิมพ์รายการที่นี่..." required>
                        <button type="button" onclick="this.parentElement.remove()" class="btn-del-item">✕</button>
                    `;
                    document.getElementById('list-container').appendChild(div);
                }
                </script>

                <div style="text-align: center; margin: 15px 0;">
                    <button type="button" onclick="addList()" class="btn-add-list">+ เพิ่มรายการอีก</button>
                </div>

                <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

                <button type="submit" class="btn-primary">บันทึกข้อมูล</button>
            </form>
        </div>

    </div>

<script>
function addList() {
    const div = document.createElement('div');
    div.className = 'list-item';
    div.innerHTML = `
        <input type="text" name="items[]" placeholder="ทำอะไรไปบ้าง..." required>
        <button type="button" onclick="this.parentElement.remove()" class="btn-del-item">✕</button>
    `;
    document.getElementById('list-container').appendChild(div);
}
</script>
</body>
</html>