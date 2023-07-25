-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: May 12, 2023 at 07:22 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(58, 'CUST000032', 'PROD000002', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

DROP TABLE IF EXISTS `customer_address`;
CREATE TABLE IF NOT EXISTS `customer_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `apartment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer_address`
--

INSERT INTO `customer_address` (`id`, `user_id`, `street_address`, `apartment`, `city`, `state`, `postal_code`) VALUES
(14, 'CUST000006', 'Suhada Mw', '01', 'Panadura', 'Wekada', '12500'),
(2, 'CUST000004', 'Soloman rd', '66', 'Panadura', 'Wekada', '12500'),
(16, 'CUST000032', 'ddlkjfsdjf', 'jdjkads', 'shadaisdd', 'dsadad', '88888');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `total_products` varchar(500) NOT NULL,
  `total_price` int(11) NOT NULL,
  `placed_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(10, 'ORDR000002', 'CUST000004', 'Jerry', 771234567, 'jerry@gmail.com', 'cash on delivery', '66, Soloman rd, Panadura, Wekada, 12500', 'Conditioner (3700 x 1), Shampoo (1200 x 1)', 4900, '2023-05-12 03:47:32', 'pending'),
(9, 'ORDR000001', 'CUST000004', 'Jerry', 771234567, 'jerry@gmail.com', 'cash on delivery', '66, Soloman rd, Panadura, Wekada, 12500', 'Shampoo (1200 x 1), Blood Pressure (40000 x 1)', 41200, '2023-05-12 03:41:32', 'pending'),
(12, 'ORDR000012', 'CUST000032', 'migara', 1234, 'migarakavishan23@gmail.com', 'cash on delivery', 'jdjkads, ddlkjfsdjf, shadaisdd, dsadad, 88888', 'Blood Pressure (40000 x 1)', 40000, '2023-05-12 04:27:00', 'pending');

--
-- Triggers `orders`
--
DROP TRIGGER IF EXISTS `orders_before_insert`;
DELIMITER $$
CREATE TRIGGER `orders_before_insert` BEFORE INSERT ON `orders` FOR EACH ROW BEGIN
    DECLARE next_id INT UNSIGNED;
    DECLARE new_code VARCHAR(20);
    
    -- get the next auto_increment value
    SELECT AUTO_INCREMENT INTO next_id
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'orders';
    
    -- generate a unique code value
    SET new_code = '';
    REPEAT
        SET new_code = CONCAT('ORDR', LPAD(next_id, 6, '0'));
        SET next_id = next_id + 1;
    UNTIL NOT EXISTS (SELECT id FROM orders WHERE  order_id = new_code) END REPEAT;
    
    -- set the code value in the new row
    SET NEW.order_id = new_code;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` varchar(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id`, `name`, `price`, `image`) VALUES
(1, 'PROD000001', 'Blood Pressure', 40000, 'AND-UA-611.jpg'),
(2, 'PROD000002', 'Shampoo', 1200, '4800888212337.01-47264494-png.png'),
(3, 'PROD000003', 'Conditioner', 3700, 'images.jpeg'),
(4, 'PROD000004', 'Ponds FaceWash', 1700, 'Ponds-Face-Wash-Pure-detox.jpg'),
(5, 'PROD000005', 'Olay Face cream', 3200, '1574444309-5dc1ccd2-0a3c-45f7-afab-2a36f6af674f-1-e73c43750a9a828f94092d2ee526bb99-1574444280.jpg'),
(6, 'PROD000006', 'Body Wash', 2400, 'f576a686-a637-41b5-b6b3-a988afe5a27b.jpeg'),
(7, 'PROD000007', 'Body Lotion', 1700, '41N5Rzz37uL._SX679_.jpg'),
(8, 'PROD000008', 'Acne Cream', 1900, 'novaclear-acne-cream.jpg'),
(9, 'PROD000009', 'Cotton Balls', 9500, '61JHN8391EL._AC_SL1500_.jpg');

--
-- Triggers `products`
--
DROP TRIGGER IF EXISTS `products_before_insert`;
DELIMITER $$
CREATE TRIGGER `products_before_insert` BEFORE INSERT ON `products` FOR EACH ROW BEGIN
    DECLARE next_id INT UNSIGNED;
    DECLARE new_code VARCHAR(20);
    
    -- get the next auto_increment value
    SELECT AUTO_INCREMENT INTO next_id
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'products';
    
    -- generate a unique code value
    SET new_code = '';
    REPEAT
        SET new_code = CONCAT('PROD', LPAD(next_id, 6, '0'));
        SET next_id = next_id + 1;
    UNTIL NOT EXISTS (SELECT id FROM products WHERE  product_id = new_code) END REPEAT;
    
    -- set the code value in the new row
    SET NEW.product_id = new_code;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `supplier_id` varchar(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_id`, `name`, `email`, `phone`) VALUES
(2, 'SUPP000001', 'hhjfhh', 'cxczczc@mail.com', 12345678);

--
-- Triggers `suppliers`
--
DROP TRIGGER IF EXISTS `suppliers_before_insert`;
DELIMITER $$
CREATE TRIGGER `suppliers_before_insert` BEFORE INSERT ON `suppliers` FOR EACH ROW BEGIN
    DECLARE next_id INT UNSIGNED;
    DECLARE new_code VARCHAR(20);
    
    -- get the next auto_increment value
    SELECT AUTO_INCREMENT INTO next_id
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'suppliers';
    
    -- generate a unique code value
    SET new_code = '';
    REPEAT
        SET new_code = CONCAT('SUPP', LPAD(next_id, 6, '0'));
        SET next_id = next_id + 1;
    UNTIL NOT EXISTS (SELECT id FROM suppliers WHERE  supplier_id = new_code) END REPEAT;
    
    -- set the code value in the new row
    SET NEW.supplier_id = new_code;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `email`, `name`, `number`, `password`) VALUES
(5, 'CUST000005', 'rick@gmail.com', 'Rick', 767654321, '$2y$10$GN4xHDwYgmz4k.uOqC1Bb.5yEuNm0GvZ.EIlttZtCeO2jC2gTMhQ2'),
(6, 'CUST000006', 'smith@gmail.com', 'Smith', 761234567, '$2y$10$xhVlYffyYeoUGYcPpBrkzeE2jBMgX.P60hO2Qc/wgCoYLoISFyiRe'),
(32, 'CUST000032', 'migarakavishan23@gmail.com', 'migara', 1234, '$2y$10$C9Ki5B0xRQxSpoGhErgD1uHG.x.lE.kP3nONjoNNPqQe9ZR6tHTi6');

--
-- Triggers `users`
--
DROP TRIGGER IF EXISTS `mytable_before_insert`;
DELIMITER $$
CREATE TRIGGER `mytable_before_insert` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    DECLARE next_id INT UNSIGNED;
    DECLARE new_code VARCHAR(20);
    
    -- get the next auto_increment value
    SELECT AUTO_INCREMENT INTO next_id
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'users';
    
    -- generate a unique code value
    SET new_code = '';
    REPEAT
        SET new_code = CONCAT('CUST', LPAD(next_id, 6, '0'));
        SET next_id = next_id + 1;
    UNTIL NOT EXISTS (SELECT id FROM users WHERE user_id = new_code) END REPEAT;
    
    -- set the code value in the new row
    SET NEW.user_id = new_code;
END
$$
DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
