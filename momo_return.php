<?php
if($_GET['errorCode'] == 0){
  echo "<h1 style='color: green;'>✅ Thanh toán thành công!</h1>";
  echo "Mã đơn hàng: ".$_GET['orderId']."<br>";
  echo "Số tiền: ".$_GET['amount']." VND";
}else{
  echo "<h1 style='color: red;'>❌ Thanh toán thất bại!</h1>";
}
?>
