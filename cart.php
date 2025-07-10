<?php
session_start();
include 'config.php';

if(isset($_POST['add_to_cart'])){
  $id = $_POST['id'];
  $quantity = $_POST['quantity'];

  $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
  $stmt->execute([$id]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  if($product){
    $_SESSION['cart'][$id]['name'] = $product['name'];
    $_SESSION['cart'][$id]['price'] = $product['price'];
    $_SESSION['cart'][$id]['quantity'] += $quantity;
  }

  header("Location: cart.php");
  exit();
}

if(isset($_GET['action']) && $_GET['action']=="add"){
  $id=intval($_GET['id']);
  if(isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id]['quantity']++;
  }else{
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['cart'][$id] = array(
      "quantity" => 1,
      "price" => $product['price'],
      "name" => $product['name']
    );
  }
}

if(isset($_GET['action']) && $_GET['action']=="remove"){
  $id=intval($_GET['id']);
  unset($_SESSION['cart'][$id]);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Giỏ hàng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h1 class="text-success">Giỏ hàng của bạn</h1>
  <table class="table">
    <tr>
      <th>Tên sản phẩm</th>
      <th>Số lượng</th>
      <th>Giá</th>
      <th>Tổng</th>
      <th>Hành động</th>
    </tr>
    <?php
    $total=0;
    if(!empty($_SESSION['cart'])){
      foreach($_SESSION['cart'] as $id => $item){
        $subtotal = $item['quantity'] * $item['price'];
        $total += $subtotal;
        echo "<tr>
          <td>".$item['name']."</td>
          <td>".$item['quantity']."</td>
          <td>".number_format($item['price'])." VND</td>
          <td>".number_format($subtotal)." VND</td>
          <td><a href='cart.php?action=remove&id=$id' class='btn btn-danger btn-sm'>Xoá</a></td>
        </tr>";
      }
      echo "<tr>
        <td colspan='3'><strong>Tổng cộng</strong></td>
        <td><strong>".number_format($total)." VND</strong></td>
        <td></td>
      </tr>";
    }else{
      echo "<tr><td colspan='5'>Giỏ hàng trống</td></tr>";
    }
    ?>
  </table>
  <?php if(!empty($_SESSION['cart'])) { ?>
    <a href="checkout.php" class="btn btn-success">Thanh toán</a>
    <a href="index.php" class="btn btn-secondary mt-2">Quay lại mua tiếp</a>

  <?php } ?>

</div>
</body>
</html>
