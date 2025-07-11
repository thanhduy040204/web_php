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
  <link rel="stylesheet" href="style.css?v=1">
  <style>
    .about-banner {
      background: url('images/banner3.jpg') center/cover no-repeat;
      height: 400px;
      position: relative;
    }

    .about-banner h1 {
      font-weight: bold;
      font-size: 48px;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    .about-section {
      padding: 60px 0;
    }
    .feature-icon {
      font-size: 40px;
      color: #28a745;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<!-- Banner -->
<div class="about-banner"></div>
<!-- About Title -->
<div class="container mt-4 text-center">
  <h1 class="text-success fw-bold">Giới thiệu MorningFruit</h1>
</div>

<!-- About Content -->
<div class="container about-section">
  <div class="row justify-content-center">
    <div class="col-md-10 text-center">
      <p class="lead">🍎 MorningFruit chuyên cung cấp trái cây nhập khẩu và nội địa tươi ngon, an toàn cho sức khoẻ người tiêu dùng. Chúng tôi cam kết giá tốt nhất, giao hàng nhanh chóng tại TP.HCM và các tỉnh.</p>
    </div>
  </div>

  <div class="row text-center mt-5">
    <div class="col-md-4">
      <div class="feature-icon">🥭</div>
      <h5>Trái cây tươi ngon</h5>
      <p>Đa dạng chủng loại, nhập mới mỗi ngày.</p>
    </div>
    <div class="col-md-4">
      <div class="feature-icon">🚚</div>
      <h5>Giao hàng nhanh</h5>
      <p>Giao hoả tốc nội thành và ship tỉnh uy tín.</p>
    </div>
    <div class="col-md-4">
      <div class="feature-icon">💰</div>
      <h5>Giá tốt nhất</h5>
      <p>Cam kết giá cả cạnh tranh, khuyến mãi hàng tuần.</p>
    </div>
  </div>

  <div class="row justify-content-center mt-5">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="text-success">🌟 Tầm nhìn & sứ mệnh</h4>
          <p>MorningFruit mong muốn trở thành hệ thống bán lẻ trái cây uy tín, mang đến sức khoẻ và niềm vui mỗi ngày cho khách hàng trên toàn quốc.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
