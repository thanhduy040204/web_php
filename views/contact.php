<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Liên hệ MorningFruit</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
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
<<<<<<< HEAD
      <p><i class="bi bi-telephone-fill text-primary"></i> Hotline: <strong>0896 672 664</strong></p>
      <p><i class="bi bi-geo-fill text-danger"></i> Địa chỉ: <strong>123 Đường ABC, Quận 1, TP.HCM</strong></p>
=======
      <p><i class="bi bi-telephone-fill text-primary"></i> Hotline: <strong>0896672664</strong></p>
      <p><i class="bi bi-geo-fill text-danger"></i> Địa chỉ: <strong>A12/358 ấp 1, xã Phong Phú, huyện Bình Chánh, TP.HCM </strong></p>
>>>>>>> 9cf6b3738cd68084176c883d1e0901b042c80d26
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- ✅ Chatbot nâng cấp -->
<div id="chatbot" class="position-fixed bottom-0 end-0 m-4" style="z-index: 9999;">
  <button class="btn btn-success rounded-circle shadow" onclick="toggleChatbot()" style="width:60px; height:60px;">
    <i class="bi bi-chat-dots-fill fs-4"></i>
  </button>

  <div id="chatbot-box" class="card mt-2 shadow" style="width: 340px; display: none;">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
      <span>💬 Trợ lý MorningFruit</span>
      <button class="btn btn-sm btn-light" onclick="toggleChatbot()">&times;</button>
    </div>
    <div class="card-body" style="height: 280px; overflow-y: auto;" id="chat-log">
      <div class="mb-2"><strong>Bot:</strong> Xin chào 👋! Mình có thể giúp gì cho bạn hôm nay?</div>
      <div class="alert alert-light p-2 rounded">
        <small class="text-muted">❓ Một số câu hỏi thường gặp:</small>
        <ul class="list-unstyled mb-0 mt-1">
          <li><a href="#" onclick="quickAsk('Giờ mở cửa')">🕒 Giờ mở cửa</a></li>
          <li><a href="#" onclick="quickAsk('Địa chỉ cửa hàng ở đâu')">📍 Địa chỉ cửa hàng</a></li>
          <li><a href="#" onclick="quickAsk('Giao hàng thế nào')">🚚 Giao hàng thế nào</a></li>
          <li><a href="#" onclick="quickAsk('Phí ship bao nhiêu')">💵 Phí ship bao nhiêu</a></li>
          <li><a href="#" onclick="quickAsk('Thanh toán thế nào')">💳 Thanh toán thế nào</a></li>
          <li><a href="#" onclick="quickAsk('Thông tin cửa hàng')">ℹ️ Thông tin cửa hàng</a></li>
        </ul>
      </div>
    </div>
    <div class="card-footer">
      <form onsubmit="sendMessage(event)">
        <div class="input-group">
          <input type="text" id="chat-input" class="form-control" placeholder="Nhập câu hỏi..." autocomplete="off">
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

function quickAsk(question) {
  document.getElementById('chat-input').value = question;
  document.getElementById('chat-input').focus();
}

function sendMessage(e) {
  e.preventDefault();
  const input = document.getElementById('chat-input');
  const log = document.getElementById('chat-log');
  const message = input.value.trim();
  if (!message) return;

  log.innerHTML += `<div><strong>Bạn:</strong> ${message}</div>`;

  const msg = message.toLowerCase();
  let reply = "❗ Xin lỗi, mình chưa hiểu rõ câu hỏi. Bạn có thể hỏi về giờ mở cửa, địa chỉ, giao hàng, phí ship, khuyến mãi hoặc hỗ trợ đơn hàng.";

  const responses = {
    "giờ mở cửa": "⏰ MorningFruit mở cửa từ 8h sáng đến 20h tối mỗi ngày (kể cả cuối tuần).",
    "địa chỉ": "📍 Chúng tôi ở 123 Đường ABC, Quận 1, TP.HCM.",
    "ở đâu": "📍 Chúng tôi ở 123 Đường ABC, Quận 1, TP.HCM.",
    "giao hàng": "🚚 Giao hàng nhanh trong TP.HCM (1-2 giờ) và hỗ trợ toàn quốc.",
    "phí ship": "💵 Phí ship nội thành HCM là 20.000đ. Miễn phí đơn từ 500.000đ.",
    "khuyến mãi": "🎉 Tuần này giảm 10% cho đơn từ 300.000đ!",
    "thanh toán": "💳 Có thể thanh toán khi nhận hàng, chuyển khoản hoặc qua ví MoMo.",
    "đặt hàng": "🛒 Vào trang sản phẩm, nhấn 'Thêm vào giỏ' và thanh toán.",
    "mua": "🛒 Vào trang sản phẩm, nhấn 'Thêm vào giỏ' và thanh toán.",
    "liên hệ": "📞 Hotline: 0123 456 789 | 📧 Email: contact@morningfruit.com.vn",
    "chủ cửa hàng":"TRẦN THANH DUY",
    "thông tin cửa hàng":"Cửa hàng MorningFruit được thành lập vào năm 2025 gồm 3 sinh viên Thanh Duy - Hoàng Văn - Phúc Vinh",
    "xin chào":"MorningFruit xin chào! bạn cần chúng tôi giúp gì ?"
  };

  for (const key in responses) {
    if (msg.includes(key)) {
      reply = responses[key];
      break;
    }
  }

  log.innerHTML += `<div><strong>Bot:</strong> ${reply}</div>`;
  input.value = "";
  log.scrollTop = log.scrollHeight;
}
</script>

</body>
</html>
