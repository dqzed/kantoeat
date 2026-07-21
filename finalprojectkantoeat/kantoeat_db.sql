-- Kanto Eat database
CREATE DATABASE IF NOT EXISTS `kantoeat_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `kantoeat_db`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `order_items`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `menu`;
DROP TABLE IF EXISTS `users`;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fullname` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'customer') NOT NULL DEFAULT 'customer',
  `is_student` ENUM('Yes', 'No') NOT NULL DEFAULT 'No',
  `student_number` VARCHAR(50) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `menu` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `food_name` VARCHAR(150) NOT NULL,
  `category` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `ingredients` TEXT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `availability` ENUM('Available', 'Unavailable') NOT NULL DEFAULT 'Available',
  `featured` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_menu_category` (`category`),
  KEY `idx_menu_availability` (`availability`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `orders` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `total_price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `student_discount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `final_price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `status` ENUM('Pending', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Pending',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_orders_user_id` (`user_id`),
  CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `order_items` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` INT UNSIGNED NOT NULL,
  `menu_id` INT UNSIGNED NOT NULL,
  `quantity` INT UNSIGNED NOT NULL DEFAULT 1,
  `subtotal` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `idx_order_items_order_id` (`order_id`),
  KEY `idx_order_items_menu_id` (`menu_id`),
  CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_items_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`fullname`, `email`, `password`, `role`, `is_student`, `student_number`, `created_at`) VALUES
('Kanto Eat Admin One', 'admin1@kantoeat.com', '$2y$12$uk8VNEC7kpDEh6IG03AdCuga.dgTxkmfKJVEKhCVGXPP2y3nt3Qkm', 'admin', 'No', NULL, '2026-07-18 08:00:00'),
('Kanto Eat Admin Two', 'admin2@kantoeat.com', '$2y$12$uf60y5QMX6iqFPELHf6mYedoHhsxs71rJHhMc.QEaURoHwE.gstYu', 'admin', 'No', NULL, '2026-07-18 08:05:00'),
('Juan dela Cruz', 'juan.delacruz@kantoeat.com', '$2y$12$50Y/bLYvtApHOZbe0R0j6.MpGfmBt6nRhrsXX2BOcpL8xVFWMwwoC', 'customer', 'Yes', '2024-0001', '2026-07-18 08:10:00'),
('Maria Santos', 'maria.santos@kantoeat.com', '$2y$12$50Y/bLYvtApHOZbe0R0j6.MpGfmBt6nRhrsXX2BOcpL8xVFWMwwoC', 'customer', 'Yes', '2024-0002', '2026-07-18 08:11:00'),
('Carlo Reyes', 'carlo.reyes@kantoeat.com', '$2y$12$50Y/bLYvtApHOZbe0R0j6.MpGfmBt6nRhrsXX2BOcpL8xVFWMwwoC', 'customer', 'No', NULL, '2026-07-18 08:12:00'),
('Anne Perez', 'anne.perez@kantoeat.com', '$2y$12$50Y/bLYvtApHOZbe0R0j6.MpGfmBt6nRhrsXX2BOcpL8xVFWMwwoC', 'customer', 'Yes', '2024-0004', '2026-07-18 08:13:00'),
('Josefa Cruz', 'josefa.cruz@kantoeat.com', '$2y$12$50Y/bLYvtApHOZbe0R0j6.MpGfmBt6nRhrsXX2BOcpL8xVFWMwwoC', 'customer', 'No', NULL, '2026-07-18 08:14:00'),
('Mark Bautista', 'mark.bautista@kantoeat.com', '$2y$12$50Y/bLYvtApHOZbe0R0j6.MpGfmBt6nRhrsXX2BOcpL8xVFWMwwoC', 'customer', 'Yes', '2024-0006', '2026-07-18 08:15:00'),
('Nina Garcia', 'nina.garcia@kantoeat.com', '$2y$12$50Y/bLYvtApHOZbe0R0j6.MpGfmBt6nRhrsXX2BOcpL8xVFWMwwoC', 'customer', 'No', NULL, '2026-07-18 08:16:00'),
('Paolo Ramos', 'paolo.ramos@kantoeat.com', '$2y$12$50Y/bLYvtApHOZbe0R0j6.MpGfmBt6nRhrsXX2BOcpL8xVFWMwwoC', 'customer', 'Yes', '2024-0008', '2026-07-18 08:17:00'),
('Clara Lim', 'clara.lim@kantoeat.com', '$2y$12$50Y/bLYvtApHOZbe0R0j6.MpGfmBt6nRhrsXX2BOcpL8xVFWMwwoC', 'customer', 'Yes', '2024-0009', '2026-07-18 08:18:00'),
('Benedict Torres', 'benedict.torres@kantoeat.com', '$2y$12$50Y/bLYvtApHOZbe0R0j6.MpGfmBt6nRhrsXX2BOcpL8xVFWMwwoC', 'customer', 'No', NULL, '2026-07-18 08:19:00');

INSERT INTO `menu` (`food_name`, `category`, `description`, `ingredients`, `price`, `image`, `availability`, `featured`, `created_at`) VALUES
('Longsilog Sunrise', 'Breakfast', 'Classic longganisa with garlic rice and fried egg.', 'Longganisa, garlic rice, egg, tomato', 55.0, 'images/tapsilog.png', 'Available', 1, '2026-07-18 08:20:00'),
('Tapsilog Special', 'Breakfast', 'Tender beef tapa served with rice and egg.', 'Beef tapa, garlic rice, egg', 70.0, 'images/tapsilog.png', 'Available', 1, '2026-07-18 08:21:00'),
('Tocilog Plate', 'Breakfast', 'Sweet tocino, fried egg, and rice for a filling morning meal.', 'Tocino, garlic rice, egg', 60.0, 'images/tapsilog.png', 'Available', 0, '2026-07-18 08:22:00'),
('Chicken Adobo Rice', 'Lunch', 'Filipino chicken adobo with steamed rice and side vegetables.', 'Chicken, soy sauce, vinegar, garlic, rice', 75.0, 'images/adobo_rice.png', 'Available', 1, '2026-07-18 08:23:00'),
('Pork Sinigang Set', 'Lunch', 'Sour tamarind pork soup served with rice.', 'Pork, tamarind, kangkong, radish, rice', 80.0, 'images/adobo_rice.png', 'Available', 0, '2026-07-18 08:24:00'),
('Beef Mechado Bowl', 'Lunch', 'Rich beef stew with potatoes and carrots.', 'Beef, tomato sauce, potato, carrot, rice', 85.0, 'images/adobo_rice.png', 'Unavailable', 0, '2026-07-18 08:25:00'),
('Ginisang Bihon', 'Lunch', 'Stir-fried rice noodles with vegetables and meat.', 'Bihon, chicken, cabbage, carrots', 50.0, 'images/pancit_canton.png', 'Available', 0, '2026-07-18 08:26:00'),
('Pancit Canton Fiesta', 'Lunch', 'Savory pancit canton topped with vegetables and chicken.', 'Canton noodles, chicken, cabbage, carrots', 55.0, 'images/pancit_canton.png', 'Available', 1, '2026-07-18 08:27:00'),
('Lumpiang Shanghai Snack Box', 'Snacks', 'Crispy mini spring rolls with sweet chili dip.', 'Pork, carrots, wrapper, dip', 35.0, 'images/lumpiang_shanghai.png', 'Available', 0, '2026-07-18 08:28:00'),
('Kwek-Kwek Cup', 'Snacks', 'Battered quail eggs with special sauce.', 'Quail eggs, orange batter, sauce', 30.0, 'images/lumpiang_shanghai.png', 'Available', 0, '2026-07-18 08:29:00'),
('Tokwa''t Baboy Meryenda', 'Snacks', 'Tofu and pork bits tossed in a tangy sauce.', 'Tofu, pork, vinegar, onion', 45.0, 'images/lumpiang_shanghai.png', 'Available', 0, '2026-07-18 08:30:00'),
('Turon Duo', 'Snacks', 'Banana spring rolls with caramelized sugar.', 'Banana, wrapper, brown sugar', 25.0, 'images/lumpiang_shanghai.png', 'Available', 0, '2026-07-18 08:31:00'),
('Iced Gulaman', 'Drinks', 'Cold gulaman drink perfect for sunny days.', 'Gulaman, ice, syrup', 20.0, 'images/calamansi_juice.png', 'Available', 0, '2026-07-18 08:32:00'),
('Calamansi Juice', 'Drinks', 'Refreshing citrus juice with ice.', 'Calamansi, water, ice, sugar', 25.0, 'images/calamansi_juice.png', 'Available', 0, '2026-07-18 08:33:00'),
('Sago''t Gulaman', 'Drinks', 'Classic brown sugar drink with sago and gulaman.', 'Sago, gulaman, brown sugar', 25.0, 'images/calamansi_juice.png', 'Unavailable', 0, '2026-07-18 08:34:00'),
('Melon Shake', 'Drinks', 'Chilled melon shake topped with ice.', 'Melon, milk, ice', 35.0, 'images/calamansi_juice.png', 'Available', 0, '2026-07-18 08:35:00'),
('Halo-Halo Mini', 'Desserts', 'A small serving of the classic layered dessert.', 'Shaved ice, leche flan, fruits, beans', 45.0, 'images/halo_halo.png', 'Available', 1, '2026-07-18 08:36:00'),
('Leche Flan Cup', 'Desserts', 'Creamy caramel flan in a cup.', 'Egg yolks, milk, caramel', 30.0, 'images/halo_halo.png', 'Available', 0, '2026-07-18 08:37:00'),
('Buko Pandan', 'Desserts', 'Sweet coconut and pandan dessert salad.', 'Coconut, pandan jelly, cream', 40.0, 'images/halo_halo.png', 'Available', 0, '2026-07-18 08:38:00'),
('Banana Cue Platter', 'Snacks', 'Deep-fried saba bananas coated in brown sugar.', 'Saba banana, brown sugar, oil', 30.0, 'images/lumpiang_shanghai.png', 'Available', 0, '2026-07-18 08:39:00');

INSERT INTO `orders` (`user_id`, `total_price`, `student_discount`, `final_price`, `status`, `created_at`) VALUES
(3, 130.0, 20.0, 110.0, 'Pending', '2026-07-18 09:00:00'),
(5, 155.0, 0.0, 155.0, 'Completed', '2026-07-18 09:10:00'),
(8, 130.0, 20.0, 110.0, 'Pending', '2026-07-18 09:20:00');

INSERT INTO `order_items` (`order_id`, `menu_id`, `quantity`, `subtotal`) VALUES
(1, 1, 1, 55.0),
(1, 13, 2, 50.0),
(1, 12, 1, 25.0),
(2, 4, 1, 75.0),
(2, 18, 1, 30.0),
(2, 15, 2, 50.0),
(3, 2, 1, 70.0),
(3, 14, 1, 35.0),
(3, 17, 1, 25.0);
