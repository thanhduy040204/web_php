<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;  

require __DIR__ . '/../vendor/autoload.php';

function sendOrderConfirmation($toEmail, $toName, $orderId, $orderItems, $total, $discount = 0, $promotionName = null) {
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tranthanhduy08699@gmail.com';
        $mail->Password = 'gtun eapq kvtn iaam'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('tranthanhduy08699@gmail.com', 'MorningFruit');
        $mail->addAddress($toEmail, $toName);

        $mail->isHTML(true);
        $mail->Subject = "Xác nhận đơn hàng #$orderId - MorningFruit";

        $html = "<h2>Xin chào $toName,</h2>";
        $html .= "<p>✅ Cảm ơn bạn đã đặt hàng tại <strong>MorningFruit</strong>!</p>";
        $html .= "<h4>🧾 Mã đơn hàng: #$orderId</h4>";
        $html .= "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 100%;'>
                  <tr style='background:#f0f0f0;'><th>Sản phẩm</th><th>Số lượng</th><th>Đơn giá</th><th>Thành tiền</th></tr>";

        foreach ($orderItems as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $html .= "<tr>
                        <td>{$item['name']}</td>
                        <td>{$item['quantity']}</td>
                        <td>" . number_format($item['price'], 0, ',', '.') . "đ</td>
                        <td>" . number_format($subtotal, 0, ',', '.') . "đ</td>
                      </tr>";
        }

        $html .= "</table><br>";
        $html .= "<p><strong>🧾 Tạm tính:</strong> " . number_format($total, 0, ',', '.') . "đ</p>";

        if ($discount > 0 && $promotionName) {
            $html .= "<p><strong>🎁 Khuyến mãi:</strong> $promotionName (-" . number_format($discount, 0, ',', '.') . "đ)</p>";
        }

        $html .= "<p><strong>💰 Tổng thanh toán:</strong> <span style='color:green'>" . number_format($total - $discount, 0, ',', '.') . "đ</span></p>";
        $html .= "<p>📦 Đơn hàng sẽ được giao trong vòng 1–2 ngày.</p>";
        $html .= "<p>🍀 Cảm ơn bạn đã tin tưởng MorningFruit!</p>";
        $html .= "<p><em>- Đội ngũ MorningFruit</em></p>";

        $mail->Body = $html;
        $mail->send();
        return true;

    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
    }
}
