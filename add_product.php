<?php
session_start();
include 'config.php';

if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit();
}

if(isset($_POST['add'])){
  $name = $_POST['name'];
  $price = $_POST['price'];
  $desc = $_POST['description'];
  $image = $_FILES['image']['name'];
  move_uploaded_file($_FILES['image']['tmp_name'], "../images/".$image);

  $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
  $stmt->execute([$name, $price, $desc, $image]);
  header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thêm sản phẩm</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Thêm sản phẩm</h2>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Tên</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Giá</label>
      <input type="number" name="price" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Mô tả</label>
      <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="mb-3">
      <label>Ảnh</label>
      <input type="file" name="image" class="form-control" required>
    </div>
    <button type="submit" name="add" class="btn btn-success">Thêm</button>
  </form>
</div>
</body>
</html>
