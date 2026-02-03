<?php
include 'db.php';
checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $conn->real_escape_string($_POST['title']);
    
    // --- รับค่า items[] ตรงๆ ได้เลย ไม่ต้องวนลูปจับคู่ ---
    $items = isset($_POST['items']) ? $_POST['items'] : [];
    
    // แปลงเป็น JSON (จะได้เป็น ["รายการ1", "รายการ2"] ธรรมดา)
    $json_items = json_encode($items, JSON_UNESCAPED_UNICODE);

    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "UPDATE entries SET title='$title', items='$json_items' WHERE id=$id AND user_id=$user_id";
    } else {
        $sql = "INSERT INTO entries (user_id, title, items) VALUES ('$user_id', '$title', '$json_items')";
    }

    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>