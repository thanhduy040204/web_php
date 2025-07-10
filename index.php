<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Shop Trái Cây</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS -->
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand text-success" href="index.php">MorningFruit</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">

        <!-- Links mặc định -->
        <li class="nav-item">
          <a class="nav-link" href="index.php">Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">Giới thiệu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php">Giỏ hàng</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Liên hệ</a>
        </li>

        <!-- Check login user -->
        <?php if(isset($_SESSION['user'])){ ?>
          <li class="nav-item">
            <a class="nav-link" href="#">Xin chào, <?php echo $_SESSION['user']; ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout_user.php">Đăng xuất</a>
          </li>
        <?php }else{ ?>
          <li class="nav-item">
            <a class="nav-link" href="login_user.php">Đăng nhập</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Đăng ký</a>
          </li>
        <?php } ?>

      </ul>
    </div>
  </div>
</nav>
<!-- End Navbar -->

<!-- Content -->
<div class="container mt-4">
  <h1 class="text-success text-center mb-4">MorningFruit Shop</h1>
  <div class="row">
    <?php
    $stmt = $conn->query("SELECT * FROM products");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <div class="col-md-3 mb-4">
      <div class="card h-100 shadow-sm border-0">
        <a href="product_detail.php?id=<?php echo $row['id']; ?>">
          <img src="images/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>" style="height: 200px; object-fit: cover;">
        </a>
        <div class="card-body d-flex flex-column">
          <h5 class="card-title text-success"><?php echo $row['name']; ?></h5>
          <p class="card-text"><?php echo mb_strimwidth($row['description'], 0, 50, "..."); ?></p>
          <h6 class="text-danger"><?php echo number_format($row['price']); ?> VND</h6>
          <div class="mt-auto">
            <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-success btn-sm w-100 mb-2">Xem chi tiết</a>
            <form method="post" action="cart.php">
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
              <div class="input-group mb-2">
                <input type="number" name="quantity" value="1" min="1" class="form-control">
              </div>
              <button type="submit" name="add_to_cart" class="btn btn-success btn-sm w-100">Thêm vào giỏ</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>
<!-- End Content -->

<!-- Footer -->
<footer class="bg-dark text-white mt-5 p-4 text-center">
  <p>MorningFruit &copy; 2025 | Địa chỉ: 123 Đường ABC, TP.HCM | Hotline: 0123 456 789</p>
</footer>

</body>
</html>
