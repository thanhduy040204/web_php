<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['admin'])) {
  header("Location: ../views/login.php");
  exit();
}

if (isset($_POST['add'])) {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $desc = $_POST['description'];
  $image = $_FILES['image']['name'];
  move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/" . $image);

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
  <title>Thêm sản phẩm mới</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    .form-label i {
      margin-right: 5px;
    }
  </style>
</head>
<body>
<div class="container mt-5" style="max-width: 700px;">
  <h2 class="text-success mb-4 text-center"><i class="bi bi-plus-circle"></i> Thêm sản phẩm mới</h2>

  <div class="card shadow-sm">
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label"><i class="bi bi-tag-fill text-success"></i> Tên sản phẩm</label>
          <input type="text" name="name" class="form-control" required placeholder="Nhập tên sản phẩm">
        </div>
        <div class="mb-3">
          <label class="form-label"><i class="bi bi-currency-dollar text-success"></i> Giá sản phẩm</label>
          <input type="number" name="price" class="form-control" required placeholder="Nhập giá (VND)">
        </div>
        <div class="mb-3">
          <label class="form-label"><i class="bi bi-file-text text-success"></i> Mô tả</label>
          <textarea name="description" class="form-control" rows="4" placeholder="Mô tả chi tiết sản phẩm..."></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label"><i class="bi bi-image text-success"></i> Ảnh sản phẩm</label>
          <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>
        <div class="d-flex justify-content-between">
          <button type="submit" name="add" class="btn btn-success">
            <i class="bi bi-check2-circle"></i> Lưu sản phẩm
          </button>
          <a href="../views/dashboard.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle"></i> Quay lại Dashboard
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
