<?php
session_start();

// ===== Thông tin cấu hình MOMO sandbox =====
$endpoint = "https://test-payment.momo.vn/gw_payment/transactionProcessor";
$partnerCode = "MOMO"; // sample đúng là "MOMO"
$accessKey = "F8BBA842ECF85";
$secretKey = "K951B6PE1waDMi640xX08PD3vg6EkVlz";

// ===== Thông tin đơn hàng (demo) =====
$orderInfo = "Thanh toán qua MOMO - Demo";
$amount = "10000"; // ❗ TODO: thay bằng $_SESSION['cart_total'] sau này
$orderId = time() . "";
$requestId = time() . "";
$returnUrl = "http://localhost/web_php/controllers/momo_return.php";
$notifyUrl = "http://localhost/web_php/controllers/momo_notify.php";
$extraData = "";

// ===== Tạo chữ ký (signature) =====
$rawHash = "partnerCode=" . $partnerCode .
           "&accessKey=" . $accessKey .
           "&requestId=" . $requestId .
           "&amount=" . $amount .
           "&orderId=" . $orderId .
           "&orderInfo=" . $orderInfo .
           "&returnUrl=" . $returnUrl .
           "&notifyUrl=" . $notifyUrl .
           "&extraData=" . $extraData;

$signature = hash_hmac("sha256", $rawHash, $secretKey);

// ===== Chuẩn bị dữ liệu gửi MOMO =====
$data = [
    'partnerCode' => $partnerCode,
    'accessKey' => $accessKey,
    'requestId' => $requestId,
    'amount' => $amount,
    'orderId' => $orderId,
    'orderInfo' => $orderInfo,
    'returnUrl' => $returnUrl,
    'notifyUrl' => $notifyUrl,
    'extraData' => $extraData,
    'requestType' => "captureMoMoWallet",
    'signature' => $signature
];

// ===== Gửi yêu cầu thanh toán tới MOMO =====
$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$result = curl_exec($ch);
curl_close($ch);

// ===== Xử lý kết quả =====
$jsonResult = json_decode($result, true);

// ===== Chuyển hướng nếu có URL thanh toán =====
if (isset($jsonResult['payUrl'])) {
    header('Location: ' . $jsonResult['payUrl']);
    exit();
} else {
    echo "❌ Không lấy được payUrl từ MOMO. Kiểm tra lại cấu hình kết nối hoặc debug kết quả dưới đây:";
    echo "<pre>";
    print_r($jsonResult);
    echo "</pre>";
}
?>
