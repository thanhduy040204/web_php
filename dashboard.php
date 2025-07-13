<?php
session_start();
include 'config.php';

// Check admin login
if (!isset($_SESSION['admin'])) {
  header("Location: login_admin.php");
  exit();
}

// Fetch products
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ====== XỬ LÝ ĐƠN HÀNG ======
$status = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10;
$start = ($page - 1) * $limit;

$orderQuery = "SELECT * FROM orders WHERE 1 ";
$orderParams = [];

if ($status) {
  $orderQuery .= "AND status = ? ";
  $orderParams[] = $status;
}

if ($search) {
  $orderQuery .= "AND (customer_name LIKE ? OR customer_phone LIKE ?) ";
  $orderParams[] = "%$search%";
  $orderParams[] = "%$search%";
}

$orderQuery .= "ORDER BY id DESC LIMIT $start, $limit";
$orderStmt = $conn->prepare($orderQuery);
$orderStmt->execute($orderParams);
$orders = $orderStmt->fetchAll(PDO::FETCH_ASSOC);

// Count tổng đơn
$countQuery = "SELECT COUNT(*) FROM orders WHERE 1 ";
$countParams = [];

if ($status) {
  $countQuery .= "AND status = ? ";
  $countParams[] = $status;
}

if ($search) {
  $countQuery .= "AND (customer_name LIKE ? OR customer_phone LIKE ?) ";
  $countParams[] = "%$search%";
  $countParams[] = "%$search%";
}

$countStmt = $conn->prepare($countQuery);
$countStmt->execute($countParams);
$totalOrders = $countStmt->fetchColumn();
$totalPages = ceil($totalOrders / $limit);
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

  <!-- Tabs -->
  <ul class="nav nav-tabs mb-3" id="adminTabs">
    <li class="nav-item">
      <a class="nav-link active" href="#" onclick="showTab('products')">📦 Sản phẩm</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" onclick="showTab('orders')">🧾 Đơn hàng</a>
    </li>
  </ul>

  <div class="mb-3">
    <a href="revenue.php" class="btn btn-primary">💰 Xem thống kê doanh thu</a>
    <a href="add_product.php" class="btn btn-success">➕ Thêm sản phẩm</a>
    <a href="logout_admin.php" class="btn btn-secondary">🚪 Đăng xuất</a>
  </div>

  <!-- Sản phẩm -->
  <div id="products" class="tab-content">
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

  <!-- Đơn hàng -->
  <div id="orders" class="tab-content" style="display:none;">
    <h4 class="text-success">🧾 Danh sách đơn hàng</h4>

    <!-- Filter -->
    <form method="get" class="row g-3 mb-3">
      <div class="col-auto">
        <select name="status" onchange="this.form.submit()" class="form-select">
          <option value="">Tất cả trạng thái</option>
          <option value="Đang xử lý" <?php if($status=='Đang xử lý') echo 'selected'; ?>>Đang xử lý</option>
          <option value="Đã thanh toán" <?php if($status=='Đã thanh toán') echo 'selected'; ?>>Đã thanh toán</option>
          <option value="Đã huỷ" <?php if($status=='Đã huỷ') echo 'selected'; ?>>Đã huỷ</option>
        </select>
      </div>
      <div class="col-auto">
        <input type="text" name="search" placeholder="Tìm tên/SĐT..." value="<?php echo $search; ?>" class="form-control">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary">Lọc</button>
      </div>
    </form>

    <!-- Table -->
    <table class="table table-bordered align-middle text-center">
      <thead class="table-success">
        <tr>
          <th>ID</th>
          <th>User_ID</th>
          <th>Khách hàng</th>
          <th>SĐT</th>
          <th>Địa chỉ</th>
          <th>Tổng tiền</th>
          <th>Ngày đặt</th>
          <th>Trạng thái</th>
          <th>Chi tiết</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($orders as $row): ?>
        <tr>
          <td><?= $row['id']; ?></td>
          <td><?= $row['user_id']; ?></td>
          <td><?= $row['customer_name']; ?></td>
          <td><?= $row['customer_phone']; ?></td>
          <td><?= $row['customer_address']; ?></td>
          <td><?= number_format($row['total_price']); ?> VND</td>
          <td><?= $row['order_date']; ?></td>
          <td><?= $row['status']; ?></td>
          <td><a href="order_detail.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Xem</a></td>
          <td>
            <a href="update_status.php?id=<?= $row['id']; ?>&status=Đã thanh toán" class="btn btn-success btn-sm mb-1">Xác nhận</a>
            <a href="update_status.php?id=<?= $row['id']; ?>&status=Đã huỷ" class="btn btn-danger btn-sm mb-1">Huỷ</a>

            <?php if ($row['status'] === 'Đã thanh toán'): ?>
              <a href="export_pdf.php?id=<?= $row['id']; ?>" class="btn btn-secondary btn-sm">PDF</a>
            <?php else: ?>
              <button class="btn btn-secondary btn-sm" disabled title="Chỉ in hoá đơn khi đã thanh toán">PDF</button>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- Pagination -->
    <nav>
      <ul class="pagination justify-content-center">
        <?php for($i=1; $i<=$totalPages; $i++): ?>
        <li class="page-item <?php if($i==$page) echo 'active'; ?>">
          <a class="page-link" href="?page=<?php echo $i; ?>&status=<?php echo $status; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
        </li>
        <?php endfor; ?>
      </ul>
    </nav>
  </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function showTab(tab) {
  document.getElementById('products').style.display = (tab === 'products') ? 'block' : 'none';
  document.getElementById('orders').style.display = (tab === 'orders') ? 'block' : 'none';

  document.querySelectorAll('#adminTabs .nav-link').forEach(link => link.classList.remove('active'));
  const activeLink = Array.from(document.querySelectorAll('#adminTabs .nav-link')).find(link => link.textContent.includes(tab === 'products' ? 'Sản phẩm' : 'Đơn hàng'));
  if (activeLink) activeLink.classList.add('active');
}
</script>
</body>
</html>
