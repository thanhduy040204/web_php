<?php
session_start();
include 'config.php';

if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit();
}

$id = $_GET['id'];
$status = $_GET['status'];

// Update status in database
$stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->execute([$status, $id]);

// Redirect back with success message
header("Location: orders.php?success=Xác nhận thanh toán đơn hàng #$id thành công");
exit();
?>
