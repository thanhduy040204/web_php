<?php
session_start();

// Bao gồm file config
require_once '../config/config.php';

// Kiểm tra đăng nhập admin
if (!isset($_SESSION['admin'])) {
  header("Location: ../views/login.php");
  exit();
}

// Kiểm tra biến đầu vào
if (!isset($_GET['id']) || !isset($_GET['status'])) {
  header("Location: ../views/orders.php?error=Thiếu thông tin đơn hàng");
  exit();
}

$id = $_GET['id'];
$status = $_GET['status'];

// Kiểm tra đơn hàng có tồn tại không
$checkStmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$checkStmt->execute([$id]);
$order = $checkStmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
  header("Location: ../views/orders.php?error=Không tìm thấy đơn hàng #$id");
  exit();
}

// Cập nhật trạng thái đơn hàng
$updateStmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
$updateStmt->execute([$status, $id]);

// Quay về danh sách đơn hàng
header("Location: ../views/orders.php?success=Đơn hàng #$id đã được cập nhật trạng thái thành công");
exit();
?>
