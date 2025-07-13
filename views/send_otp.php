<?php
session_start();

if (!isset($_SESSION['pending_user'])) {
  header("Location: register.php");
  exit();
}

// Tạo mã OTP ngẫu nhiên (giả lập)
$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;

// Gửi OTP giả lập (hiện ra màn hình)
echo "<div style='font-family:Arial; text-align:center; margin-top:100px;'>
  <h2>🔐 Mã OTP đã gửi đến số điện thoại của bạn</h2>
  <h1 style='color:green;'>$otp</h1>
  <p>Vui lòng nhập mã để hoàn tất đăng ký</p>
  <a href='verify_otp.php' class='btn btn-primary'>👉 Đi đến trang xác thực</a>
</div>";
?>
