<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Liên hệ MorningFruit</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- ✅ Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../assets/css/style.css?v=1">
</head>
<body>

<?php include '../components/navbar.php'; ?> 

<!-- Liên hệ -->
<div class="container mt-5 mb-4">
  <div class="row g-4">
    <!-- Thông tin -->
    <div class="col-md-6">
      <h1 class="text-success"><i class="bi bi-geo-alt-fill"></i> Liên hệ MorningFruit</h1>
      <p><i class="bi bi-telephone-fill text-primary"></i> Hotline: <strong>0123 456 789</strong></p>
      <p><i class="bi bi-geo-fill text-danger"></i> Địa chỉ: <strong>123 Đường ABC, Quận 1, TP.HCM</strong></p>
      <p><i class="bi bi-envelope-fill text-warning"></i> Email: <strong>contact@morningfruit.com.vn</strong></p>
    </div>

    <!-- Google Map -->
    <div class="col-md-6">
      <div class="ratio ratio-4x3 rounded shadow-sm">
        <iframe
          src="https://www.google.com/maps?q=10.7769,106.7009&hl=vi&z=15&output=embed"
          style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>
  </div>
</div>

<?php include '../components/footer.php'; ?> 

<!-- JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- ✅ Chatbot mini tích hợp -->
<div id="chatbot" class="position-fixed bottom-0 end-0 m-4" style="z-index: 9999;">
  <button class="btn btn-success rounded-circle shadow" onclick="toggleChatbot()" style="width:60px; height:60px;">
    <i class="bi bi-chat-dots-fill fs-4"></i>
  </button>

  <div id="chatbot-box" class="card mt-2 shadow" style="width: 320px; display: none;">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
      <span>💬 Hỗ trợ MorningFruit</span>
      <button class="btn btn-sm btn-light" onclick="toggleChatbot()">&times;</button>
    </div>
    <div class="card-body" style="height: 260px; overflow-y: auto;" id="chat-log">
      <div><strong>Bot:</strong> Xin chào! Bạn cần hỗ trợ gì? 🤖</div>
    </div>
    <div class="card-footer">
      <form onsubmit="sendMessage(event)">
        <div class="input-group">
          <input type="text" id="chat-input" class="form-control" placeholder="Nhập tin nhắn..." autocomplete="off">
          <button class="btn btn-success" type="submit"><i class="bi bi-send"></i></button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function toggleChatbot() {
  const box = document.getElementById('chatbot-box');
  box.style.display = (box.style.display === 'none' || box.style.display === '') ? 'block' : 'none';
}

function sendMessage(e) {
  e.preventDefault();
  const input = document.getElementById('chat-input');
  const log = document.getElementById('chat-log');
  const message = input.value.trim();
  if (!message) return;

  log.innerHTML += `<div><strong>Bạn:</strong> ${message}</div>`;

  let reply = "Xin lỗi, mình chưa rõ câu hỏi của bạn. Bạn có thể hỏi về giờ mở cửa, giao hàng, địa chỉ, hoặc hỗ trợ đơn hàng.";
  const msg = message.toLowerCase();

  if (msg.includes("giờ mở cửa") || msg.includes("mấy giờ")) {
    reply = "⏰ MorningFruit mở cửa từ 8h sáng đến 20h tối mỗi ngày (kể cả cuối tuần).";
  } else if (msg.includes("địa chỉ") || msg.includes("ở đâu")) {
    reply = "📍 Chúng tôi ở 123 Đường ABC, Quận 1, TP.HCM.";
  } else if (msg.includes("giao hàng") || msg.includes("ship")) {
    reply = "🚚 MorningFruit giao hàng nhanh trong TP.HCM (1-2 giờ) và hỗ trợ ship toàn quốc.";
  } else if (msg.includes("phí ship") || msg.includes("tiền ship")) {
    reply = "💵 Phí ship trong TP.HCM là 20.000đ. Miễn phí đơn từ 500.000đ.";
  } else if (msg.includes("khuyến mãi") || msg.includes("sale")) {
    reply = "🎉 Tuần này giảm 10% cho đơn từ 300.000đ!";
  } else if (msg.includes("thanh toán") || msg.includes("trả tiền")) {
    reply = "💳 Thanh toán khi nhận hàng, chuyển khoản hoặc qua ví MoMo.";
  } else if (msg.includes("đặt hàng") || msg.includes("mua")) {
    reply = "🛒 Bạn có thể đặt hàng tại trang sản phẩm và nhấn 'Thêm vào giỏ'.";
  } else if (msg.includes("liên hệ")) {
    reply = "📞 Hotline: 0123 456 789\n📧 Email: contact@morningfruit.com.vn";
  }

  log.innerHTML += `<div><strong>Bot:</strong> ${reply}</div>`;
  input.value = "";
  log.scrollTop = log.scrollHeight;
}
</script>
</body>
</html>
