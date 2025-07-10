<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>MorningFruit Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css?v=1">
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand text-success fw-bold" href="index.php">MorningFruit</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">Giới thiệu</a></li>
        <li class="nav-item"><a class="nav-link" href="cart.php">Giỏ hàng</a></li>
        <?php if(isset($_SESSION['user'])){ ?>
          <li class="nav-item"><a class="nav-link" href="#">Xin chào, <?php echo $_SESSION['user']; ?></a></li>
          <li class="nav-item"><a class="nav-link" href="logout_user.php">Đăng xuất</a></li>
        <?php }else{ ?>
          <li class="nav-item"><a class="nav-link" href="login_user.php">Đăng nhập</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">Đăng ký</a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
<!-- End Navbar -->

<!-- Slider -->
<div id="carouselExampleIndicators" class="carousel slide mt-5 pt-3" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/banner1.jpg" class="d-block w-100" alt="Banner 1" style="height:400px; object-fit:cover;">
    </div>
    <div class="carousel-item">
      <img src="images/banner2.jpg" class="d-block w-100" alt="Banner 2" style="height:400px; object-fit:cover;">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>
<!-- End Slider -->

<!-- Products -->
<div class="container mt-5">
  <h2 class="text-success text-center mb-4">Sản phẩm nổi bật</h2>
  <div class="row">
    <?php
    $stmt = $conn->query("SELECT * FROM products");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <div class="col-6 col-md-4 col-lg-3 mb-4" data-aos="fade-up">
      <div class="card product-card h-100 shadow-sm border-0">

        <!-- Product image with overlay -->
        <div class="position-relative overflow-hidden">
          <a href="product_detail.php?id=<?php echo $row['id']; ?>">
            <img src="images/<?php echo $row['image']; ?>" class="card-img-top product-image" alt="<?php echo $row['name']; ?>" style="height: 200px; object-fit: cover;">
            <div class="overlay">
              <i class="bi bi-search"></i>
            </div>
          </a>
        </div>

        <!-- Product details -->
        <div class="card-body d-flex flex-column">
          <h5 class="card-title text-success"><?php echo $row['name']; ?></h5>
          <h6 class="text-danger"><?php echo number_format($row['price']); ?> VND</h6>

          <!-- Form add to cart -->
          <form method="post" action="cart.php" class="mt-auto">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="input-group mb-2">
              <input type="number" name="quantity" value="1" min="1" class="form-control text-center" style="max-width: 70px;">
              <button type="submit" name="add_to_cart" class="btn btn-success btn-sm">+</button>
            </div>
            <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-success btn-sm w-100">Xem chi tiết</a>
          </form>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>
<!-- End Products -->

<!-- Footer -->
<footer class="bg-dark text-white mt-5 p-4 text-center">
  MorningFruit &copy; 2025 | 123 Đường ABC, TP.HCM | Hotline: 0123 456 789
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>
</body>
</html>
