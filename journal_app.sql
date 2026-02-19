-- สร้างฐานข้อมูล (ถ้ายังไม่มี)
CREATE DATABASE IF NOT EXISTS journal_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- เลือกใช้ฐานข้อมูล
USE journal_app;

-- สร้างตารางผู้ใช้งาน
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- สร้างตารางบันทึก (ผูกกับ user_id และเก็บ content เป็น JSON)
CREATE TABLE IF NOT EXISTS entries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    items JSON NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
