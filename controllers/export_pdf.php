<?php
require '../config/config.php';
require '../vendor/autoload.php'; // Autoload từ Composer

use Mpdf\Mpdf;

// Kiểm tra đơn hàng
if (!isset($_GET['id'])) {
    die("Thiếu ID đơn hàng.");
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Đơn hàng không tồn tại.");
}

if ($order['status'] !== 'Đã thanh toán') {
    die("Chỉ có thể xuất hoá đơn khi đơn hàng đã thanh toán.");
}

// Nội dung HTML hóa đơn
$html = '
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
    .header { text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 20px; }
    .info { margin-bottom: 15px; }
    .footer { text-align: center; margin-top: 30px; font-style: italic; color: #555; }
    .line { border-top: 1px dashed #999; margin: 15px 0; }
</style>

<div class="header">HOÁ ĐƠN THANH TOÁN</div>

<div class="info">
    <strong>Mã đơn hàng:</strong> ' . $order['id'] . '<br>
    <strong>Khách hàng:</strong> ' . htmlspecialchars($order['customer_name']) . '<br>
    <strong>SĐT:</strong> ' . htmlspecialchars($order['customer_phone']) . '<br>
    <strong>Địa chỉ:</strong> ' . htmlspecialchars($order['customer_address']) . '<br>
    <strong>Ngày đặt:</strong> ' . $order['order_date'] . '<br>
    <strong>Trạng thái:</strong> ' . $order['status'] . '<br>
    <strong>Tổng tiền:</strong> ' . number_format($order['total_price'], 0, ',', '.') . ' VND
</div>

<div class="line"></div>

<div class="footer">Cảm ơn quý khách đã mua hàng tại MorningFruit!</div>
';

// Tạo và xuất PDF
$mpdf = new Mpdf([
    'default_font' => 'DejaVuSans',
    'format' => 'A5'
]);

$mpdf->WriteHTML($html);
$mpdf->Output('hoadon_' . $order['id'] . '.pdf', 'I');
