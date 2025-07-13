<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

// Tổng doanh thu
$stmt = $conn->query("SELECT SUM(total_price) as total_revenue FROM orders");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_revenue = $row['total_revenue'];

// Tổng số đơn hàng
$stmt = $conn->query("SELECT COUNT(*) as total_orders FROM orders");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_orders = $row['total_orders'];

// Doanh thu theo tháng
$stmt_month = $conn->query("SELECT DATE_FORMAT(order_date, '%Y-%m') as month, SUM(total_price) as revenue FROM orders GROUP BY month ORDER BY month ASC");
$months = [];
$revenues = [];
while($row = $stmt_month->fetch(PDO::FETCH_ASSOC)){
  $months[] = $row['month'];
  $revenues[] = $row['revenue'];
}

// Sản phẩm bán chạy nhất
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
  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

  <!-- Cards -->
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card border-success position-relative shadow-sm">
        <div class="card-body">
          <h5 class="card-title text-success">Tổng doanh thu</h5>
          <p class="fs-4 text-danger"><?= number_format($total_revenue); ?> VND</p>
          <i class="bi bi-cash-stack card-icon"></i>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-primary position-relative shadow-sm">
        <div class="card-body">
          <h5 class="card-title text-primary">Tổng số đơn hàng</h5>
          <p class="fs-4"><?= $total_orders; ?> đơn</p>
          <i class="bi bi-bag-check card-icon"></i>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-warning position-relative shadow-sm">
        <div class="card-body">
          <h5 class="card-title text-warning">Bán chạy nhất</h5>
          <p class="fs-5"><?= $row_best['name']; ?> (<?= $row_best['total_sold']; ?> sp)</p>
          <i class="bi bi-star-fill card-icon"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Biểu đồ -->
  <h4 class="mt-5">📊 Doanh thu theo tháng</h4>
  <canvas id="revenueChart" height="100" class="mt-3"></canvas>

  <a href="dashboard.php" class="btn btn-secondary mt-4">⬅ Quay lại Dashboard</a>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const ctx = document.getElementById('revenueChart').getContext('2d');
  const revenueChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?= json_encode($months); ?>,
      datasets: [{
        label: 'Doanh thu (VND)',
        data: <?= json_encode($revenues); ?>,
        backgroundColor: 'rgba(40, 167, 69, 0.6)',
        borderColor: 'rgba(40, 167, 69, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: function(context) {
              return context.dataset.label + ': ' + Number(context.parsed.y).toLocaleString() + ' VND';
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function(value) {
              return value.toLocaleString();
            }
          }
        }
      }
    }
  });
</script>
</body>
</html>
