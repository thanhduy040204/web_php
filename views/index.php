<?php

ini_set('session.cookie_lifetime', 0); // Session bị xoá khi trình duyệt tắt
ini_set('session.gc_maxlifetime', 0);  // Session tự hủy sau khi tắt trình duyệt

session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login_user.php");
  exit();
}

include '../config/config.php';

// Truy vấn danh sách khuyến mãi đang áp dụng
$stmtPromo = $conn->prepare("SELECT * FROM promotions WHERE NOW() BETWEEN start_date AND end_date ORDER BY min_order_value ASC");
$stmtPromo->execute();
$promotions = $stmtPromo->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>MorningFruit Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css?v=3">
  <style>
    .product-card:hover {
      transform: scale(1.02);
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .product-image {
      transition: transform 0.3s;
    }
    .product-image:hover {
      transform: scale(1.05);
    }
    .btn-buy {
      background-color: #ff6f00;
      color: white;
    }
    .btn-buy:hover {
      background-color: #e65c00;
    }
  </style>
</head>
<body>

<?php include '../components/navbar.php'; ?>

<!-- Carousel -->
<div id="mainCarousel" class="carousel slide mt-5 pt-3" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="../assets/images/banner1.jpg" class="d-block w-100" alt="Banner 1" style="height: 400px; object-fit: cover;">
    </div>
    <div class="carousel-item">
      <img src="../assets/images/banner2.jpg" class="d-block w-100" alt="Banner 2" style="height: 400px; object-fit: cover;">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- Khuyến mãi -->
<?php if (!empty($promotions)): ?>
<div class="container mt-4">
  <div class="alert alert-warning shadow-sm">
    <h5 class="mb-3"><i class="bi bi-megaphone-fill text-danger"></i> 🎁 Ưu đãi đang diễn ra:</h5>
    <ul class="mb-0">
      <?php foreach ($promotions as $promo): ?>
        <li>
          <strong><?php echo htmlspecialchars($promo['name']); ?></strong>
          – Áp dụng cho đơn từ <span class="text-primary"><?php echo number_format($promo['min_order_value'], 0, ',', '.'); ?> VND</span>
          (Từ <?php echo date('d/m/Y', strtotime($promo['start_date'])); ?> đến <?php echo date('d/m/Y', strtotime($promo['end_date'])); ?>)
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
<?php endif; ?>

<!-- Giới thiệu -->
<div class="container text-center my-4">
  <h2 class="text-success">Trái cây tươi mỗi ngày</h2>
  <p>Chất lượng - Nhanh chóng - An toàn</p>
  <a href="#products" class="btn btn-success">Khám phá ngay</a>
</div>

<!-- Sản phẩm -->
<div class="container mt-5" id="products">
  <h2 class="text-success text-center mb-4">Sản phẩm nổi bật</h2>
  <div class="row">
    <?php
    $stmt = $conn->query("SELECT * FROM products");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <div class="col-6 col-md-4 col-lg-3 mb-4" data-aos="fade-up">
      <div class="card product-card h-100 border-0 shadow-sm">
        <a href="product_detail.php?id=<?php echo $row['id']; ?>">
          <img src="../assets/images/<?php echo $row['image']; ?>" class="card-img-top product-image rounded-top" alt="<?php echo $row['name']; ?>" style="height: 200px; object-fit: cover;">
        </a>
        <div class="card-body d-flex flex-column">
          <h5 class="card-title text-truncate text-success"><?php echo $row['name']; ?></h5>
          <h6 class="text-danger"><?php echo number_format($row['price']); ?> VND</h6>

          <form method="post" action="../cart/cart.php" class="mt-auto">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="input-group mb-2">
              <input type="number" name="quantity" value="1" min="0.1" step="0.1" class="form-control text-center" style="max-width: 70px;">
              <button type="submit" name="add_to_cart" class="btn btn-buy"><i class="bi bi-cart-plus"></i></button>
            </div>
            <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-success btn-sm w-100">Xem chi tiết</a>
          </form>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>

<?php include '../components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>
</body>
</html>
