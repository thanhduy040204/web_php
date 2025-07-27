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

// Xử lý đơn hàng
$status = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 10;
$start = ($page - 1) * $limit;

$orderQuery = "SELECT * FROM orders WHERE 1 ";
$countQuery = "SELECT COUNT(*) FROM orders WHERE 1 ";
$orderParams = [];
$countParams = [];

if ($status) {
  $orderQuery .= "AND status = ? ";
  $countQuery .= "AND status = ? ";
  $orderParams[] = $countParams[] = $status;
}
if ($search) {
  $orderQuery .= "AND (customer_name LIKE ? OR customer_phone LIKE ?) ";
  $countQuery .= "AND (customer_name LIKE ? OR customer_phone LIKE ?) ";
  $orderParams[] = $countParams[] = "%$search%";
  $orderParams[] = $countParams[] = "%$search%";
}

$orderQuery .= "ORDER BY id DESC LIMIT $start, $limit";
$orderStmt = $conn->prepare($orderQuery);
$orderStmt->execute($orderParams);
$orders = $orderStmt->fetchAll(PDO::FETCH_ASSOC);

// Tổng số trang
$countStmt = $conn->prepare($countQuery);
$countStmt->execute($countParams);
$totalOrders = $countStmt->fetchColumn();
$totalPages = ceil($totalOrders / $limit);
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
    .card-icon { font-size: 40px; opacity: 0.1; position: absolute; top: 10px; right: 15px; }
    .tab-content { margin-top: 20px; }
    .badge { font-size: 0.9rem; }
  </style>
</head>
<body>
<div class="container mt-5">
  <h2 class="text-success mb-4"><i class="bi bi-speedometer2"></i> Admin Dashboard</h2>

  <!-- Tabs -->
  <ul class="nav nav-tabs mb-3" id="adminTabs">
    <li class="nav-item"><a class="nav-link <?= $tab == 'products' ? 'active' : '' ?>" href="?tab=products">📦 Sản phẩm</a></li>
    <li class="nav-item"><a class="nav-link <?= $tab == 'lowstock' ? 'active' : '' ?>" href="?tab=lowstock">⚠ Sắp hết hàng</a></li>
    <li class="nav-item"><a class="nav-link <?= $tab == 'orders' ? 'active' : '' ?>" href="?tab=orders">🧾 Đơn hàng</a></li>
  </ul>

  <div class="mb-3 d-flex flex-wrap gap-2">
    <a href="revenue.php" class="btn btn-outline-primary"><i class="bi bi-bar-chart-line"></i> Doanh thu</a>
    <a href="../products/add_product.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Thêm sản phẩm</a>
    <a href="logout_admin.php" class="btn btn-secondary"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
  </div>

  <!-- Tab: Sản phẩm -->
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
  <?php endif; ?>

  <!-- Tab: Sắp hết hàng -->
  <?php if ($tab == 'lowstock'): ?>
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

  <!-- Tab: Đơn hàng -->
  <?php if ($tab == 'orders'): ?>
    <div id="orders" class="tab-content">
      <h4 class="mb-3"><i class="bi bi-receipt-cutoff"></i> Danh sách đơn hàng</h4>
      <form method="get" class="row g-2 mb-3">
        <input type="hidden" name="tab" value="orders">
        <div class="col-auto">
          <select name="status" onchange="this.form.submit()" class="form-select">
            <option value="">Tất cả trạng thái</option>
            <option value="Đang xử lý" <?= $status == 'Đang xử lý' ? 'selected' : '' ?>>Đang xử lý</option>
            <option value="Đã thanh toán" <?= $status == 'Đã thanh toán' ? 'selected' : '' ?>>Đã thanh toán</option>
            <option value="Đã huỷ" <?= $status == 'Đã huỷ' ? 'selected' : '' ?>>Đã huỷ</option>
          </select>
        </div>
        <div class="col-auto">
          <input type="text" name="search" class="form-control" placeholder="Tìm tên/SĐT..." value="<?= htmlspecialchars($search); ?>">
        </div>
        <div class="col-auto">
          <button class="btn btn-primary">Lọc</button>
        </div>
      </form>

      <table class="table table-bordered align-middle text-center">
        <thead class="table-success">
          <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>SĐT</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Chi tiết</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($orders as $o): ?>
          <tr>
            <td><?= $o['id']; ?></td>
            <td><?= $o['customer_name']; ?></td>
            <td><?= $o['customer_phone']; ?></td>
            <td class="text-danger"><?= number_format($o['total_price']); ?> VND</td>
            <td>
              <?php
              $badgeClass = match($o['status']) {
                'Đã thanh toán' => 'success',
                'Đã huỷ' => 'danger',
                default => 'warning'
              };
              ?>
              <span class="badge bg-<?= $badgeClass; ?>"><?= $o['status']; ?></span>
            </td>
            <td><a href="order_detail.php?id=<?= $o['id']; ?>" class="btn btn-outline-primary btn-sm">Chi tiết</a></td>
            <td>
              <a href="../controllers/update_status.php?id=<?= $o['id']; ?>&status=Đã thanh toán" class="btn btn-success btn-sm mb-1"><i class="bi bi-check2-circle"></i></a>
              <a href="../controllers/update_status.php?id=<?= $o['id']; ?>&status=Đã huỷ" class="btn btn-danger btn-sm mb-1"><i class="bi bi-x-circle"></i></a>
              <a href="../controllers/export_pdf.php?id=<?= $o['id']; ?>" class="btn btn-secondary btn-sm <?= $o['status'] !== 'Đã thanh toán' ? 'disabled' : '' ?>"><i class="bi bi-file-earmark-pdf"></i></a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <nav>
        <ul class="pagination justify-content-center">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a class="page-link" href="?tab=orders&page=<?= $i ?>&status=<?= $status ?>&search=<?= $search ?>"><?= $i ?></a>
          </li>
          <?php endfor; ?>
        </ul>
      </nav>
    </div>
  <?php endif; ?>
</div>
</body>
</html>
