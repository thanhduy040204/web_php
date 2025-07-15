<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3" id="mainNavbar">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center text-success" href="index.php">
      <i class="bi bi-basket-fill me-2 fs-4"></i> MorningFruit
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link" href="index.php"><i class="bi bi-house-door"></i> Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php"><i class="bi bi-info-circle"></i> Giới thiệu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/webphp/cart/cart.php"><i class="bi bi-cart3"></i> Giỏ hàng</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php"><i class="bi bi-telephone"></i> Liên hệ</a>
        </li>

        <!-- Toggle Dark/Light -->
        <li class="nav-item">
          <button id="toggle-theme" class="btn btn-sm btn-outline-secondary ms-3" title="Chuyển giao diện">
            <i class="bi bi-moon-stars" id="theme-icon"></i>
          </button>
        </li>

        <?php if (isset($_SESSION['user'])) { ?>
          <li class="nav-item">
            <span class="nav-link text-success"><i class="bi bi-person-check"></i> Xin chào, <?= $_SESSION['user']; ?></span>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger" href="logout_user.php"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link" href="login_user.php"><i class="bi bi-box-arrow-in-right"></i> Đăng nhập</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php"><i class="bi bi-person-plus"></i> Đăng ký</a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Dark/Light Toggle Script -->
<script>
  const toggleBtn = document.getElementById('toggle-theme');
  const body = document.body;
  const icon = document.getElementById('theme-icon');
  const navbar = document.getElementById('mainNavbar');

  function setTheme(mode) {
    if (mode === 'dark') {
      body.classList.add('bg-dark', 'text-light');
      navbar.classList.replace('bg-white', 'bg-dark');
      icon.classList.replace('bi-moon-stars', 'bi-sun');
    } else {
      body.classList.remove('bg-dark', 'text-light');
      navbar.classList.replace('bg-dark', 'bg-white');
      icon.classList.replace('bi-sun', 'bi-moon-stars');
    }
  }

  // Load từ localStorage
  const savedTheme = localStorage.getItem('theme') || 'light';
  setTheme(savedTheme);

  toggleBtn.addEventListener('click', () => {
    const currentTheme = body.classList.contains('bg-dark') ? 'dark' : 'light';
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    setTheme(newTheme);
    localStorage.setItem('theme', newTheme);
  });
</script>
