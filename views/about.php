<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Giới thiệu MorningFruit</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css?v=4">

  <style>
    .about-banner {
      background: url('../assets/images/banner3.jpg') center/cover no-repeat;
      height: 400px;
    }

    .page-title {
      margin-top: 40px;
      margin-bottom: 20px;
      font-size: 36px;
      font-weight: bold;
      color: #2e7d32;
    }

    .breadcrumb {
      background: none;
      padding: 1rem 0;
      font-size: 0.95rem;
    }

    .lead-custom {
      font-size: 1.2rem;
      color: #444;
    }

    .feature-icon {
      font-size: 40px;
      color: #28a745;
      margin-bottom: 15px;
    }

    .mission-box {
      background: #e9fbee;
      border-left: 6px solid #28a745;
      border-radius: 12px;
      padding: 30px;
    }

    .carousel-img {
      height: 350px;
      object-fit: cover;
    }

    .two-col-section img {
      width: 100%;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>

<?php include '../components/navbar.php'; ?>


<div class="about-banner"></div>

<div class="container">
  <h1 class="text-center page-title" data-aos="fade-down">Giới thiệu MorningFruit</h1>
</div>

<div class="container mb-5" data-aos="fade-up">
  <div id="carouselExampleIndicators" class="carousel slide shadow-sm rounded" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="../assets/images/banner4.jpg" class="d-block w-100 carousel-img" alt="Trái cây tươi 1">
      </div>
      <div class="carousel-item">
        <img src="../assets/images/banner5.jpg" class="d-block w-100 carousel-img" alt="Trái cây tươi 2">
      </div>
      <div class="carousel-item">
        <img src="../assets/images/banner6.jpg" class="d-block w-100 carousel-img" alt="Cửa hàng MorningFruit">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</div>


<div class="container mb-5">
  <div class="row align-items-center g-5 two-col-section">
    <div class="col-md-6" data-aos="fade-right">
      <img src="../assets/images/hinhanh1.jpg" alt="Trái cây sạch">
    </div>
    <div class="col-md-6" data-aos="fade-left">
      <p class="lead lead-custom">
        <strong>🍎 MorningFruit</strong> chuyên cung cấp trái cây nhập khẩu và nội địa chất lượng cao, an toàn cho sức khoẻ người tiêu dùng. <br><br>
        Chúng tôi cam kết:
        <ul>
          <li>✔ Trái cây tươi, rõ nguồn gốc</li>
          <li>✔ Giao hàng nhanh tại TP.HCM</li>
          <li>✔ Ưu đãi đặc biệt cho khách hàng thân thiết</li>
        </ul>
      </p>
    </div>
  </div>
</div>


<div class="container mb-5">
  <div class="row justify-content-center">
    <div class="col-md-10" data-aos="fade-up">
      <div class="mission-box shadow-sm">
        <h4 class="text-success mb-3"><i class="bi bi-bullseye"></i> Tầm nhìn & Sứ mệnh</h4>
        <p><strong>MorningFruit</strong> được thành lập với mong muốn trở thành chuỗi phân phối trái cây hàng đầu tại Việt Nam, mang đến sự hài lòng, sức khoẻ và trải nghiệm mua sắm thông minh, lành mạnh đến mọi gia đình. ❤️ ❤️ ❤️</p>
      </div>
    </div>
  </div>
</div>


<div class="container mb-5" data-aos="fade-up">
  <div class="ratio ratio-16x9 rounded shadow-sm">
    <iframe src="https://www.youtube.com/embed/SvuifZ1BDS4" title="Video giới thiệu MorningFruit" allowfullscreen></iframe>
  </div>
</div>

<?php include '../components/footer.php'; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ duration: 1000 });
</script>
</body>
</html>
