<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php'; // Đảm bảo đúng đường dẫn

function sendOrderConfirmation($toEmail, $toName, $orderId, $orderItems, $totalPrice) {
    $mail = new PHPMailer(true);

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
        $html .= "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse;'>
                  <tr style='background:#f0f0f0;'><th>Sản phẩm</th><th>Số lượng</th><th>Đơn giá</th><th>Tạm tính</th></tr>";

        foreach ($orderItems as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $html .= "<tr>
                        <td>{$item['name']}</td>
                        <td>{$item['quantity']}</td>
                        <td>" . number_format($item['price']) . "đ</td>
                        <td>" . number_format($subtotal) . "đ</td>
                      </tr>";
        }

        $html .= "</table>";
        $html .= "<h4>💰 Tổng cộng: <span style='color:green'>" . number_format($totalPrice) . "đ</span></h4>";
        $html .= "<p>📦 Đơn hàng sẽ được giao trong vòng 1–2 ngày.</p>";
        $html .= "<p>Cảm ơn bạn đã tin tưởng MorningFruit 🍓</p>";
        $html .= "<p><em>- MorningFruit Team</em></p>";

        $mail->Body = $html;

        $mail->send();
        return true;

    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo; // debug khi cần
        return false;
    }
}
?>
