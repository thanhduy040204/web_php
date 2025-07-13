<?php 
session_start();
include '../config/config.php'; 

if(isset($_POST['register'])){
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  // Check email đã tồn tại chưa
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  if($stmt->rowCount() > 0){
    $error = "❌ Email đã tồn tại!";
  }else{
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $password]);
    $success = "✅ Đăng ký thành công! Vui lòng đăng nhập.";
  }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký tài khoản</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background: #f8f9fa;
    }
    .register-box {
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

<div class="register-box">
  <h3 class="text-center text-success mb-4"><i class="bi bi-person-plus-fill"></i> Đăng ký</h3>

  <?php if(isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <?php if(isset($success)): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3 position-relative">
      <i class="bi bi-person form-icon"></i>
      <input type="text" name="name" class="form-control" placeholder="Họ và tên" required>
    </div>
    <div class="mb-3 position-relative">
      <i class="bi bi-envelope form-icon"></i>
      <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>
    <div class="mb-3 position-relative">
      <i class="bi bi-lock form-icon"></i>
      <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
    </div>
    <button type="submit" name="register" class="btn btn-success w-100">Tạo tài khoản</button>
    <div class="text-center mt-3">
      <small>Đã có tài khoản? <a href="login_user.php">Đăng nhập</a></small>
    </div>
  </form>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
