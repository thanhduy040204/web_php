<?php
session_start();
include 'config.php';

// Check admin login
if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit();
}

// Get product id
$id = $_GET['id'];

// Delete product
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

header("Location: dashboard.php");
exit();
?>
