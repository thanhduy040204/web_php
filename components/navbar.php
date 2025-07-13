<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
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
        <li class="nav-item"><a class="nav-link" href="/Webphp/cart/cart.php">Giỏ hàng</a></li>
        <?php if(isset($_SESSION['user'])){ ?>
          <li class="nav-item"><a class="nav-link" href="#">👋 Xin chào, <?php echo $_SESSION['user']; ?></a></li>
          <li class="nav-item"><a class="nav-link" href="logout_user.php">Đăng xuất</a></li>
        <?php }else{ ?>
          <li class="nav-item"><a class="nav-link" href="login_user.php">Đăng nhập</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">Đăng ký</a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
