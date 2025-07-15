<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['otp_verified']) || !isset($_SESSION['reset_email'])) {
  header("Location: forgot_password.php");
  exit();
}

if (isset($_POST['reset'])) {
  $new_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
  $stmt->execute([$new_pass, $_SESSION['reset_email']]);

  unset($_SESSION['otp_verified'], $_SESSION['reset_email'], $_SESSION['reset_otp']);

  $success = "✅ Mật khẩu đã được cập nhật!";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đặt lại mật khẩu</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container col-md-4 mt-5">
  <h3>🔐 Đặt lại mật khẩu</h3>
  <?php if (isset($success)): ?>
    <div class="alert alert-success">
      <?= $success ?> <a href="login_user.php">Đăng nhập</a>
    </div>
  <?php else: ?>
  <form method="post">
    <div class="mb-3">
      <label>Mật khẩu mới</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button name="reset" class="btn btn-success w-100">Cập nhật</button>
  </form>
  <?php endif; ?>
</div>
</body>
</html>
