<?php
// config/config.php

// Thông tin kết nối CSDL
$host = "localhost";
$dbname = "shopdb";
$username = "root";
$password = "";

try {
    // Tạo kết nối PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Thiết lập chế độ lỗi thành Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Lỗi kết nối: in ra thông báo dễ hiểu, không hiển thị thông tin nhạy cảm
    die("❌ Không thể kết nối CSDL. Vui lòng thử lại sau!");
    // Hoặc: ghi log chi tiết $e->getMessage() vào file nếu cần
}
?>
