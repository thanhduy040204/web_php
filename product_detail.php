<?php
include 'config.php';

$product = null;

if(isset($_GET['id'])){
  $id = $_GET['id'];
  $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
  $stmt->execute([$id]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title><?php echo $product ? $product['name'] : "Sản phẩm không tồn tại"; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <?php if($product): ?>
      <h1 class="text-success"><?php echo $product['name']; ?></h1>
      <div class="row">
        <div class="col-md-6">
          <img src="images/<?php echo $product['image']; ?>" class="img-fluid" alt="<?php echo $product['name']; ?>">
        </div>
        <div class="col-md-6">
          <p><?php echo $product['description']; ?></p>
          <h3 class="text-danger"><?php echo number_format($product['price']); ?> VND</h3>
          <a href="cart.php?action=add&id=<?php echo $product['id']; ?>" class="btn btn-success">Thêm vào giỏ hàng</a>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-danger">
        Sản phẩm không tồn tại.
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
