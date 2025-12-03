SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Cơ sở dữ liệu: `basketball_store_db`

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'Basketball Shoe', '2025-10-21 03:05:47'),
(2, 'Ball', '2025-10-21 03:05:47'),
(3, 'Jersey', '2025-10-21 03:05:47'),
(4, 'BasketBall Bag', '2025-10-28 15:38:21');


CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_money` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','shipping','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `orders` (`id`, `user_id`, `total_money`, `status`, `fullname`, `phone`, `address`, `note`, `created_at`) VALUES
(1, 12, 199.99, 'shipping', 'AB', '0908602349', '123, LTK', 'bao giấy', '2025-11-22 13:13:19'),
(2, 12, 199.96, 'cancelled', 'AB', '2222', '2222', '222', '2025-11-22 13:18:19'),
(3, 12, 399.98, 'pending', 'AB', '123456789', '123, LTK', 'no note', '2025-12-01 13:26:08');


CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `variant_id`, `quantity`, `price`) VALUES
(1, 1, 1, 3, 1, 199.99),
(2, 2, 7, 9, 2, 49.99),
(3, 2, 7, 9, 2, 49.99),
(4, 3, 1, 13, 2, 199.99);


CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `manufacturer` varchar(100) DEFAULT NULL,
  `usage_type` enum('Indoor','Outdoor','Both') NOT NULL DEFAULT 'Both',
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `products` (`id`, `name`, `manufacturer`, `usage_type`, `description`, `price`, `image_url`, `category_id`, `created_at`) VALUES
(1, 'Nike LeBron 20', 'Nike', 'Indoor', 'The 20th signature shoe from LeBron James, built for power and speed.', 199.99, 'images/lebron20-2.jpg', 1, '2025-10-09 01:32:48'),
(2, 'Jordan Zion 1', NULL, 'Both', 'Zion Williamson\'s first signature shoe, designed for explosive players.', 129.99, 'images/zion1.webp', 1, '2025-10-09 01:32:48'),
(3, 'Under Armour Curry 10', NULL, 'Both', 'Stephen Curry\'s 10th shoe, optimized for quick cuts and deadly accuracy.', 160.00, 'images/curry10.jpg', 1, '2025-10-09 01:32:48'),
(4, 'Adidas Harden Vol. 7', NULL, 'Both', 'James Harden\'s latest model, focusing on isolation plays and step-backs.', 150.00, 'images/harden7.jpg', 1, '2025-10-09 01:32:48'),
(5, 'Nike Cosmic Unity 2', NULL, 'Both', 'The second version of a trash shoe. ', 99.99, 'images/cosmic2.jpg\r\n', 1, '2025-10-09 03:08:50'),
(6, 'Kyrie Flytrap 5 - Ocean Cube', '', 'Both', 'The fifth flytrap Kyrie shoe for outdoor, suitable for PG and SG. ', 79.99, 'images/kyrieflytrap5.jpg', 1, '2025-10-28 10:39:59'),
(7, 'Brooklyn Nets Jersey', '', 'Both', 'Basketball jersey of Brooklyn Nets team', 49.99, 'images/brooklyn.jpg', 3, '2025-10-28 16:10:13'),
(8, 'Boston Celtics Jersey', NULL, 'Both', 'Basketball jersey of Boston Celtics team', 49.99, 'images/celtic.jpg', 3, '2025-10-28 16:10:13'),
(9, 'Milwaukee Bucks Jersey', NULL, 'Both', 'Basketball jersey of Milwaukee Bucks team', 49.99, 'images/buck.avif', 3, '2025-10-28 16:10:13'),
(10, 'Golden State Warriors Jersey', NULL, 'Both', 'Basketball jersey of Golden State Warriors team', 49.99, 'images/gsw.jpg', 3, '2025-10-28 16:10:13'),
(11, 'Sacramento Kings Jersey', NULL, 'Both', 'Basketball jersey of Sacramento Kings team', 49.99, 'images/king.jpg', 3, '2025-10-28 16:10:13'),
(12, 'Los Angeles Lakers Jersey', NULL, 'Both', 'Basketball jersey of Los Angeles Lakers team', 49.99, 'images/lakerjersey.jpg', 3, '2025-10-28 16:10:13'),
(13, 'Oklahoma City Thunder Jersey', NULL, 'Both', 'Basketball jersey of Oklahoma City Thunder team', 49.99, 'images/okc.jpg', 3, '2025-10-28 16:10:13'),
(14, 'Elite 1 Basketball Bag', 'Nike', 'Both', 'High-quality basketball bag Elite 1', 50.99, 'images/elite1.jpg', 4, '2025-10-28 16:14:08'),
(15, 'Elite 2 Basketball Bag', NULL, 'Both', 'High-quality basketball bag Elite 2', 29.99, 'images/elite2.jpg', 4, '2025-10-28 16:14:08'),
(16, 'Elite 3 Basketball Bag', NULL, 'Both', 'High-quality basketball bag Elite 3', 29.99, 'images/elite3.jpg', 4, '2025-10-28 16:14:08'),
(17, 'Elite 4 Basketball Bag', NULL, 'Both', 'High-quality basketball bag Elite 4', 29.99, 'images/elite4.png', 4, '2025-10-28 16:14:08'),
(18, 'Elite 5 Basketball Bag', NULL, 'Both', 'High-quality basketball bag Elite 5', 29.99, 'images/elite5.jpg', 4, '2025-10-28 16:14:08'),
(19, 'Elite 6 Basketball Bag', NULL, 'Both', 'High-quality basketball bag Elite 6', 29.99, 'images/elite6.jpg', 4, '2025-10-28 16:14:08'),
(20, 'Puma Basketball', NULL, 'Both', 'Durable Puma basketball for indoor and outdoor play', 24.99, 'images/puma.avif', 2, '2025-10-28 16:18:16'),
(21, 'Adidas Basketball', NULL, 'Both', 'Premium Adidas basketball for professional use', 24.99, 'images/adidas.avif', 2, '2025-10-28 16:18:16'),
(22, 'Wilson Basketball', NULL, 'Both', 'Classic Wilson basketball with excellent grip', 24.99, 'images/wilson.png', 2, '2025-10-28 16:18:16'),
(23, 'Wilson 3x3 Basketball', NULL, 'Both', 'Wilson basketball designed for 3x3 games', 24.99, 'images/wilson3x3.jpg', 2, '2025-10-28 16:18:16'),
(24, 'Jordan Basketball', NULL, 'Both', 'Stylish Jordan basketball with high bounce', 24.99, 'images/jordan.webp', 2, '2025-10-28 16:18:16'),
(25, 'Jordan 1 Basketball', NULL, 'Both', 'Jordan 1 series basketball for collectors and players', 24.99, 'images/jordan1.jpg', 2, '2025-10-28 16:18:16'),
(26, 'Molten Basketball', NULL, 'Both', 'Molten basketball used in international competitions', 24.99, 'images/molten.webp', 2, '2025-10-28 16:18:16'),
(28, 'Kobe Bryant Signature Ball', NULL, 'Both', 'Special edition Kobe Bryant basketball', 24.99, 'images/kobeball.avif', 2, '2025-10-28 16:18:16'),
(29, 'Nike Basketball', NULL, 'Both', 'Nike basketball for all kind of court', 24.99, 'images/nike.jpg', 2, '2025-10-28 16:26:21'),
(30, 'Lebron Nike Basketball', NULL, 'Both', 'Lebron Nike basketball with yellow and purple color', 24.99, 'images/lebronnike.jpg', 2, '2025-10-28 16:26:21'),
(31, 'GeruStar Basketball', NULL, 'Both', 'GeruStar basketball made in VietNam', 24.99, 'images/geru.jpg', 2, '2025-10-28 16:26:21'),
(37, 'SB dunk Majin Buuuuuu', 'Nike', 'Both', 'Majin Buu custom shoe', 1000.00, 'https://image-cdn.hypb.st/https%3A%2F%2Fhypebeast.com%2Fimage%2F2022%2F08%2Fandrew-chiou-nike-dunk-low-majin-buu-custom-info-001.jpg?q=90&amp;w=1400&amp;cbr=1&amp;fit=max', 1, '2025-11-14 10:15:22');


CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `is_primary`) VALUES
(1, 1, 'images/lebron20-2.jpg', 1),
(2, 1, 'images/lebron20-1.png', 0),
(3, 7, 'images/brooklyn.jpg', 1),
(4, 8, 'images/celtic.jpg', 1),
(5, 9, 'images/buck.avif', 1),
(6, 10, 'images/gsw.jpg', 1),
(7, 11, 'images/king.jpg', 1),
(8, 12, 'images/lakerjersey.jpg', 1),
(9, 13, 'images/okc.jpg', 1),
(10, 14, 'images/elite1.jpg', 1),
(11, 15, 'images/elite2.jpg', 1),
(12, 16, 'images/elite3.jpg', 1),
(13, 17, 'images/elite4.png', 1),
(14, 18, 'images/elite5.jpg', 1),
(15, 19, 'images/elite6.jpg', 1),
(16, 20, 'images/puma.avif', 1),
(17, 21, 'images/adidas.avif', 1),
(18, 22, 'images/wilson.png', 1),
(19, 23, 'images/wilson3x3.jpg', 1),
(20, 24, 'images/jordan.webp', 1),
(21, 25, 'images/jordan1.jpg', 1),
(22, 26, 'images/molten.webp', 1),
(23, 28, 'images/kobeball.avif', 1),
(24, 29, 'images/nike.jpg', 1),
(25, 30, 'images/lebronnike.jpg', 1),
(26, 31, 'images/geru.jpg', 1),
(28, 3, 'images/curry10.jpg', 1),
(29, 4, 'images/harden7.jpg', 1),
(30, 5, 'images/cosmic2.jpg', 1),
(31, 6, 'images/kyrieflytrap5.jpg', 1),
(32, 6, 'images/kyrieflytrap5.1.jpg', 0),
(33, 5, 'images/cosmic2.1.webp', 0),
(34, 5, 'images/cosmic2.2.jpg', 0),
(35, 37, 'images/buu.1.avif', 1),
(36, 37, 'images/buu.jpg', 0),
(37, 3, 'images/curry10.avif', 0),
(38, 2, 'images/zion1.2.jpg', 0),
(39, 4, 'images/harden7.1.jpg', 0),
(40, 2, 'images/zion1.webp', 1);


CREATE TABLE `product_variants` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `product_variants` (`id`, `product_id`, `size`, `quantity`) VALUES
(2, 1, '42.5', 5),
(3, 1, '43', 89),
(5, 6, '42', 6),
(6, 14, 'Big', 4),
(7, 7, 'S', 5),
(8, 7, 'M', 10),
(9, 7, 'XL', 13),
(10, 7, 'L', 1),
(11, 6, '41', 3),
(12, 6, '47', 8),
(13, 1, '44', 0),
(14, 37, '43', 1),
(15, 37, '44', 4),
(17, 2, '40', 10),
(18, 2, '41', 15),
(19, 2, '42', 20),
(20, 2, '43', 10),
(21, 2, '44', 5),
(22, 3, '40', 8),
(23, 3, '41', 12),
(24, 3, '42', 25),
(25, 3, '42.5', 10),
(26, 3, '44', 6),
(27, 4, '39', 5),
(28, 4, '40', 10),
(29, 4, '41', 15),
(30, 4, '42', 15),
(31, 4, '43', 10),
(32, 5, '41', 20),
(33, 5, '42', 20),
(34, 5, '43', 20),
(35, 5, '44', 5),
(36, 8, 'S', 10),
(37, 8, 'M', 15),
(38, 8, 'L', 20),
(39, 8, 'XL', 5),
(40, 9, 'S', 5),
(41, 9, 'M', 10),
(42, 9, 'L', 15),
(43, 9, 'XL', 5),
(44, 10, 'S', 20),
(45, 10, 'M', 30),
(46, 10, 'L', 25),
(47, 10, 'XL', 10),
(48, 11, 'M', 10),
(49, 11, 'L', 10),
(50, 12, 'S', 15),
(51, 12, 'M', 25),
(52, 12, 'L', 20),
(53, 12, 'XL', 15),
(54, 13, 'M', 12),
(55, 13, 'L', 12),
(56, 15, 'Free Size', 50),
(57, 16, 'Free Size', 30),
(58, 17, 'Free Size', 40),
(59, 18, 'Free Size', 25),
(60, 19, 'Free Size', 35),
(61, 20, 'Size 7', 100),
(62, 21, 'Size 7', 50),
(63, 22, 'Size 7', 60),
(64, 23, 'Size 6', 30),
(65, 24, 'Size 7', 45),
(66, 25, 'Size 7', 20),
(67, 26, 'Size 7', 80),
(68, 28, 'Size 7', 10),
(69, 29, 'Size 7', 55),
(70, 30, 'Size 7', 15),
(71, 31, 'Size 7', 100);


CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `users` (`id`, `email`, `password`, `role`, `created_at`, `name`) VALUES
(1, 'admin@gmail.com', '$2y$10$xvH0VX.UpouU/dFYtNlM.exBNPkyA3arZxKYqRPYotVZBbu0hUEpi', 'admin', '2025-10-29 12:37:43', 'Admin'),
(12, 'ab@gmail.com', '$2y$10$TKUk6L9DPLZbVtNm/9OFPuLUJVBdNYE9yekRd9600mc1qDrt0hm76', 'user', '2025-11-11 15:33:09', 'AB'),
(14, 'michael.j@example.com', '$2y$10$wKxH8U4kQ2jL.VzR.nO6X.k8fG4yW2jK9dZ6gT3xY0mP5eO1qC2a', 'user', '2025-11-11 15:52:15', 'Michael Jordan'),
(15, 'lebron.j@example.com', '$2y$10$wKxH8U4kQ2jL.VzR.nO6X.k8fG4yW2jK9dZ6gT3xY0mP5eO1qC2a', 'user', '2025-11-11 15:52:15', 'LeBron James'),
(16, 'stephen.c@example.com', '$2y$10$wKxH8U4kQ2jL.VzR.nO6X.k8fG4yW2jK9dZ6gT3xY0mP5eO1qC2a', 'user', '2025-11-11 15:52:15', 'Stephen Curry'),
(17, 'kobe.b@example.com', '$2y$10$wKxH8U4kQ2jL.VzR.nO6X.k8fG4yW2jK9dZ6gT3xY0mP5eO1qC2a', 'user', '2025-11-11 15:52:15', 'Kobe Bryant'),
(18, 'kevin.d@example.com', '$2y$10$wKxH8U4kQ2jL.VzR.nO6X.k8fG4yW2jK9dZ6gT3xY0mP5eO1qC2a', 'user', '2025-11-11 15:52:15', 'Kevin Durant'),
(19, 'shaq.o@example.com', '$2y$10$wKxH8U4kQ2jL.VzR.nO6X.k8fG4yW2jK9dZ6gT3xY0mP5eO1qC2a', 'user', '2025-11-11 15:52:15', 'Shaquille ONeal'),
(20, 'larry.b@example.com', '$2y$10$wKxH8U4kQ2jL.VzR.nO6X.k8fG4yW2jK9dZ6gT3xY0mP5eO1qC2a', 'user', '2025-11-11 15:52:15', 'Larry Bird'),
(21, 'magic.j@example.com', '$2y$10$wKxH8U4kQ2jL.VzR.nO6X.k8fG4yW2jK9dZ6gT3xY0mP5eO1qC2a', 'user', '2025-11-11 15:52:15', 'Magic Johnson'),
(22, 'tim.d@example.com', '$2y$10$wKxH8U4kQ2jL.VzR.nO6X.k8fG4yW2jK9dZ6gT3xY0mP5eO1qC2a', 'user', '2025-11-11 15:52:15', 'Tim Duncan');


ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);


ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);


ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `variant_id` (`variant_id`);


ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);


ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;


ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;


ALTER TABLE `product_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;


ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;


ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`);


ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;


ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

