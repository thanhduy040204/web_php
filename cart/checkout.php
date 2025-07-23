<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../views/login_user.php");
  exit();
}
include '../config/config.php';

if (empty($_SESSION['cart'])) {
  header("Location: cart.php");
  exit();
}

if (isset($_POST['checkout'])) {
  $name = trim($_POST['name']);
  $phone = trim($_POST['phone']);
  $address = trim($_POST['address']);
  $total = 0;

  if (empty($name) || empty($phone) || empty($address)) {
    $error = "Vui lòng nhập đầy đủ thông tin.";
  } else {
    foreach ($_SESSION['cart'] as $item) {
      $total += $item['price'] * $item['quantity'];
    }

    $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_phone, customer_address, total_price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $phone, $address, $total]);
    $order_id = $conn->lastInsertId();

    foreach ($_SESSION['cart'] as $id => $item) {
      $stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
      $stmt->execute([$order_id, $id, $item['quantity'], $item['price']]);
    }

    // Gửi email xác nhận đơn hàng
    include '../controllers/send_email.php'; // Đảm bảo đường dẫn đúng

    $toEmail = $_SESSION['user_email'] ?? ''; // Session này phải được set từ login_user.php
    $toName = $name;
    $orderItems = $_SESSION['cart'];
    $totalPrice = $total;

    sendOrderConfirmation($toEmail, $toName, $order_id, $orderItems, $totalPrice);

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
  <h2 class="text-success mb-4 text-center">🛒 Thanh toán đơn hàng</h2>

  <?php if (isset($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
    <a href="../views/index.php" class="btn btn-primary">Tiếp tục mua sắm</a>
  <?php else: ?>
  <div class="row">
    <!-- Giỏ hàng bên trái -->
    <div class="col-lg-6 mb-4">
      <h5 class="mb-3">🧾 Đơn hàng của bạn</h5>
      <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
          <tr>
            <th>Sản phẩm</th>
            <th>Trọng lượng (kg)</th>
            <th>Giá</th>
            <th>Tổng</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total = 0;
          foreach ($_SESSION['cart'] as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
            echo "<tr>
              <td>{$item['name']}</td>
              <td>{$item['quantity']}</td>
              <td>" . number_format($item['price']) . " VND</td>
              <td>" . number_format($subtotal) . " VND</td>
            </tr>";
          }
          ?>
          <tr>
            <td colspan="3" class="text-end fw-bold">Tổng cộng</td>
            <td class="text-danger fw-bold"><?php echo number_format($total); ?> VND</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Form thông tin bên phải -->
    <div class="col-lg-6">
      <h5 class="mb-3">📦 Thông tin giao hàng</h5>
      <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
      <form method="post">
        <div class="mb-3">
          <label class="form-label">👤 Họ tên</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">📞 Số điện thoại</label>
          <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">🏠 Địa chỉ</label>
          <textarea name="address" class="form-control" required></textarea>
        </div>
        <button type="submit" name="checkout" class="btn btn-success w-100">✅ Đặt hàng</button>
      </form>

      <a href="../controllers/momo_payment.php" class="btn btn-warning w-100 mt-3"><i class="bi bi-wallet2"></i> Thanh toán MOMO</a>

      <div class="alert alert-info mt-4">
        <h6><i class="bi bi-credit-card"></i> Thông tin chuyển khoản</h6>
        <p><strong>Ngân hàng:</strong> Vietcombank</p>
        <p><strong>Chủ tài khoản:</strong> TRAN THANH DUY</p>
        <p><strong>Số tài khoản:</strong> 0383764654</p>
        <p><strong>Nội dung:</strong> Đặt hàng MorningFruit - [Tên khách hàng]</p>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
