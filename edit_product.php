<?php
session_start();
include '../config.php';

if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['update'])){
  $name = $_POST['name'];
  $price = $_POST['price'];
  $desc = $_POST['description'];

  if($_FILES['image']['name']){
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../images/".$image);
  }else{
    $image = $product['image'];
  }

  $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=?, image=? WHERE id=?");
  $stmt->execute([$name, $price, $desc, $image, $id]);
  header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Sửa sản phẩm</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Sửa sản phẩm</h2>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Tên</label>
      <input type="text" name="name" class="form-control" value="<?php echo $product['name']; ?>" required>
    </div>
    <div class="mb-3">
      <label>Giá</label>
      <input type="number" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
    </div>
    <div class="mb-3">
      <label>Mô tả</label>
      <textarea name="description" class="form-control"><?php echo $product['description']; ?></textarea>
    </div>
    <div class="mb-3">
      <label>Ảnh hiện tại</label><br>
      <img src="../images/<?php echo $product['image']; ?>" width="100">
    </div>
    <div class="mb-3">
      <label>Đổi ảnh</label>
      <input type="file" name="image" class="form-control">
    </div>
    <button type="submit" name="update" class="btn btn-success">Cập nhật</button>
  </form>
</div>
</body>
</html>
