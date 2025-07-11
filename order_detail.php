<?php
session_start();
include 'config.php';

// Kiểm tra admin login
if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit();
}

// Check id tồn tại
if(isset($_GET['id']) && !empty($_GET['id'])){
  $id = $_GET['id'];
} else {
  header("Location: orders.php");
  exit();
}

// Lấy chi tiết đơn hàng
$stmt = $conn->prepare("SELECT * FROM order_details od JOIN products p ON od.product_id = p.id WHERE od.order_id = ?");
$stmt->execute([$id]);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết đơn hàng #<?php echo $id; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h1 class="text-success">📄 Chi tiết đơn hàng #<?php echo $id; ?></h1>
  <table class="table table-bordered text-center align-middle">
    <thead class="table-success">
      <tr>
        <th>Sản phẩm</th>
        <th>Số lượng</th>
        <th>Giá</th>
        <th>Tổng</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $total = 0;
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $subtotal = $row['quantity'] * $row['price'];
        $total += $subtotal;
        echo "<tr>
          <td>{$row['name']}</td>
          <td>{$row['quantity']}</td>
          <td>".number_format($row['price'])." VND</td>
          <td>".number_format($subtotal)." VND</td>
        </tr>";
      }
      ?>
      <tr>
        <td colspan="3" class="text-end fw-bold">Tổng cộng</td>
        <td class="text-danger fw-bold"><?php echo number_format($total); ?> VND</td>
      </tr>
    </tbody>
  </table>
  <a href="orders.php" class="btn btn-secondary">⬅ Quay lại danh sách</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
