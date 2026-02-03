<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $sql = "INSERT INTO entries (title, content) VALUES ('$title', '$content')";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php"); // บันทึกเสร็จกลับไปหน้าแรก
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "กรุณากรอกข้อมูลให้ครบถ้วน <a href='index.php'>กลับไปหน้าแรก</a>";
    }
}
$conn->close();
?>