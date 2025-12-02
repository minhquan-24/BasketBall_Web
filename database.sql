CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_images` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT NOT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  `is_primary` BOOLEAN DEFAULT FALSE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `product_variants` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT NOT NULL,
  `size` VARCHAR(10) NOT NULL,
  `quantity` INT NOT NULL DEFAULT 0,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;


INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `category_id`, `created_at`) VALUES
(1, 'Nike LeBron 20', 'The 20th signature shoe from LeBron James, built for power and speed.', 199.99, 'images/lebron20.jpg', 1, '2025-10-09 01:32:48'),
(2, 'Jordan Zion 2', 'Zion Williamson\'s second signature shoe, designed for explosive players.', 129.99, 'images/zion2.jpg', 1, '2025-10-09 01:32:48'),
(3, 'Under Armour Curry 10', 'Stephen Curry\'s 10th shoe, optimized for quick cuts and deadly accuracy.', 160.00, 'images/curry10.jpg', 2, '2025-10-09 01:32:48'),
(4, 'Adidas Harden Vol. 7', 'James Harden\'s latest model, focusing on isolation plays and step-backs.', 150.00, 'images/harden7.jpg', 2, '2025-10-09 01:32:48'),
(5, 'Nike Cosmic Unity 2', 'The second version of a trash shoe. ', 99.99, 'images/cosmic2.jpg\r\n', 1, '2025-10-09 03:08:50');



INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'Signature Player', '2025-10-21 03:05:47'),
(2, 'Lifestyle', '2025-10-21 03:05:47'),
(3, 'Affordable', '2025-10-21 03:05:47');


--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;


INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `category_id`, `created_at`) VALUES ('6', 'Kyrie Flytrap 5 - Ocean Cube', 'The fifth flytrap Kyrie shoe for outdoor, suitable for PG and SG. ', '79.99', 'images/kyrieflytrap5.jpg', '3', current_timestamp());