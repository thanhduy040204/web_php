<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php'; 
include '../config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['send_otp'])) {
  $email = trim($_POST['email']);

  // Kiểm tra xem email có tồn tại không
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    $_SESSION['reset_email'] = $email;
    $_SESSION['reset_otp'] = rand(100000, 999999);

    // Gửi OTP qua email
    $otp = $_SESSION['reset_otp'];
    $toName = $user['name'];

    try {
      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'tranthanhduy08699@gmail.com';
      $mail->Password = 'gtun eapq kvtn iaam';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Hoặc dùng 'tls'
      $mail->Port = 587;

      $mail->setFrom('tranthanhduy08699@gmail.com', 'MorningFruit');
      $mail->addAddress($email, $toName);
      $mail->isHTML(true);
      $mail->Subject = "🔐 Mã OTP khôi phục mật khẩu - MorningFruit";
      $mail->Body = "<p>Xin chào <strong>$toName</strong>,</p>
                     <p>Bạn đã yêu cầu khôi phục mật khẩu. Đây là mã OTP của bạn:</p>
                     <h2 style='color:green;'>$otp</h2>
                     <p>Vui lòng nhập mã này vào trang xác thực để tiếp tục.</p>
                     <p><em>- Đội ngũ MorningFruit 🍓</em></p>";
      $mail->send();

      header("Location: reset_otp_verify.php");
      exit();

    } catch (Exception $e) {
      $error = "❌ Không thể gửi email: " . $mail->ErrorInfo;
    }

  } else {
    $error = "❌ Email không tồn tại trong hệ thống!";
  }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quên mật khẩu</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container col-md-4 mt-5">
  <h3>🔑 Quên mật khẩu</h3>
  <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="post">
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <button name="send_otp" class="btn btn-primary w-100">Gửi mã OTP</button>
  </form>
</div>
</body>
</html>
