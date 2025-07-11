<?php
session_start();
include 'config.php';

$product = null;

if(isset($_GET['id'])){
  $id = $_GET['id'];
  $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
  $stmt->execute([$id]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Xử lý submit review
if(isset($_POST['submit_review'])){
  $user_name = $_POST['user_name'];
  $rating = $_POST['rating'];
  $comment = $_POST['comment'];

  $stmt_insert = $conn->prepare("INSERT INTO reviews (product_id, user_name, rating, comment) VALUES (?, ?, ?, ?)");
  $stmt_insert->execute([$id, $user_name, $rating, $comment]);

  header("Location: product_detail.php?id=".$id);
  exit();
}

// Lấy rating trung bình
$stmt_rating = $conn->prepare("SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM reviews WHERE product_id = ?");
$stmt_rating->execute([$id]);
$rating_info = $stmt_rating->fetch(PDO::FETCH_ASSOC);
$avg_rating = round($rating_info['avg_rating'],1);
$total_reviews = $rating_info['total_reviews'];

// Lấy sản phẩm liên quan cùng category
$category = $product['category'];
$stmt_related = $conn->prepare("SELECT * FROM products WHERE id != ? AND category = ? ORDER BY RAND() LIMIT 4");
$stmt_related->execute([$id, $category]);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title><?php echo $product ? $product['name'] : "Sản phẩm không tồn tại"; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    .product-image { border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1); object-fit:cover; }
    .star-rating i { color: gold; }
  </style>
</head>
<body>
  <div class="container mt-5">
    <?php if($product): ?>
      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $product['name']; ?></li>
        </ol>
      </nav>

      <div class="card shadow-sm p-4 mb-5">
        <div class="row">
          <div class="col-md-6 mb-3">
            <img src="images/<?php echo $product['image']; ?>" class="img-fluid product-image" alt="<?php echo $product['name']; ?>">
          </div>
          <div class="col-md-6">
            <h2 class="text-success mb-3"><i class="bi bi-box-seam"></i> <?php echo $product['name']; ?></h2>
            <h4 class="text-danger mb-3"><?php echo number_format($product['price']); ?> VND</h4>

            <!-- Rating -->
            <div class="star-rating mb-3">
              <?php
              for($i=1; $i<=5; $i++){
                if($i <= floor($avg_rating)){
                  echo '<i class="bi bi-star-fill"></i>';
                }elseif($i - $avg_rating < 1){
                  echo '<i class="bi bi-star-half"></i>';
                }else{
                  echo '<i class="bi bi-star"></i>';
                }
              }
              ?>
              <span class="text-muted">(<?php echo $avg_rating; ?>/5 từ <?php echo $total_reviews; ?> đánh giá)</span>
            </div>

            <p class="mb-4"><?php echo nl2br($product['description']); ?></p>

            <!-- Thông số kỹ thuật (demo) -->
            <h5>Thông số kỹ thuật</h5>
            <ul>
              <li>Xuất xứ: Việt Nam</li>
              <li>Trọng lượng: 500g</li>
              <li>Loại: Trái cây tươi</li>
            </ul>

            <form method="post" action="cart.php" class="d-flex">
              <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
              <input type="hidden" name="quantity" value="1">
              <button type="submit" name="add_to_cart" class="btn btn-success btn-lg flex-fill">
                <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
              </button>
            </form>

            <a href="index.php" class="btn btn-secondary mt-3">⬅ Quay lại cửa hàng</a>
          </div>
        </div>
      </div>

      <!-- Sản phẩm liên quan -->
      <h4 class="mb-4">🛒 Sản phẩm liên quan</h4>
      <div class="row">
        <?php while($related = $stmt_related->fetch(PDO::FETCH_ASSOC)): ?>
          <div class="col-6 col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
              <a href="product_detail.php?id=<?php echo $related['id']; ?>">
                <img src="images/<?php echo $related['image']; ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
              </a>
              <div class="card-body">
                <h6 class="card-title"><?php echo $related['name']; ?></h6>
                <p class="text-danger mb-0"><?php echo number_format($related['price']); ?> VND</p>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>

      <!-- Review Form -->
      <hr>
      <h5>Đánh giá sản phẩm</h5>
      <form method="post" class="mb-4">
        <div class="mb-2">
          <label class="form-label">Tên của bạn</label>
          <input type="text" name="user_name" class="form-control" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Số sao</label>
          <select name="rating" class="form-select" required>
            <option value="">Chọn đánh giá</option>
            <option value="5">5 sao</option>
            <option value="4">4 sao</option>
            <option value="3">3 sao</option>
            <option value="2">2 sao</option>
            <option value="1">1 sao</option>
          </select>
        </div>
        <div class="mb-2">
          <label class="form-label">Bình luận</label>
          <textarea name="comment" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" name="submit_review" class="btn btn-primary">Gửi đánh giá</button>
      </form>

      <!-- Danh sách review -->
      <h5>⭐ Đánh giá từ khách hàng</h5>
      <?php
      $stmt_reviews = $conn->prepare("SELECT * FROM reviews WHERE product_id = ? ORDER BY created_at DESC");
      $stmt_reviews->execute([$id]);
      while($review = $stmt_reviews->fetch(PDO::FETCH_ASSOC)):
      ?>
        <div class="border rounded p-2 mb-2">
          <strong><?php echo htmlspecialchars($review['user_name']); ?></strong>
          <span class="text-warning">
            <?php for($i=1; $i<=5; $i++){
              echo $i <= $review['rating'] ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>';
            } ?>
          </span>
          <p class="mb-0"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
          <small class="text-muted"><?php echo $review['created_at']; ?></small>
        </div>
      <?php endwhile; ?>

    <?php else: ?>
      <div class="alert alert-danger">
        Sản phẩm không tồn tại.
      </div>
    <?php endif; ?>
  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
