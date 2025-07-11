<?php
session_start();
include 'config.php';

// Check admin login
if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit();
}

// 1. Tổng doanh thu
$stmt = $conn->query("SELECT SUM(total_price) as total_revenue FROM orders");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_revenue = $row['total_revenue'];

// 2. Tổng số đơn hàng
$stmt = $conn->query("SELECT COUNT(*) as total_orders FROM orders");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_orders = $row['total_orders'];

// 3. Doanh thu theo tháng
$stmt_month = $conn->query("SELECT DATE_FORMAT(order_date, '%Y-%m') as month, SUM(total_price) as revenue FROM orders GROUP BY month ORDER BY month DESC");

// 4. Sản phẩm bán chạy nhất
$stmt_best = $conn->query("SELECT p.name, SUM(od.quantity) as total_sold 
  FROM order_details od 
  JOIN products p ON od.product_id = p.id 
  GROUP BY od.product_id 
  ORDER BY total_sold DESC 
  LIMIT 1");
$row_best = $stmt_best->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thống kê doanh thu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    .card-icon {
      font-size: 40px;
      opacity: 0.2;
      position: absolute;
      top: 10px;
      right: 10px;
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <h1 class="text-success mb-4"><i class="bi bi-bar-chart-line"></i> Thống kê doanh thu</h1>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card border-success position-relative">
        <div class="card-body">
          <h5 class="card-title text-success">Tổng doanh thu</h5>
          <p class="fs-4 text-danger"><?php echo number_format($total_revenue); ?> VND</p>
          <i class="bi bi-cash-stack card-icon"></i>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-primary position-relative">
        <div class="card-body">
          <h5 class="card-title text-primary">Tổng số đơn hàng</h5>
          <p class="fs-4"><?php echo $total_orders; ?> đơn</p>
          <i class="bi bi-bag-check card-icon"></i>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-warning position-relative">
        <div class="card-body">
          <h5 class="card-title text-warning">Bán chạy nhất</h5>
          <p class="fs-5"><?php echo $row_best['name']; ?> (<?php echo $row_best['total_sold']; ?> sp)</p>
          <i class="bi bi-star-fill card-icon"></i>
        </div>
      </div>
    </div>
  </div>

  <h4 class="mt-5">📅 Doanh thu theo tháng</h4>
  <div class="table-responsive">
    <table class="table table-striped table-bordered mt-3 text-center align-middle">
      <thead class="table-success">
        <tr>
          <th>Tháng</th>
          <th>Doanh thu</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while($row = $stmt_month->fetch(PDO::FETCH_ASSOC)){
          echo "<tr>
            <td>{$row['month']}</td>
            <td>".number_format($row['revenue'])." VND</td>
          </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <a href="dashboard.php" class="btn btn-secondary mt-3">⬅ Quay lại Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
