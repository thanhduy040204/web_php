<?php
session_start();
if(!isset($_SESSION['user'])){
  header("Location: login_user.php");
  exit();
}

include 'config.php';

if(empty($_SESSION['cart'])){
  header("Location: cart.php");
  exit();
}

if(isset($_POST['checkout'])){
  $name = trim($_POST['name']);
  $phone = trim($_POST['phone']);
  $address = trim($_POST['address']);
  $total = 0;

  // Validate inputs
  if(empty($name) || empty($phone) || empty($address)){
    $error = "Vui lòng nhập đầy đủ thông tin.";
  } else {
    // Tính tổng
    foreach($_SESSION['cart'] as $item){
      $total += $item['price'] * $item['quantity'];
    }

    // Insert vào orders table
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_phone, customer_address, total_price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $phone, $address, $total]);
    $order_id = $conn->lastInsertId();

    // Insert vào order_details table
    foreach($_SESSION['cart'] as $id => $item){
      $stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
      $stmt->execute([$order_id, $id, $item['quantity'], $item['price']]);
    }

    // Xoá giỏ hàng sau khi đặt
    unset($_SESSION['cart']);
    $success = "🎉 Đặt hàng thành công! Chúng tôi sẽ liên hệ bạn sớm.";
  }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thanh toán</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="text-success mb-4">🛒 Thanh toán</h2>

  <?php if(isset($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
    <a href="index.php" class="btn btn-primary">Tiếp tục mua sắm</a>
  <?php else: ?>

  <!-- Hiển thị giỏ hàng -->
  <h5>Đơn hàng của bạn:</h5>
  <table class="table table-bordered">
    <thead class="table-light">
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
      foreach($_SESSION['cart'] as $item){
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
        echo "<tr>
          <td>{$item['name']}</td>
          <td>{$item['quantity']}</td>
          <td>".number_format($item['price'])." VND</td>
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

  <!-- Form checkout -->
  <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

  <form method="post" class="mt-4">
    <div class="mb-3">
      <label class="form-label">Họ tên</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Số điện thoại</label>
      <input type="text" name="phone" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Địa chỉ</label>
      <textarea name="address" class="form-control" required></textarea>
    </div>
    <button type="submit" name="checkout" class="btn btn-success">✅ Đặt hàng</button>
  </form>

  <!-- Thanh toán MOMO -->
  <a href="momo_payment.php" class="btn btn-warning mt-3">Thanh toán MOMO</a>

  <!-- Thông tin chuyển khoản -->
  <div class="alert alert-info mt-4">
    <h5>💳 Thông tin chuyển khoản</h5>
    <p>Ngân hàng: Vietcombank</p>
    <p>Chủ tài khoản: TRAN THANH DUY</p>
    <p>Số tài khoản: 0383764654</p>
    <p>Nội dung chuyển khoản: <strong>Đặt hàng MorningFruit - [Tên khách hàng]</strong></p>
    <p>Sau khi chuyển khoản, chúng tôi sẽ liên hệ xác nhận đơn hàng.</p>
  </div>

  <?php endif; ?>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
