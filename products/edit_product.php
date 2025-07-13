<?php
session_start();
include '../config/config.php';

// Check admin login
if(!isset($_SESSION['admin'])){
  header("Location: ../views/login.php");
  exit();
}

// Check id tồn tại
if(isset($_GET['id']) && !empty($_GET['id'])){
  $id = $_GET['id'];
} else {
  header("Location: ../views/dashboard.php");
  exit();
}

// Get product info
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$product){
  echo "<div class='alert alert-danger'>Không tìm thấy sản phẩm.</div>";
  exit();
}

// Update product
if(isset($_POST['update'])){
  $name = $_POST['name'];
  $price = $_POST['price'];
  $desc = $_POST['description'];

  // Handle image upload
  if($_FILES['image']['name']){
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/".$image);
  } else {
    $image = $product['image'];
  }

  // Update database
  $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=?, image=? WHERE id=?");
  $stmt->execute([$name, $price, $desc, $image, $id]);

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
</head>
<body>
<div class="container mt-5" style="max-width: 600px;">
  <h2 class="text-success mb-4">✏️ Sửa sản phẩm</h2>

  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Tên</label>
      <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Giá</label>
      <input type="number" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Mô tả</label>
      <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Ảnh hiện tại</label><br>
      <img src="../assets/images/<?php echo $product['image']; ?>" alt="Ảnh sản phẩm" style="width:100px; height:100px; object-fit:cover;">
    </div>

    <div class="mb-3">
      <label class="form-label">Đổi ảnh</label>
      <input type="file" name="image" class="form-control">
    </div>

    <button type="submit" name="update" class="btn btn-success">✅ Cập nhật</button>
    <a href="../views/dashboard.php" class="btn btn-secondary">⬅ Quay lại</a>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
