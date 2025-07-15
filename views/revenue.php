<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

// Xử lý bộ lọc
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$chartType = isset($_GET['type']) ? $_GET['type'] : 'line';

$whereClause = "WHERE YEAR(order_date) = ?";
$params = [$year];

// Tổng doanh thu
$stmt = $conn->query("SELECT SUM(total_price) as total_revenue FROM orders");
$total_revenue = $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'];

// Tổng đơn hàng
$stmt = $conn->query("SELECT COUNT(*) as total_orders FROM orders");
$total_orders = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];

// Doanh thu theo tháng
$stmt = $conn->prepare("SELECT DATE_FORMAT(order_date, '%Y-%m') as month, SUM(total_price) as revenue 
  FROM orders $whereClause 
  GROUP BY month ORDER BY month ASC");
$stmt->execute($params);
$months = [];
$revenues = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { background: #f8f9fa; }
    .card-icon {
      font-size: 40px;
      opacity: 0.15;
      position: absolute;
      top: 10px;
      right: 15px;
    }
    .filter-form select {
      max-width: 200px;
      display: inline-block;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <h1 class="text-success mb-4"><i class="bi bi-bar-chart-line-fill"></i> Thống kê doanh thu</h1>

  <div class="row g-4 mb-4">
    <div class="col-md-4">
      <div class="card border-success shadow-sm position-relative">
        <div class="card-body">
          <h5 class="card-title text-success">Tổng doanh thu</h5>
          <p class="fs-4 text-danger"><?= number_format($total_revenue); ?> VND</p>
          <i class="bi bi-cash-stack card-icon"></i>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-primary shadow-sm position-relative">
        <div class="card-body">
          <h5 class="card-title text-primary">Tổng đơn hàng</h5>
          <p class="fs-4"><?= $total_orders; ?> đơn</p>
          <i class="bi bi-bag-check card-icon"></i>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-warning shadow-sm position-relative">
        <div class="card-body">
          <h5 class="card-title text-warning">Sản phẩm bán chạy</h5>
          <p class="fs-5"><?= $row_best['name']; ?> (<?= $row_best['total_sold']; ?> sp)</p>
          <i class="bi bi-star-fill card-icon"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Bộ lọc -->
  <form method="get" class="mb-4 d-flex justify-content-between align-items-center filter-form">
    <div>
      <label class="me-2">Chọn năm:</label>
      <select name="year" onchange="this.form.submit()">
        <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
          <option value="<?= $y ?>" <?= $y == $year ? 'selected' : '' ?>><?= $y ?></option>
        <?php endfor; ?>
      </select>
    </div>
    <div>
      <label class="me-2">Kiểu biểu đồ:</label>
      <select name="type" onchange="this.form.submit()">
        <option value="line" <?= $chartType == 'line' ? 'selected' : '' ?>>Line</option>
        <option value="bar" <?= $chartType == 'bar' ? 'selected' : '' ?>>Bar</option>
        <option value="area" <?= $chartType == 'area' ? 'selected' : '' ?>>Area</option>
      </select>
    </div>
  </form>

  <!-- Biểu đồ -->
  <h4 class="mb-3"><i class="bi bi-graph-up-arrow"></i> Doanh thu theo tháng</h4>
  <canvas id="revenueChart" height="100"></canvas>

  <a href="dashboard.php" class="btn btn-secondary mt-4"><i class="bi bi-arrow-left-circle"></i> Quay lại Dashboard</a>
</div>

<script>
  const ctx = document.getElementById('revenueChart').getContext('2d');
  const chartType = '<?= $chartType ?>' === 'area' ? 'line' : '<?= $chartType ?>';

  const chart = new Chart(ctx, {
    type: chartType,
    data: {
      labels: <?= json_encode($months); ?>,
      datasets: [{
        label: 'Doanh thu (VND)',
        data: <?= json_encode($revenues); ?>,
        backgroundColor: 'rgba(40, 167, 69, 0.4)',
        borderColor: 'rgba(40, 167, 69, 1)',
        fill: '<?= $chartType === "area" ? "origin" : "false" ?>',
        tension: 0.4,
        pointBackgroundColor: '#28a745',
        pointBorderColor: '#fff',
        pointRadius: 5,
      }]
    },
    options: {
      responsive: true,
      animation: {
        duration: 1500,
        easing: 'easeOutQuart'
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: context => context.dataset.label + ': ' + context.parsed.y.toLocaleString() + ' VND'
          }
        },
        legend: {
          display: true
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: value => value.toLocaleString()
          }
        }
      }
    }
  });
</script>

</body>
</html>
