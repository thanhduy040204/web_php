<?php
session_start();
include '../config/config.php';

$product = null;

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
  $stmt->execute([$id]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Review submit
if (isset($_POST['submit_review'])) {
  $user_name = $_POST['user_name'];
  $rating = $_POST['rating'];
  $comment = $_POST['comment'];

  $stmt_insert = $conn->prepare("INSERT INTO reviews (product_id, user_name, rating, comment) VALUES (?, ?, ?, ?)");
  $stmt_insert->execute([$id, $user_name, $rating, $comment]);
  header("Location: product_detail.php?id=" . $id);
  exit();
}

// Avg rating
$stmt_rating = $conn->prepare("SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM reviews WHERE product_id = ?");
$stmt_rating->execute([$id]);
$rating_info = $stmt_rating->fetch(PDO::FETCH_ASSOC);
$avg_rating = round($rating_info['avg_rating'], 1);
$total_reviews = $rating_info['total_reviews'];

// Related
$category = $product['category'] ?? '';
$stmt_related = $conn->prepare("SELECT * FROM products WHERE id != ? AND category = ? ORDER BY RAND() LIMIT 4");
$stmt_related->execute([$id, $category]);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title><?= $product ? $product['name'] : "Sản phẩm không tồn tại"; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    .product-image { border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1); object-fit:cover; width:100%; height: 400px; }
    .star-rating i { color: gold; }
    .card-related img { height: 160px; object-fit: cover; }
  </style>
</head>
<body>
<div class="container mt-5">
  <?php if($product): ?>
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
        <li class="breadcrumb-item active"><?= htmlspecialchars($product['name']); ?></li>
      </ol>
    </nav>

    <div class="row mb-5">
      <!-- Image -->
      <div class="col-md-6">
        <img src="../assets/images/<?= $product['image']; ?>" alt="<?= $product['name']; ?>" class="product-image">
      </div>

      <!-- Info -->
      <div class="col-md-6">
        <h2 class="text-success"><?= $product['name']; ?></h2>
        <h4 class="text-danger"><?= number_format($product['price']); ?> VND</h4>
        <div class="star-rating mb-2">
          <?php for($i=1; $i<=5; $i++): ?>
            <?= $i <= floor($avg_rating) ? '<i class="bi bi-star-fill"></i>' : ($i - $avg_rating < 1 ? '<i class="bi bi-star-half"></i>' : '<i class="bi bi-star"></i>'); ?>
          <?php endfor; ?>
          <span class="text-muted">(<?= $avg_rating ?>/5 từ <?= $total_reviews ?> đánh giá)</span>
        </div>
        <p><?= nl2br($product['description']); ?></p>

        <ul>
          <li>Xuất xứ: Việt Nam</li>
          <li>Trọng lượng: 500g</li>
          <li>Loại: Trái cây tươi</li>
        </ul>

        <form method="post" action="../cart/cart.php" class="d-flex mt-3">
          <input type="hidden" name="id" value="<?= $product['id']; ?>">
          <input type="hidden" name="quantity" value="1">
          <button type="submit" name="add_to_cart" class="btn btn-success btn-lg flex-fill">
            <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
          </button>
        </form>
        <a href="index.php" class="btn btn-secondary mt-3">⬅ Quay lại cửa hàng</a>
      </div>
    </div>

    <!-- Related -->
    <h4 class="mb-3">🛒 Sản phẩm liên quan</h4>
    <div class="row mb-4">
      <?php while($related = $stmt_related->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="col-md-3 col-sm-6 mb-3">
          <div class="card card-related shadow-sm">
            <a href="product_detail.php?id=<?= $related['id']; ?>">
              <img src="../assets/images/<?= $related['image']; ?>" class="card-img-top" alt="<?= $related['name']; ?>">
            </a>
            <div class="card-body text-center">
              <h6><?= $related['name']; ?></h6>
              <p class="text-danger"><?= number_format($related['price']); ?> VND</p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- Review Form -->
    <hr>
    <h5 class="mb-3">⭐ Gửi đánh giá</h5>
    <form method="post">
      <div class="row">
        <div class="col-md-4 mb-2">
          <input type="text" name="user_name" class="form-control" placeholder="Tên của bạn" required>
        </div>
        <div class="col-md-3 mb-2">
          <select name="rating" class="form-select" required>
            <option value="">Đánh giá sao</option>
            <?php for($i=5; $i>=1; $i--): ?>
              <option value="<?= $i ?>"><?= $i ?> sao</option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-md-5 mb-2">
          <input type="text" name="comment" class="form-control" placeholder="Nhận xét của bạn..." required>
        </div>
      </div>
      <button type="submit" name="submit_review" class="btn btn-primary mt-2">Gửi đánh giá</button>
    </form>

    <!-- Review List -->
    <hr>
    <h5 class="mb-3">📢 Đánh giá khách hàng</h5>
    <?php
    $stmt_reviews = $conn->prepare("SELECT * FROM reviews WHERE product_id = ? ORDER BY created_at DESC");
    $stmt_reviews->execute([$id]);
    while($review = $stmt_reviews->fetch(PDO::FETCH_ASSOC)):
    ?>
      <div class="border p-3 mb-2 rounded">
        <strong><?= htmlspecialchars($review['user_name']); ?></strong>
        <div class="text-warning">
          <?php for($i=1; $i<=5; $i++): ?>
            <?= $i <= $review['rating'] ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>'; ?>
          <?php endfor; ?>
        </div>
        <p class="mb-0"><?= nl2br(htmlspecialchars($review['comment'])); ?></p>
        <small class="text-muted"><?= $review['created_at']; ?></small>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="alert alert-danger">Sản phẩm không tồn tại.</div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
