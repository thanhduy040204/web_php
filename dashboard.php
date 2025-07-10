<?php
session_start();
include 'config.php';

// Check admin login
if(!isset($_SESSION['admin'])){
  header("Location: login_admin.php");
  exit();
}

// Fetch products
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - MorningFruit</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h2 class="text-success mb-4">📊 Dashboard Admin</h2>

  <div class="mb-3">
    <a href="revenue.php" class="btn btn-primary">💰 Xem thống kê doanh thu</a>
    <a href="add_product.php" class="btn btn-success">➕ Thêm sản phẩm</a>
    <a href="logout_admin.php" class="btn btn-secondary">🚪 Đăng xuất</a>
  </div>

  <table class="table table-bordered table-hover align-middle text-center">
    <thead class="table-success">
      <tr>
        <th>Ảnh</th>
        <th>Tên</th>
        <th>Giá</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($products as $p): ?>
      <tr>
        <td><img src="images/<?php echo $p['image']; ?>" style="width:50px; height:50px; object-fit:cover;"></td>
        <td class="text-start"><?php echo $p['name']; ?></td>
        <td><?php echo number_format($p['price']); ?> VND</td>
        <td>
          <a href="edit_product.php?id=<?php echo $p['id']; ?>" class="btn btn-warning btn-sm">✏️ Sửa</a>
          <a href="delete_product.php?id=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn chắc chắn xoá?');">🗑️ Xoá</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
