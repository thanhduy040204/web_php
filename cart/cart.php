<?php
session_start();
include '../config/config.php';

// Thêm sản phẩm vào giỏ
if (isset($_POST['add_to_cart'])) {
  $id = (int)$_POST['id'];
  $quantity = (float)$_POST['quantity'];

  if ($quantity <= 0) {
    header("Location: cart.php");
    exit();
  }

  $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
  $stmt->execute([$id]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($product) {
    if (isset($_SESSION['cart'][$id])) {
      $_SESSION['cart'][$id]['quantity'] += $quantity;
    } else {
      $_SESSION['cart'][$id] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => $quantity
      ];
    }
  }

  header("Location: cart.php");
  exit();
}

// Cập nhật giỏ hàng
if (isset($_POST['update_cart'])) {
  foreach ($_POST['quantity'] as $id => $qty) {
    $qty = (float)$qty;
    if ($qty <= 0) {
      unset($_SESSION['cart'][$id]);
    } else {
      $_SESSION['cart'][$id]['quantity'] = $qty;
    }
  }
  header("Location: cart.php");
  exit();
}

// Xoá sản phẩm khỏi giỏ
if (isset($_GET['action']) && $_GET['action'] == "remove") {
  $id = intval($_GET['id']);
  if (isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
  }
  header("Location: cart.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Giỏ hàng</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="text-success mb-4">🛒 Giỏ hàng của bạn</h2>

  <?php if (!empty($_SESSION['cart'])): ?>
    <form method="post" action="cart.php">
      <table class="table table-bordered align-middle text-center">
        <thead class="table-success">
          <tr>
            <th>Sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total = 0;
          foreach ($_SESSION['cart'] as $id => $item):
            $subtotal = $item['quantity'] * $item['price'];
            $total += $subtotal;
          ?>
          <tr>
            <td class="text-start"><?php echo htmlspecialchars($item['name']); ?></td>
            <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
            <td style="width:120px;">
              <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $item['quantity']; ?>" min="0.1" step="0.1" class="form-control text-center">
            </td>
            <td><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</td>
            <td><a href="cart.php?action=remove&id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Xóa</a></td>
          </tr>
          <?php endforeach; ?>
          <tr>
            <td colspan="3" class="text-end fw-bold">Tổng cộng</td>
            <td colspan="2" class="text-danger fw-bold"><?php echo number_format($total, 0, ',', '.'); ?> VND</td>
          </tr>
        </tbody>
      </table>

      <div class="d-flex justify-content-between flex-wrap">
        <a href="../views/index.php" class="btn btn-secondary mb-2">⬅ Tiếp tục mua sắm</a>
        <div class="mb-2">
          <button type="submit" name="update_cart" class="btn btn-primary me-2">Cập nhật giỏ</button>
          <a href="checkout.php" class="btn btn-success">Thanh toán</a>
        </div>
      </div>
    </form>
  <?php else: ?>
    <div class="alert alert-info">Giỏ hàng trống.</div>
    <a href="../views/index.php" class="btn btn-success">Mua ngay</a>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
