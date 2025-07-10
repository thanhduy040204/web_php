<?php
session_start();
if(!isset($_SESSION['user'])){
  header("Location: login_user.php");
  exit();
}

include 'config.php';

if(isset($_POST['checkout'])){
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $total = 0;

  foreach($_SESSION['cart'] as $item){
    $total += $item['price'] * $item['quantity'];
  }

  // Insert orders table
  $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_phone, customer_address, total_price) VALUES (?, ?, ?, ?)");
  $stmt->execute([$name, $phone, $address, $total]);
  $order_id = $conn->lastInsertId();

  // Insert order_details table
  foreach($_SESSION['cart'] as $id => $item){
    $stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$order_id, $id, $item['quantity'], $item['price']]);
  }

  // Xoá giỏ hàng sau khi đặt
  unset($_SESSION['cart']);
  $success = "Đặt hàng thành công!";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h1 class="text-success">Thanh toán</h1>
  <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
  <form method="post">
    <div class="mb-3">
      <label>Họ tên</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Số điện thoại</label>
      <input type="text" name="phone" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Địa chỉ</label>
      <textarea name="address" class="form-control" required></textarea>
    </div>
    <button type="submit" name="checkout" class="btn btn-success">Đặt hàng</button>
  </form>
  <a href="momo_payment.php" class="btn btn-warning mt-3">Thanh toán MOMO</a>

  <div class="alert alert-info mt-3">
  <h5>💳 Thông tin chuyển khoản</h5>
  <p>Ngân hàng: Vietcombank</p>
  <p>Chủ tài khoản: TRAN THANH DUY</p>
  <p>Số tài khoản: 0383764654</p>
  <p>Nội dung chuyển khoản: <strong>Đặt hàng MorningFruit - [Tên khách hàng]</strong></p>
  <p>Sau khi chuyển khoản, chúng tôi sẽ liên hệ xác nhận đơn hàng.</p>
</div>

</div>
</body>
</html>
