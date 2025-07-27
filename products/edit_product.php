<?php
session_start();
include '../config/config.php';

if(!isset($_SESSION['admin'])){
  header("Location: ../views/login.php");
  exit();
}

if(isset($_GET['id']) && !empty($_GET['id'])){
  $id = $_GET['id'];
} else {
  header("Location: ../views/dashboard.php");
  exit();
}

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$product){
  echo "<div class='alert alert-danger'>Không tìm thấy sản phẩm.</div>";
  exit();
}

if(isset($_POST['update'])){
  $name = $_POST['name'];
  $price = $_POST['price'];
  $desc = $_POST['description'];
  $stock = $_POST['quantity_in_stock'];

  if($_FILES['image']['name']){
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/".$image);
  } else {
    $image = $product['image'];
  }

  $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=?, image=?, quantity_in_stock=? WHERE id=?");
  $stmt->execute([$name, $price, $desc, $image, $stock, $id]);

  header("Location: ../views/dashboard.php?success=Cập nhật sản phẩm thành công");
  exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Sửa sản phẩm</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    .preview-img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 5px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
<div class="container mt-5" style="max-width: 650px;">
  <h2 class="text-success mb-4"><i class="bi bi-pencil-square"></i> Sửa thông tin sản phẩm</h2>

  <div class="card shadow-sm">
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Tên sản phẩm</label>
          <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($product['name']); ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Giá</label>
          <input type="number" name="price" class="form-control" required value="<?= $product['price']; ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Tồn kho (kg)</label>
          <input type="number" name="quantity_in_stock" step="0.1" class="form-control" required value="<?= $product['quantity_in_stock']; ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Mô tả</label>
          <textarea name="description" rows="3" class="form-control"><?= htmlspecialchars($product['description']); ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Ảnh hiện tại</label><br>
          <img src="../assets/images/<?= $product['image']; ?>" class="preview-img" alt="Ảnh hiện tại">
        </div>

        <div class="mb-3">
          <label class="form-label">Đổi ảnh mới (tuỳ chọn)</label>
          <input type="file" name="image" class="form-control" accept="image/*" onchange="previewNewImage(event)">
          <img id="newImagePreview" class="preview-img d-none" alt="Ảnh mới">
        </div>

        <button type="submit" name="update" class="btn btn-success"><i class="bi bi-save"></i> Lưu cập nhật</button>
        <a href="../views/dashboard.php" class="btn btn-secondary">⬅ Quay lại Dashboard</a>
      </form>
    </div>
  </div>
</div>

<script>
  function previewNewImage(event) {
    const img = document.getElementById('newImagePreview');
    img.src = URL.createObjectURL(event.target.files[0]);
    img.classList.remove('d-none');
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
