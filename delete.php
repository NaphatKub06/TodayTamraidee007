<?php
include 'db.php';
checkLogin();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    
    // ลบโดยเช็คว่าเป็นของ user คนนั้นจริงๆ
    $sql = "DELETE FROM entries WHERE id=$id AND user_id=$user_id";
    $conn->query($sql);
}
header("Location: index.php");
?>