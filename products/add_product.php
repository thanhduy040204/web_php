<?php
session_start();
include '../config/config.php';

if(!isset($_SESSION['admin'])){
  header("Location: ../views/login.php");
  exit();
}

if(isset($_POST['add'])){
  $name = $_POST['name'];
  $price = $_POST['price'];
  $desc = $_POST['description'];
  $image = $_FILES['image']['name'];
  move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/".$image);

  $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
  $stmt->execute([$name, $price, $desc, $image]);
  header("Location: ../views/dashboard.php?success=Thêm sản phẩm thành công");
  exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thêm sản phẩm</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-5" style="max-width: 600px;">
  <h2 class="text-success mb-4"><i class="bi bi-plus-circle"></i> Thêm sản phẩm mới</h2>

  <div class="card shadow-sm">
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Tên sản phẩm</label>
          <input type="text" name="name" class="form-control" required placeholder="Nhập tên sản phẩm">
        </div>
        <div class="mb-3">
          <label class="form-label">Giá</label>
          <input type="number" name="price" class="form-control" required placeholder="Nhập giá sản phẩm">
        </div>
        <div class="mb-3">
          <label class="form-label">Mô tả</label>
          <textarea name="description" class="form-control" placeholder="Mô tả chi tiết sản phẩm"></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Ảnh sản phẩm</label>
          <input type="file" name="image" class="form-control" required>
        </div>
        <button type="submit" name="add" class="btn btn-success"><i class="bi bi-save"></i> Lưu sản phẩm</button>
        <a href="../views/dashboard.php" class="btn btn-secondary">⬅ Quay lại Dashboard</a>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
