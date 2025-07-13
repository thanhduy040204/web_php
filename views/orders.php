<?php
session_start();
include '../config/config.php'; // đúng đường dẫn đến config.php

// Check admin login
if(!isset($_SESSION['admin'])){
  header("Location: login.php"); // login.php nằm trong cùng thư mục views/
  exit();
}

// Search & filter
$status = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';

// Pagination
$limit = 10;
$page = $_GET['page'] ?? 1;
$start = ($page - 1) * $limit;

// Query dữ liệu đơn hàng
$query = "SELECT * FROM orders WHERE 1 ";
$params = [];

if($status){
  $query .= "AND status = ? ";
  $params[] = $status;
}
if($search){
  $query .= "AND (customer_name LIKE ? OR customer_phone LIKE ?) ";
  $params[] = "%$search%";
  $params[] = "%$search%";
}

$query .= "ORDER BY id DESC LIMIT $start, $limit";
$stmt = $conn->prepare($query);
$stmt->execute($params);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Đếm tổng số đơn
$countQuery = "SELECT COUNT(*) FROM orders WHERE 1 ";
$countParams = [];

if($status){
  $countQuery .= "AND status = ? ";
  $countParams[] = $status;
}
if($search){
  $countQuery .= "AND (customer_name LIKE ? OR customer_phone LIKE ?) ";
  $countParams[] = "%$search%";
  $countParams[] = "%$search%";
}

$countStmt = $conn->prepare($countQuery);
$countStmt->execute($countParams);
$total = $countStmt->fetchColumn();
$total_pages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý đơn hàng</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h1 class="text-success mb-4">📦 Danh sách đơn hàng</h1>

  <!-- Bộ lọc -->
  <form method="get" class="row g-3 mb-3">
    <div class="col-auto">
      <select name="status" onchange="this.form.submit()" class="form-select">
        <option value="">Tất cả trạng thái</option>
        <option value="Đang xử lý" <?= ($status == 'Đang xử lý') ? 'selected' : '' ?>>Đang xử lý</option>
        <option value="Đã thanh toán" <?= ($status == 'Đã thanh toán') ? 'selected' : '' ?>>Đã thanh toán</option>
        <option value="Đã huỷ" <?= ($status == 'Đã huỷ') ? 'selected' : '' ?>>Đã huỷ</option>
      </select>
    </div>
    <div class="col-auto">
      <input type="text" name="search" placeholder="Tìm tên/SĐT..." value="<?= htmlspecialchars($search) ?>" class="form-control">
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary">Lọc</button>
    </div>
  </form>

  <!-- Thông báo -->
  <?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
  <?php endif; ?>

  <!-- Bảng đơn hàng -->
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
        <th>Hành động</th>
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
          <a href="../controllers/update_status.php?id=<?= $row['id']; ?>&status=Đã thanh toán" class="btn btn-success btn-sm mb-1">Xác nhận</a>
          <a href="../controllers/update_status.php?id=<?= $row['id']; ?>&status=Đã huỷ" class="btn btn-danger btn-sm mb-1">Huỷ</a>
          <a href="../controllers/export_pdf.php?id=<?= $row['id']; ?>" class="btn btn-secondary btn-sm">PDF</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Phân trang -->
  <nav>
    <ul class="pagination justify-content-center">
      <?php for($i = 1; $i <= $total_pages; $i++): ?>
      <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $i ?>&status=<?= urlencode($status) ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
      </li>
      <?php endfor; ?>
    </ul>
  </nav>
</div>
</body>
</html>
