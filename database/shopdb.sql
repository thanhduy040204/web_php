-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 16, 2025 lúc 07:58 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shopdb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'duy', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Chờ xác nhận'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `customer_phone`, `customer_address`, `total_price`, `order_date`, `status`) VALUES
(1, NULL, 'trần thanh duy', '0383764654', '116 NGUYỄN THỊ TẦN', 271000, '2025-07-10 08:12:51', 'Đã thanh toán'),
(2, NULL, 'nguyễn văn a', '03947244', 'Quận 1', 295000, '2025-07-10 08:36:39', 'Đã thanh toán'),
(3, NULL, 'nguyễn phúc vinh', '03947290202', 'Quận gò vấp', 90000, '2025-07-10 08:46:19', 'Đã thanh toán'),
(4, NULL, 'Lưu Thị Trúc Linh', '098365472', 'Quận Bình Thạnh', 417000, '2025-07-10 14:35:32', 'Đã thanh toán'),
(5, NULL, 'Nguyễn Văn F', '0987345762', 'Quận 6', 11627000, '2025-07-10 15:08:45', 'Đã huỷ'),
(7, NULL, 'Nguyễn Văn H', '0909876234', 'Quận Bình Thanh', 325000, '2025-07-10 15:42:57', 'Đã thanh toán'),
(8, NULL, 'h', '0', '1', 100000, '2025-07-10 16:28:59', 'Đã thanh toán'),
(9, NULL, 'nguyen van f', '0809', 'bình thạnh', 330000, '2025-07-11 21:23:30', 'Đã thanh toán'),
(10, NULL, 'Duy Trần Thanh', '0383764654', '116 NGUYỄN THỊ TẦN', 360000, '2025-07-13 09:33:20', 'Đã huỷ'),
(11, NULL, 'Nguyễn Văn F', '0909465823', 'Phường Cát Lái', 2580000, '2025-07-13 15:19:07', 'Đã thanh toán'),
(12, NULL, 'Hiếu Thứ Hai', '0383764654', 'Huyện Hóc Môn', 900000, '2025-07-13 18:18:52', 'Chờ xác nhận'),
(13, NULL, 'Mai Hoàng Văn', '0896672664', 'Địa chỉ nhà Mai hoàng văn', 5735000, '2025-07-13 18:25:45', 'Đã thanh toán'),
(14, NULL, 'Huỳnh Thạch Thụy', '0909624008', 'Quận 7', 4125000, '2025-07-14 08:05:28', 'Chờ xác nhận'),
(15, NULL, 'Huỳnh Thạch Thụy', '0909624008', 'Quận 7', 4125000, '2025-07-14 08:07:12', 'Chờ xác nhận'),
(16, NULL, 'Phạm Bảo Khang', '0383764654', 'Quận 12', 84272000, '2025-07-15 10:41:55', 'Đã thanh toán'),
(17, NULL, 'Huỳnh Thạch Thụy', '0909624008', 'Quận 7', 600000, '2025-07-16 12:24:18', 'Chờ xác nhận');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(2, 1, 6, 2, 55000),
(3, 1, 7, 3, 37000),
(4, 1, 9, 1, 30000),
(5, 2, 3, 1, 90000),
(6, 2, 1, 1, 25000),
(7, 2, 7, 1, 37000),
(8, 2, 5, 1, 45000),
(9, 2, 10, 1, 40000),
(10, 2, 12, 1, 23000),
(11, 2, 11, 1, 35000),
(12, 3, 1, 1, 25000),
(13, 3, 2, 1, 30000),
(14, 3, 11, 1, 35000),
(15, 4, 1, 1, 25000),
(16, 4, 3, 1, 90000),
(17, 4, 7, 1, 37000),
(18, 4, 6, 1, 55000),
(19, 4, 8, 2, 60000),
(20, 4, 11, 1, 35000),
(21, 4, 9, 1, 25000),
(22, 4, 2, 1, 30000),
(23, 5, 1, 34, 25000),
(24, 5, 3, 34, 90000),
(25, 5, 6, 50, 55000),
(26, 5, 7, 12, 37000),
(27, 5, 12, 1, 23000),
(28, 5, 5, 100, 45000),
(29, 7, 1, 10, 25000),
(30, 7, 4, 5, 15000),
(31, 8, 1, 4, 25000),
(32, 9, 1, 11, 30000),
(33, 10, 2, 12, 30000),
(34, 11, 8, 43, 60000),
(35, 12, 2, 30, 30000),
(36, 13, 2, 1, 30000),
(37, 13, 1, 2, 30000),
(38, 13, 4, 3, 15000),
(39, 13, 10, 50, 40000),
(40, 13, 8, 60, 60000),
(41, 14, 2, 20, 30000),
(42, 14, 3, 20, 90000),
(43, 14, 5, 20, 45000),
(44, 14, 11, 10, 35000),
(45, 14, 9, 19, 25000),
(46, 15, 2, 20, 30000),
(47, 15, 3, 20, 90000),
(48, 15, 5, 20, 45000),
(49, 15, 11, 10, 35000),
(50, 15, 9, 19, 25000),
(51, 16, 13, 4, 28000),
(52, 16, 1, 15, 30000),
(53, 16, 4, 100, 15000),
(54, 16, 6, 22, 55000),
(55, 16, 3, 300, 90000),
(56, 16, 8, 900, 60000),
(57, 17, 2, 20, 30000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`, `category`) VALUES
(1, 'Táo Mỹ', 30000, 'Táo Mỹ Nhập Khẩu chất lượng cao', 'apple.jpg', 'Trái cây'),
(2, 'Cam Úc', 30000, 'Cam úc ngọt tự nhiên', 'orange.jpg', 'Trái cây'),
(3, 'Sầu riêng', 90000, 'bao ăn thơm ngon', 'tải xuống (2).jpg', 'Trái cây'),
(4, 'Kiwi', 15000, 'kiwi thơm ngon ', 'tải xuống (3).jpg', 'Rau củ'),
(5, 'Nho Mỹ', 45000, 'Nho Mỹ tươi ngon ', 'nho.jpg', 'Rau củ'),
(6, 'Lê hàn quốc', 55000, 'Lê Hàn thơm ngon', 'le.jpg', 'Rau củ'),
(7, 'Mận hà nội', 37000, 'Mận giòn ngọt', 'man.jpg', NULL),
(8, 'Dâu tây đà lạt', 60000, 'Dâu tây đỏ mộng', 'dau.jpg', NULL),
(9, 'Thanh long ruột đỏ', 25000, 'Thanh long ngọt mát', 'thanhlong.jpg', NULL),
(10, 'Bơ sáp', 40000, 'Bơ sáp dẻo béo', 'bo.jpg', NULL),
(11, 'Xoài cát hòa lộc', 35000, 'Xoài ngọt thơm', 'xoai.jpg', NULL),
(12, 'Chôm chôm', 29000, 'Chôm chôm ngọt nước, bao ăn', 'chomchom.jpg', NULL),
(13, 'Trái mãng cầu', 28000, 'Mãng cầu thơm ngon, bao ăn , bao hạt', 'mangcau.jpg', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_name`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 'Duy Thanh', 5, 'Sản phẩm tươi ngon, giá hợp lý!', '2025-07-11 22:43:58'),
(2, 1, 'Minh Phuong', 4, 'Ngon nhưng giao hơi chậm', '2025-07-11 22:43:58'),
(3, 2, 'sơn tùng mtp', 5, 'rất ngon nên mua ăn thử', '2025-07-11 22:44:49'),
(4, 3, 'Phạm Bảo Khang', 5, 'Sầu riêng thơm ngon, múi to, hạt lép, tui thấy ăn rất ngon thơm miệng, không có mùi hóa chất và giá cũng phải chăng , mọi người nên mua và dùng thử, nhân viên bán rất có tâm và thân thiện với khách hàng , chỗ bán sạch sẽ qui trình mua bán rõ ràng 10 điểm', '2025-07-15 10:40:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `email`, `password`) VALUES
(1, 'nguyễn văn B', NULL, 'nguyenvanB@gmai.com', '$2y$10$JPyhwZ4nn4tOQngiBhx1XuGVW08N.7Fc1o/BTwDBh4dXq/FW6dqN.'),
(2, 'Nguyễn Văn F', NULL, 'nguyenvanF@gmail.com', '$2y$10$AVqRM9ivvWr38d5j0nnUpevL6oQoUbCBLFbXzIyM4iYjnjlMZT0He'),
(3, 'Nguyễn Văn H', NULL, 'nguyenvanH@gmail.com', '$2y$10$Xad.zK8eHQLYGMVnPwWKPeVUrdsimt0FLJGyA1HtHMMvQETpsTs6i'),
(4, 'Nguyễn văn hi', '0383764654', 'nguyenvanhi0403@gmail.com', '$2y$10$zMSq0YJqFn43ayydox.XXOMB0Kwl7iIV7jafoxx4M6chfsJg7n.H.'),
(5, 'nguyenvanz', '0374992782', 'nguyenvanz@gmail.com', '$2y$10$COrs.61U2FpZzmZBeI6riOSZwLe0MPITtxIprA0uMTCTA8YdFLRbe'),
(6, 'Mai Hoàng Văn', '0896672664', 'vanmai756@gmail.com', '$2y$10$yFxgwMoUpjdwGTM.UOpQfejYQSznfg/d54IimHi.DxAaeFT6s0Peu'),
(7, 'Huỳnh Thạch Thụy', '0909624008', 'thuyhuynhthach241220@gmail.com', '$2y$10$kCIYKoBZK4vzIjC4mELeSumrioMOnDdUF4ycUf94.zGURy4wjthnC'),
(8, 'Phạm Bảo Khang', '0383764654', 'tranthanhduy08699@gmail.com', '$2y$10$JtkZpgHO3pyAnDLSTVmsAuViwq3t1E7gWGR8puokcCnD1j1lkb3ea');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
