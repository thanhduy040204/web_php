<?php
$host = "localhost";
$dbname = "shopdb";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
echo "Kết nối database thành công";
?>

