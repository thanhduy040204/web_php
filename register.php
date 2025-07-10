<?php
session_start();
include 'config.php';

if(isset($_POST['register'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  // Check email đã tồn tại chưa
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  if($stmt->rowCount() > 0){
    $error = "Email đã tồn tại!";
  }else{
    // Insert user mới
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $password]);
    $success = "Đăng ký thành công! Vui lòng đăng nhập.";
  }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 col-md-4">
  <h2 class="text-center">Đăng ký tài khoản</h2>
  <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
  <form method="post">
    <div class="mb-3">
      <label>Họ tên</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Mật khẩu</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" name="register" class="btn btn-success w-100">Đăng ký</button>
    <p class="mt-2">Đã có tài khoản? <a href="login_user.php">Đăng nhập</a></p>
  </form>
</div>
</body>
</html>
