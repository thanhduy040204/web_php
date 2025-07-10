<?php
session_start();
include 'config.php';

// Kiểm tra admin login
if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý đơn hàng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container mt-5">
  <h1 class="text-success">Danh sách đơn hàng</h1>
  <?php if(isset($_GET['success'])) { ?>
    <div class="alert alert-success">
      <?php echo $_GET['success']; ?>
    </div>
  <?php } ?>

  <table class="table">
    <tr>
      <th>ID</th>
      <th>Khách hàng</th>
      <th>SĐT</th>
      <th>Địa chỉ</th>
      <th>Tổng tiền</th>
      <th>Ngày đặt</th>
      <th>Chi tiết</th>
      <th>Trạng thái</th>
      <th>Hành động</th>
    </tr>
    <?php
    $stmt = $conn->query("SELECT * FROM orders ORDER BY id DESC");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['customer_name']}</td>
        <td>{$row['customer_phone']}</td>
        <td>{$row['customer_address']}</td>
        <td>".number_format($row['total_price'])." VND</td>
        <td>{$row['order_date']}</td>
        <td><a href='order_detail.php?id={$row['id']}' class='btn btn-primary btn-sm'>Xem</a></td>
        <td>{$row['status']}</td>
        <td>
          <a href='update_status.php?id={$row['id']}&status=Đã thanh toán' class='btn btn-success btn-sm'>Xác nhận thanh toán</a>
        </td>
      </tr>";
    }
    ?>
  </table>
</div>
</body>
</html>
