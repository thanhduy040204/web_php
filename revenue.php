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
$stmt = $conn->query("SELECT DATE_FORMAT(order_date, '%Y-%m') as month, SUM(total_price) as revenue FROM orders GROUP BY month ORDER BY month DESC");

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h1 class="text-success">Thống kê doanh thu</h1>

  <div class="card mb-3">
    <div class="card-body">
      <h5>Tổng doanh thu</h5>
      <p class="text-danger fs-4"><?php echo number_format($total_revenue); ?> VND</p>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <h5>Tổng số đơn hàng</h5>
      <p class="text-primary fs-4"><?php echo $total_orders; ?> đơn</p>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <h5>Sản phẩm bán chạy nhất</h5>
      <p class="fs-5"><?php echo $row_best['name']; ?> (<?php echo $row_best['total_sold']; ?> sản phẩm)</p>
    </div>
  </div>

  <h4 class="mt-4">Doanh thu theo tháng</h4>
  <table class="table">
    <tr>
      <th>Tháng</th>
      <th>Doanh thu</th>
    </tr>
    <?php
    $stmt->execute(); // re-execute
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      echo "<tr>
        <td>{$row['month']}</td>
        <td>".number_format($row['revenue'])." VND</td>
      </tr>";
    }
    ?>
  </table>
</div>
</body>
</html>
