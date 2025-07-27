<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['admin'])) {
  header("Location: login_admin.php");
  exit();
}

$tab = $_GET['tab'] ?? 'products';

// Lấy danh sách sản phẩm
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Lấy sản phẩm sắp hết (< 10kg)
$stmtLowStock = $conn->prepare("SELECT * FROM products WHERE quantity_in_stock < 10 ORDER BY quantity_in_stock ASC");
$stmtLowStock->execute();
$lowStockProducts = $stmtLowStock->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    .tab-content { margin-top: 20px; }
    .badge { font-size: 0.9rem; }
  </style>
</head>
<body>
<div class="container mt-5">
  <h2 class="text-success mb-4"><i class="bi bi-speedometer2"></i> Admin Dashboard</h2>

  <ul class="nav nav-tabs mb-3">
    <li class="nav-item"><a class="nav-link <?= $tab == 'products' ? 'active' : '' ?>" href="?tab=products">📦 Sản phẩm</a></li>
    <li class="nav-item"><a class="nav-link <?= $tab == 'lowstock' ? 'active' : '' ?>" href="?tab=lowstock">⚠ Sắp hết hàng</a></li>
    <li class="nav-item"><a class="nav-link" href="orders.php">🧾 Đơn hàng</a></li>
  </ul>

  <div class="mb-3 d-flex flex-wrap gap-2">
    <a href="revenue.php" class="btn btn-outline-primary"><i class="bi bi-bar-chart-line"></i> Doanh thu</a>
    <a href="../products/add_product.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Thêm sản phẩm</a>
    <a href="logout_admin.php" class="btn btn-secondary"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
  </div>

  <?php if ($tab == 'products'): ?>
    <div id="products" class="tab-content">
      <table class="table table-hover align-middle text-center border">
        <thead class="table-light">
          <tr>
            <th>Ảnh</th>
            <th class="text-start">Tên</th>
            <th>Giá</th>
            <th>Tồn kho</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($products as $p): ?>
          <tr>
            <td><img src="../assets/images/<?= $p['image']; ?>" style="width:50px; height:50px; object-fit:cover;"></td>
            <td class="text-start"><?= $p['name']; ?></td>
            <td class="text-danger"><?= number_format($p['price']); ?> VND</td>
            <td><?= $p['quantity_in_stock']; ?> kg</td>
            <td>
              <a href="../products/edit_product.php?id=<?= $p['id']; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
              <a href="../controllers/delete_product.php?id=<?= $p['id']; ?>" onclick="return confirm('Bạn chắc chắn xoá?');" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php elseif ($tab == 'lowstock'): ?>
    <div id="lowstock" class="tab-content">
      <h4 class="mb-3 text-danger"><i class="bi bi-exclamation-triangle-fill"></i> Sản phẩm sắp hết (dưới 10kg)</h4>
      <?php if (count($lowStockProducts) == 0): ?>
        <div class="alert alert-success">✅ Hiện tại tất cả sản phẩm đều đủ hàng.</div>
      <?php else: ?>
        <table class="table table-bordered align-middle text-center">
          <thead class="table-warning">
            <tr>
              <th>Ảnh</th>
              <th class="text-start">Tên</th>
              <th>Giá</th>
              <th>Còn lại</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($lowStockProducts as $p): ?>
            <tr>
              <td><img src="../assets/images/<?= $p['image']; ?>" style="width:50px; height:50px; object-fit:cover;"></td>
              <td class="text-start"><?= $p['name']; ?></td>
              <td class="text-danger"><?= number_format($p['price']); ?> VND</td>
              <td class="text-danger fw-bold"><?= $p['quantity_in_stock']; ?> kg</td>
              <td>
                <a href="../products/edit_product.php?id=<?= $p['id']; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>
</body>
</html>