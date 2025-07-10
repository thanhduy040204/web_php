<?php
session_start();

// 🔧 Dữ liệu MOMO sandbox sample (public test)
$endpoint = "https://test-payment.momo.vn/gw_payment/transactionProcessor";
$partnerCode = "MOMO"; // 🔄 PartnerCode sample chính xác là "MOMO"
$accessKey = "F8BBA842ECF85";
$secretKey = "K951B6PE1waDMi640xX08PD3vg6EkVlz";

// 🔧 Thông tin đơn hàng demo
$orderInfo = "Demo thanh toán MOMO";
$amount = "10000"; // 10,000 VND demo. Sau này thay bằng tổng giỏ hàng
$orderId = time()."";
$returnUrl = "http://localhost/your_project/momo_return.php"; // 🔄 sửa đúng folder project của bạn
$notifyUrl = "http://localhost/your_project/momo_notify.php"; // 🔄 có thể để trống khi demo local
$extraData = "";

// 🔧 Tạo signature
$requestId = time()."";
$requestType = "captureMoMoWallet";
$rawHash = "partnerCode=".$partnerCode
          ."&accessKey=".$accessKey
          ."&requestId=".$requestId
          ."&amount=".$amount
          ."&orderId=".$orderId
          ."&orderInfo=".$orderInfo
          ."&returnUrl=".$returnUrl
          ."&notifyUrl=".$notifyUrl
          ."&extraData=".$extraData;

$signature = hash_hmac("sha256", $rawHash, $secretKey);

// 🔧 Tạo data POST gửi lên MOMO
$data = array(
    'partnerCode' => $partnerCode,
    'accessKey' => $accessKey,
    'requestId' => $requestId,
    'amount' => $amount,
    'orderId' => $orderId,
    'orderInfo' => $orderInfo,
    'returnUrl' => $returnUrl,
    'notifyUrl' => $notifyUrl,
    'extraData' => $extraData,
    'requestType' => $requestType,
    'signature' => $signature
);

// 🔧 Gửi request POST
$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$result = curl_exec($ch);
curl_close($ch);

// 🔧 Xử lý response
$jsonResult = json_decode($result, true);

// 🔧 Hiển thị response để debug
echo "<pre>";
print_r($jsonResult);
echo "</pre>";

// 🔧 Redirect user sang MOMO nếu có payUrl
if (isset($jsonResult['payUrl'])) {
    header('Location: ' . $jsonResult['payUrl']);
    exit();
} else {
    echo "❌ Không lấy được payUrl từ MOMO. Vui lòng kiểm tra PartnerCode, AccessKey, SecretKey và endpoint.";
}
?>
