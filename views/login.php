<?php
session_start();
include '../config/config.php';

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = md5($_POST['password']); // ⚠️ Nên dùng password_hash và password_verify nếu có thể

  $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
  $stmt->execute([$username, $password]);
  $admin = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($admin) {
    $_SESSION['admin'] = $admin['username'];
    header("Location: dashboard.php");
  } else {
    $error = "❌ Sai tên đăng nhập hoặc mật khẩu!";
  }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập Quản trị</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background: #f8f9fa;
    }
    .login-box {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin-top: 80px;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="login-box">
        <h3 class="text-center mb-4 text-success"><i class="bi bi-person-lock"></i> Đăng nhập Admin</h3>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">👤 Tên đăng nhập</label>
            <input type="text" name="username" class="form-control" placeholder="Nhập tên admin..." required>
          </div>
          <div class="mb-3">
            <label class="form-label">🔒 Mật khẩu</label>
            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu..." required>
          </div>
          <button type="submit" name="login" class="btn btn-success w-100">Đăng nhập</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
