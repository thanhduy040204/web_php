<?php
session_start();
include 'config.php';

// Check admin login
if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit();
}

// Search & filter
$status = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Build query with conditions
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

// Count total for pagination
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

  <!-- Success message -->
  <?php if(isset($_GET['success'])) { ?>
    <div class="alert alert-success">
      <?php echo $_GET['success']; ?>
    </div>
  <?php } ?>

  <!-- Orders table -->
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
      <?php foreach($orders as $row){ ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['user_id']; ?></td>
        <td><?php echo $row['customer_name']; ?></td>
        <td><?php echo $row['customer_phone']; ?></td>
        <td><?php echo $row['customer_address']; ?></td>
        <td><?php echo number_format($row['total_price']); ?> VND</td>
        <td><?php echo $row['order_date']; ?></td>
        <td><?php echo $row['status']; ?></td>
        <td><a href="order_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Xem</a></td>
        <td>
          <a href="update_status.php?id=<?php echo $row['id']; ?>&status=Đã thanh toán" class="btn btn-success btn-sm mb-1">Xác nhận</a>
          <a href="update_status.php?id=<?php echo $row['id']; ?>&status=Đã huỷ" class="btn btn-danger btn-sm mb-1">Huỷ</a>
          <a href="export_pdf.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary btn-sm">PDF</a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

  <!-- Pagination -->
  <nav>
    <ul class="pagination justify-content-center">
      <?php for($i=1;$i<=$total_pages;$i++){ ?>
      <li class="page-item <?php if($i==$page) echo 'active'; ?>">
        <a class="page-link" href="?page=<?php echo $i; ?>&status=<?php echo $status; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
      </li>
      <?php } ?>
    </ul>
  </nav>

</div>
</body>
</html>
