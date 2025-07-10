  <?php
  session_start();
  include 'config.php';

  if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    echo "Username nhập: " . $username . "<br>";
    echo "Password md5 nhập: " . $password . "<br>";


    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if($admin){
      $_SESSION['admin'] = $admin['username'];
      header("Location: dashboard.php");
    }else{
      $error = "Sai tên đăng nhập hoặc mật khẩu!";
    }
  }
  ?>
  <!DOCTYPE html>
  <html lang="vi">
  <head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container mt-5 col-md-4">
    <h2 class="text-center">Admin Login</h2>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post">
      <div class="mb-3">
        <label>Tên đăng nhập</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Mật khẩu</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" name="login" class="btn btn-success w-100">Đăng nhập</button>
    </form>
  </div>
  </body>
  </html>
