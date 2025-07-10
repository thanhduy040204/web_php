<?php
session_start();
include 'config.php';

// Kiểm tra admin login
if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM order_details od JOIN products p ON od.product_id = p.id WHERE od.order_id = ?");
$stmt->execute([$id]);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết đơn hàng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h1 class="text-success">Chi tiết đơn hàng #<?php echo $id; ?></h1>
  <table class="table">
    <tr>
      <th>Sản phẩm</th>
      <th>Số lượng</th>
      <th>Giá</th>
      <th>Tổng</th>
    </tr>
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
      <td colspan="3"><strong>Tổng cộng</strong></td>
      <td><strong><?php echo number_format($total); ?> VND</strong></td>
    </tr>
  </table>
  <a href="orders.php" class="btn btn-secondary">Quay lại</a>
</div>
</body>
</html>
