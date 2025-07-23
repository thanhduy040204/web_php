<?php
// momo_return.php - hiển thị kết quả thanh toán cho người dùng
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Kết quả thanh toán MOMO</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 text-center">

  <?php if (isset($_GET['errorCode']) && $_GET['errorCode'] == 0): ?>
    <div class="alert alert-success">
      <h1 class="text-success">✅ Thanh toán thành công!</h1>
      <p><strong>Mã đơn hàng:</strong> <?= htmlspecialchars($_GET['orderId']) ?></p>
      <p><strong>Số tiền:</strong> <?= number_format($_GET['amount']) ?> VND</p>
    </div>
  <?php else: ?>
    <div class="alert alert-danger">
      <h1 class="text-danger">❌ Thanh toán thất bại!</h1>
      <p>Vui lòng thử lại hoặc chọn phương thức thanh toán khác.</p>
    </div>
  <?php endif; ?>

  <a href="/web_php/views/index.php" class="btn btn-primary mt-3">⬅ Quay lại trang chủ</a>

</div>
</body>
</html>
