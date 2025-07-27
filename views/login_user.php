<?php

ini_set('session.cookie_lifetime', 0); // Session tự huỷ khi trình duyệt đóng
ini_set('session.gc_maxlifetime', 0);

session_start();
include '../config/config.php';

if (isset($_POST['login'])) {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user['name'];
    $_SESSION['user_email'] = $user['email']; // ✅ Lưu email để dùng khi gửi mail
    header("Location: index.php");
    exit();
  } else {
    $error = "❌ Email hoặc mật khẩu không đúng!";
  }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background: #f8f9fa;
    }
    .login-box {
      max-width: 450px;
      margin: auto;
      margin-top: 80px;
      padding: 30px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .form-icon {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #6c757d;
    }
    .form-control {
      padding-left: 35px;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h3 class="text-center text-success mb-4"><i class="bi bi-box-arrow-in-right"></i> Đăng nhập</h3>

  <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3 position-relative">
      <i class="bi bi-envelope form-icon"></i>
      <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>
    <div class="mb-3 position-relative">
      <i class="bi bi-lock form-icon"></i>
      <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
    </div>
    <button type="submit" name="login" class="btn btn-success w-100">Đăng nhập</button>
    <div class="text-center mt-3">
      <small>Chưa có tài khoản? <a href="register.php">Đăng ký</a></small><br>
      <small><a href="forgot_password.php">Quên mật khẩu?</a></small>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
