<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['pending_user']) || !isset($_SESSION['otp'])) {
  header("Location: register.php");
  exit();
}

if (isset($_POST['verify'])) {
  $user_otp = $_POST['otp'];
  if ($user_otp == $_SESSION['otp']) {
    // Lưu vào DB
    $user = $_SESSION['pending_user'];
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user['name'], $user['email'], $user['phone'], $user['password']]);

    // Dọn session
    unset($_SESSION['pending_user'], $_SESSION['otp']);

    $success = "✅ Đăng ký thành công! Bạn có thể đăng nhập.";
  } else {
    $error = "❌ Mã OTP không đúng!";
  }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Xác thực OTP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 col-md-4">
  <h2 class="text-center">🔐 Nhập mã OTP</h2>
  <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <?php if (isset($success)) echo "<div class='alert alert-success'>$success <a href='login_user.php'>Đăng nhập</a></div>"; ?>
  <?php if (!isset($success)): ?>
  <form method="post">
    <div class="mb-3">
      <label>Mã OTP</label>
      <input type="text" name="otp" class="form-control" required>
    </div>
    <button type="submit" name="verify" class="btn btn-success w-100">Xác nhận</button>
  </form>
  <?php endif; ?>
</div>
</body>
</html>
