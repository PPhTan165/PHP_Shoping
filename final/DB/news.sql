-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 13, 2023 at 02:57 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `news`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Áo thun'),
(2, 'Áo sơ mi'),
(3, 'Áo polo'),
(4, 'Áo hoodie'),
(5, 'Quần Jean'),
(6, 'Quần Thun'),
(7, 'Đội vô địch');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE IF NOT EXISTS `manufacturer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `name`) VALUES
(1, 'Vĩnh Long'),
(2, 'TP Hồ Chí Minh'),
(3, 'Tiền Giang'),
(4, 'Long An'),
(5, 'Bình Dương'),
(6, 'Cà Mau'),
(7, 'Hà Nội'),
(8, 'Cần Thơ'),
(9, 'Tây Ninh'),
(10, 'Đà Nẵng'),
(11, 'LonDon'),
(12, 'Hải Phòng'),
(13, 'Trà Vinh'),
(14, 'Quảng Ninh'),
(15, 'Troai ùm'),
(16, 'Spain');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` float NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `total`, `status`, `user_id`) VALUES
(110, '', 999000, 'cancel', 3),
(111, '', 298000, 'cancel', 3);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantity` int NOT NULL,
  `orders_id` int NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_details` (`orders_id`),
  KEY `fk_details_product` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `quantity`, `orders_id`, `product_id`) VALUES
(34, 1, 110, 3),
(35, 1, 111, 4),
(36, 1, 111, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `stocks` int NOT NULL,
  `review` int NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manufacturer_id` int NOT NULL,
  `categories_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_manufacturer_product` (`manufacturer_id`),
  KEY `fk_categories_product` (`categories_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `stocks`, `review`, `image`, `manufacturer_id`, `categories_id`) VALUES
(1, 'Áo thun đen 2.0', 99000, 50, 5, 'Black_T-shirt.png', 1, 1),
(2, 'Hoodie be', 999000, 5, 10, 'hoodie-be.jpg', 2, 4),
(3, 'Sơ mi xanh', 999000, 50, 10, 'ao-so-mi-xanh.jpg', 2, 2),
(4, 'Quần Evisu', 199000, 200, 300, 'quan-evisu.jpg', 5, 5),
(5, 'Quần guuci dài', 1000000, 50, 5, 'quan-gucci-long.jpg', 7, 6),
(6, 'Áo thun đỏ', 99000, 100, 100, 'Red_T-shirt.png', 6, 1),
(7, 'Quần LV', 1000000, 100, 300, 'quan-LV.jpg', 7, 1),
(8, 'Polo đen', 99000, 100, 100, 'polo_black.jpg', 2, 3),
(9, 'polo trắng', 99000, 100, 100, 'polo_white.jpg', 2, 3),
(10, 'Áo Tottenham Hotspur', 5000000, 1, 0, 'champion-tshirt.jpg', 11, 7),
(11, 'Polo vàng', 99000, 100, 100, 'polo_yellow.jpg', 2, 3),
(12, 'Sơ mi xanh đen', 99000, 100, 100, 'ao-so-mi-xanh-den.jpg', 1, 2),
(13, 'Milan', 99000, 50, 100, 'MILAN.jpg', 1, 7),
(14, 'Real', 99000, 50, 100, 'REAL.jpg', 1, 7),
(15, 'Áo thun xanh lá', 99000, 50, 100, 'ao-thun-xanh.jpg', 2, 1),
(16, 'Áo thun xanh đậm', 99000, 100, 100, 'ao-thun-xanh2.jpg', 1, 1),
(17, 'Quần guuci', 1000000, 100, 100, 'quan-gucci-long.jpg', 2, 6),
(18, 'Quần guuci ngắn', 1000000, 100, 100, 'quan-gucci-short.jpg', 2, 6),
(20, 'Áo đen thui', 10000, 10, 0, 'Black_T-shirt.png', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_role_user` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `password`, `fullname`, `id`, `role_id`) VALUES
('user1@gmail.com', '123456', 'Nguyen Van A', 1, 2),
('user2@gmail.com', '123456', 'Nguyen Van B', 2, 2),
('meollo74@gmail.com', '1230f85672a0b50349ead2ea02ab9ff0', 'Phan Phuc Tan', 3, 2),
('user4@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Lê Văn Tư', 4, 2),
('admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 5, 1),
('user20@gmail.com', '202cb962ac59075b964b07152d234b70', 'User20', 6, 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_details_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_order_details` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_categories_product` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_manufacturer_product` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_role_user` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
