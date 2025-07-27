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

$errors = [];
$promotion = null;

if (isset($_POST['checkout'])) {
  $name = trim($_POST['name']);
  $phone = trim($_POST['phone']);
  $address = trim($_POST['address']);
  $total = 0;

  if (empty($name) || empty($phone) || empty($address)) {
    $errors[] = "Vui lòng nhập đầy đủ thông tin.";
  } else {
    foreach ($_SESSION['cart'] as $id => $item) {
      $stmt = $conn->prepare("SELECT quantity_in_stock FROM products WHERE id = ?");
      $stmt->execute([$id]);
      $product = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$product || $item['quantity'] > $product['quantity_in_stock']) {
        $errors[] = "❗ Sản phẩm <strong>{$item['name']}</strong> chỉ còn <strong>{$product['quantity_in_stock']}kg</strong> trong kho.";
      } else {
        $total += $item['price'] * $item['quantity'];
      }
    }

    if (empty($errors)) {
      $discount = 0;
      $stmt = $conn->prepare("SELECT * FROM promotions WHERE min_order_value <= ? AND NOW() BETWEEN start_date AND end_date ORDER BY min_order_value DESC LIMIT 1");
      $stmt->execute([$total]);
      $promotion = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($promotion) {
        if ($promotion['discount_type'] === 'percent') {
          $discount = $total * ($promotion['discount_value'] / 100);
        } else {
          $discount = $promotion['discount_value'];
        }
      }
      $finalTotal = $total - $discount;

      $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_phone, customer_address, total_price) VALUES (?, ?, ?, ?)");
      $stmt->execute([$name, $phone, $address, $finalTotal]);
      $order_id = $conn->lastInsertId();

      foreach ($_SESSION['cart'] as $id => $item) {
        $stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $id, $item['quantity'], $item['price']]);

        $stmt = $conn->prepare("UPDATE products SET quantity_in_stock = quantity_in_stock - ? WHERE id = ?");
        $stmt->execute([$item['quantity'], $id]);
      }

      include '../controllers/send_email.php';
      $toEmail = $_SESSION['user_email'] ?? '';
      $toName = $name;
      $orderItems = $_SESSION['cart'];
      $totalPrice = $finalTotal;
      sendOrderConfirmation($toEmail, $toName, $order_id, $orderItems, $totalPrice);

      unset($_SESSION['cart']);
      $success = "🎉 Đặt hàng thành công! Chúng tôi sẽ liên hệ bạn sớm.";
    }
  }
}
?>
