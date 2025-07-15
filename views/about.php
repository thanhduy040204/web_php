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
  <link rel="stylesheet" href="../assets/css/style.css?v=3">

  <style>
    .about-banner {
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.5)), url('../assets/images/banner3.jpg') center/cover no-repeat;
      height: 450px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .about-banner h1 {
      color: #fff;
      font-size: 50px;
      font-weight: 800;
      text-shadow: 2px 4px 10px rgba(0,0,0,0.7);
      text-transform: uppercase;
    }

    .lead-custom {
      font-size: 1.2rem;
      color: #444;
    }

    .feature-card {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
    }
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
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
  <!-- Intro -->
  <div class="row justify-content-center mb-5">
    <div class="col-md-10 text-center" data-aos="fade-up">
      <p class="lead lead-custom">
        <strong>🍎 MorningFruit</strong> chuyên cung cấp trái cây nhập khẩu và nội địa chất lượng cao, an toàn cho sức khoẻ người tiêu dùng. Chúng tôi cam kết giá tốt, giao hàng nhanh và trải nghiệm dịch vụ tận tâm tại TP.HCM và toàn quốc.
      </p>
    </div>
  </div>

  <!-- Features -->
  <div class="row text-center mb-5 g-4">
    <div class="col-md-4" data-aos="zoom-in">
      <div class="feature-card">
        <div class="feature-icon"><i class="bi bi-emoji-smile"></i></div>
        <h5>Trái cây tươi ngon</h5>
        <p>Đa dạng chủng loại, nhập mới mỗi ngày, đảm bảo độ tươi sạch tuyệt đối.</p>
      </div>
    </div>
    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
      <div class="feature-card">
        <div class="feature-icon"><i class="bi bi-truck"></i></div>
        <h5>Giao hàng siêu tốc</h5>
        <p>Giao nhanh trong 2h tại TP.HCM, vận chuyển toàn quốc uy tín.</p>
      </div>
    </div>
    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
      <div class="feature-card">
        <div class="feature-icon"><i class="bi bi-tags"></i></div>
        <h5>Giá tốt & Khuyến mãi</h5>
        <p>Luôn có ưu đãi mới mỗi tuần, tặng mã giảm giá cho thành viên thân thiết.</p>
      </div>
    </div>
  </div>

  <!-- Mission -->
  <div class="row justify-content-center">
    <div class="col-md-9" data-aos="fade-up">
      <div class="mission-box shadow-sm">
        <h4 class="text-success mb-3"><i class="bi bi-bullseye"></i> Tầm nhìn & Sứ mệnh</h4>
        <p><strong>MorningFruit</strong> mong muốn trở thành chuỗi phân phối trái cây hàng đầu tại Việt Nam, mang đến sự hài lòng, sức khoẻ và trải nghiệm mua sắm thông minh, lành mạnh đến mọi gia đình.</p>
      </div>
    </div>
  </div>
</div>

<?php include '../components/footer.php'; ?>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ duration: 1000 });
</script>
</body>
</html>
