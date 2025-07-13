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
  <link rel="stylesheet" href="../assets/css/style.css?v=2">

  <style>
    .about-banner {
      background: url('../assets/images/banner3.jpg') center/cover no-repeat;
      height: 400px;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .about-banner::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.5);
    }
    .about-banner h1 {
      color: white;
      font-size: 48px;
      font-weight: bold;
      position: relative;
      z-index: 1;
      text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
    }

    .feature-icon {
      font-size: 50px;
      color: #28a745;
      margin-bottom: 15px;
    }
    .mission-box {
      background: #f8f9fa;
      border-left: 5px solid #28a745;
      border-radius: 10px;
      padding: 25px;
    }
  </style>
</head>
<body>

<?php include '../components/navbar.php'; ?>

<!-- Banner -->
<div class="about-banner">
  <h1 data-aos="fade-down">Giới thiệu MorningFruit</h1>
</div>

<!-- About Content -->
<div class="container py-5">
  <div class="row justify-content-center mb-4">
    <div class="col-md-10 text-center" data-aos="fade-up">
      <p class="lead">🍎 <strong>MorningFruit</strong> chuyên cung cấp trái cây nhập khẩu và nội địa tươi ngon, an toàn cho sức khoẻ người tiêu dùng. Chúng tôi cam kết giá tốt nhất, giao hàng nhanh chóng tại TP.HCM và các tỉnh.</p>
    </div>
  </div>

  <!-- Feature Icons -->
  <div class="row text-center mb-5">
    <div class="col-md-4" data-aos="zoom-in">
      <div class="feature-icon">🥭</div>
      <h5>Trái cây tươi ngon</h5>
      <p>Đa dạng chủng loại, nhập mới mỗi ngày.</p>
    </div>
    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
      <div class="feature-icon">🚚</div>
      <h5>Giao hàng nhanh</h5>
      <p>Giao hoả tốc nội thành và ship tỉnh uy tín.</p>
    </div>
    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
      <div class="feature-icon">💰</div>
      <h5>Giá tốt nhất</h5>
      <p>Cam kết giá cả cạnh tranh, khuyến mãi hàng tuần.</p>
    </div>
  </div>

  <!-- Mission -->
  <div class="row justify-content-center">
    <div class="col-md-8" data-aos="fade-up">
      <div class="mission-box shadow-sm">
        <h4 class="text-success mb-3"><i class="bi bi-bullseye"></i> Tầm nhìn & Sứ mệnh</h4>
        <p><strong>MorningFruit</strong> mong muốn trở thành hệ thống bán lẻ trái cây uy tín, mang đến sức khoẻ và niềm vui mỗi ngày cho khách hàng trên toàn quốc. Chúng tôi không chỉ bán trái cây – chúng tôi mang đến trải nghiệm mua sắm lành mạnh, tận tâm và hiện đại.</p>
      </div>
    </div>
  </div>
</div>

<?php include '../components/footer.php'; ?>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>
</body>
</html>
