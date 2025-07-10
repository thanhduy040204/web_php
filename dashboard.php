<?php
session_start();
include '../config.php';

if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h1 class="text-success">Dashboard</h1>
  <a href="revenue.php" class="btn btn-info mb-3">Xem thống kê doanh thu</a>

  <a href="add_product.php" class="btn btn-primary mb-3">Thêm sản phẩm</a>
  <table class="table table-bordered">
    <tr>
      <th>ID</th>
      <th>Tên</th>
      <th>Giá</th>
      <th>Mô tả</th>
      <th>Ảnh</th>
      <th>Hành động</th>
    </tr>
    <?php
    $stmt = $conn->query("SELECT * FROM products");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>".number_format($row['price'])." VND</td>
        <td>{$row['description']}</td>
        <td><img src='../images/{$row['image']}' width='50'></td>
        <td>
          <a href='edit_product.php?id={$row['id']}' class='btn btn-warning btn-sm'>Sửa</a>
          <a href='delete_product.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Xoá sản phẩm này?\");'>Xoá</a>
        </td>
      </tr>";
    }
    ?>
  </table>
</div>
</body>
</html>
