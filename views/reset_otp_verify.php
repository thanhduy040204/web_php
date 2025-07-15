<?php
session_start();
if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_otp'])) {
  header("Location: forgot_password.php");
  exit();
}

if (isset($_POST['verify'])) {
  if ($_POST['otp'] == $_SESSION['reset_otp']) {
    $_SESSION['otp_verified'] = true;
    header("Location: reset_password.php");
    exit();
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container col-md-4 mt-5">
  <h3>✅ Nhập mã OTP</h3>
  <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="post">
    <div class="mb-3">
      <label>Mã OTP</label>
      <input type="text" name="otp" class="form-control" required>
    </div>
    <button name="verify" class="btn btn-success w-100">Xác nhận</button>
  </form>
</div>
</body>
</html>
