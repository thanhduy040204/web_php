<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
  header("Location: orders.php");
  exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM order_details od 
                        JOIN products p ON od.product_id = p.id 
                        WHERE od.order_id = ?");
$stmt->execute([$id]);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết đơn hàng #<?= $id; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    .product-img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
      box-shadow: 0 0 3px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4 text-success"><i class="bi bi-receipt"></i> Chi tiết đơn hàng #<?= $id; ?></h2>

  <div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
      <thead class="table-success">
        <tr>
          <th>Hình</th>
          <th>Sản phẩm</th>
          <th>Số lượng</th>
          <th>Giá</th>
          <th>Tổng</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $subtotal = $row['quantity'] * $row['price'];
          $total += $subtotal;
          echo "<tr>
                  <td><img src='../assets/images/{$row['image']}' class='product-img'></td>
                  <td>{$row['name']}</td>
                  <td>{$row['quantity']}</td>
                  <td>" . number_format($row['price']) . " VND</td>
                  <td class='text-danger fw-bold'>" . number_format($subtotal) . " VND</td>
                </tr>";
        }
        ?>
        <tr>
          <td colspan="4" class="text-end fw-bold">Tổng cộng</td>
          <td class="text-danger fs-5 fw-bold"><?= number_format($total); ?> VND</td>
        </tr>
      </tbody>
    </table>
  </div>

  <a href="orders.php" class="btn btn-secondary mt-3"><i class="bi bi-arrow-left"></i> Quay lại danh sách</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
