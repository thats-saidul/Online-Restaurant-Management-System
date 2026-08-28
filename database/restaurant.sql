-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2026 at 01:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `fullname`, `email`, `phone`, `username`, `password`) VALUES
(1, 'Admin', 'admin@admin.com', '00000000000', 'admin', '$2y$10$z2gHLz5Gd7JwwoXzwj3.N.OQY/vKAGloCr8DWfeJTWnm1EsRYY3Ym');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `ID` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`ID`, `fullname`, `email`, `phone`, `password`) VALUES
(1, 'Estiak Ayon', 'estiakayon@gmail.com', '01704617747', '$2y$10$fjJSuYAYUKvbLsM7GIHXaOTHtYR2bDhg96ykhw.T63VER5PuA4N46'),
(4, 'Monkey D Luffy', 'luffy@gmail.com', '01704617747', '$2y$10$rJUtc40.m3Sb6TruirLF3eWW78O7WYwEo7hs5n7cPNXCpK2t1KElm'),
(9, 'shahos', 'shahos@gmail.com', '01704617747', '$2y$10$Z3fm96RbreFt6W9rc/NiLuODgNfp.bWgLjxQD9K4UrZ/1JKNvWysi'),
(12, 'Ekram', 'ekram@gmail.com', '01904617747', '$2y$10$QUfctQrIZsnQg/XvhyBBJur79F26VeaRmtXlwgIV5JbZyLXi9PL/W'),
(13, 'Munia', 'munia@gmail.com', '01316502508', '$2y$10$JGpg6N1/8DoLQ.7H8Oe54uEvUNvLq.4Bv38mZsC0O7bJVmp0VpKgq'),
(14, 'MD Sayed Hasan', 'blkeydsayed@gmail.com', '01616331437', '$2y$10$st.HIvxl0RcEeoB4gXMdFuLsll.SWE0x1aupoxOoUqyTAsk.jFGWe');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `item_name`, `price`, `image`) VALUES
(2, 'Pizza', 450.00, 'images/1748986439_pizza.jpg'),
(3, 'Beef Burger', 400.00, 'images/1749024918_burger.jpg'),
(4, 'French Fries', 200.00, 'images/1749024961_fries.jpg'),
(5, 'Sandwich', 200.00, 'images/1749025003_sandwich.jpg'),
(6, 'Sub Sandwich', 200.00, 'images/1749025028_sub_sandwich.jpg'),
(7, 'Crispy Fried Chicken', 250.00, 'images/1749025113_chicken_fry.jpg'),
(8, 'Crispy Fried Chicken Bucket', 1000.00, 'images/1749025142_bucket.jpg'),
(9, 'Taco', 200.00, 'images/1749025187_tacos.jpg'),
(10, 'Wings', 250.00, 'images/1749025565_wings.jpg'),
(11, 'Pasta', 350.00, 'images/1749025771_pasta.jpg'),
(12, 'Coca Cola', 50.00, 'images/1749026125_cocacola.jpg'),
(13, 'Fanta', 50.00, 'images/1749026138_fanta.jpg'),
(14, 'Blue Lemonade', 200.00, 'images/1749026160_blue_lemonade.jpg'),
(15, 'Cold Coffee', 250.00, 'images/1749026218_coffe.jpg'),
(16, 'Mango Smoothie', 250.00, 'images/1749026257_mango.jpg'),
(17, 'Chocolate Ice Cream', 300.00, 'images/1749026654_chocolate.jpg'),
(18, 'Strawberry Ice Cream', 300.00, 'images/1749026678_strawberry.jpg'),
(19, 'Waffle', 250.00, 'images/1749026697_waffle.jpg'),
(20, 'Cheese Cake', 450.00, 'images/1749026727_cheeesecake.jpg'),
(21, 'Donut', 150.00, 'images/1749026790_donut.jpg'),
(22, 'Beefsteak', 2200.00, 'images/1749887203_beef steak.jpg'),
(23, 'Mashed potato', 250.00, 'images/1749887241_mashed.jpg'),
(24, 'Cappuccino', 700.00, 'images/1749887269_cappuccino.jpg'),
(25, 'Croissant', 300.00, 'images/1749887310_croissant.jpg'),
(26, 'Butter Nan', 90.00, 'images/1750820088_butternan.jpg'),
(27, 'Chicken Grill', 150.00, 'images/1750820123_chickengrill.jpg'),
(28, 'Butter Chicken', 450.00, 'images/1750820164_butterchicken.jpg'),
(29, 'Turkish Kebab Platter', 1200.00, 'images/1750820222_kebab.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rider_id` int(11) DEFAULT NULL,
  `items` text NOT NULL,
  `location` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `rider_id`, `items`, `location`, `total_price`, `status`) VALUES
(1, 1, 1, '{\"8\":2,\"5\":1,\"20\":1}', 'Bashundhara R/A, Dhaka', 0.00, 'accepted'),
(2, 1, 1, '{\"15\":1,\"4\":1,\"17\":1}', 'Gazipur', 0.00, 'accepted'),
(3, 1, 2, '{\"14\":1,\"19\":1,\"20\":1}', 'Dhaka', 0.00, 'accepted'),
(4, 1, 2, '{\"4\":1}', 'Kuril', 0.00, 'accepted'),
(5, 1, 1, '{\"4\":2,\"7\":1}', 'Dhaka', 0.00, 'accepted'),
(6, 5, NULL, '{\"16\":1,\"12\":1,\"11\":1,\"18\":1}', 'Notun Bazar, Dhaka', 0.00, 'pending'),
(7, 6, 2, '{\"2\":1}', 'dsffudsb whdwjd', 0.00, 'accepted'),
(8, 1, 2, '{\"2\":1,\"3\":1,\"5\":1}', 'Mirzapur, Tangail', 0.00, 'accepted'),
(9, 1, 2, '{\"4\":1,\"7\":1,\"12\":1,\"5\":1}', 'Banani, Dhaka', 0.00, 'accepted'),
(10, 1, 2, '{\"16\":1}', 'Gazipur', 0.00, 'accepted'),
(11, 1, NULL, '{\"4\":1}', 'Dhanmondi', 0.00, 'pending'),
(12, 1, NULL, '{\"11\":1,\"14\":1}', 'Gulshan, Dhaka', 0.00, 'pending'),
(13, 9, 2, '{\"2\":1,\"12\":1,\"7\":1}', 'dhaka', 0.00, 'accepted'),
(14, 1, 2, '{\"4\":1}', 'Dhaka', 0.00, 'accepted'),
(15, 1, NULL, '{\"3\":1,\"5\":1}', 'Dhaka\r\n', 0.00, 'pending'),
(16, 1, 2, '{\"3\":1}', 'Bashabo', 0.00, 'accepted'),
(17, 1, 7, '{\"2\":1,\"6\":1,\"10\":2,\"14\":1}', 'Uttara, Dhaka', 0.00, 'accepted'),
(18, 13, NULL, '{\"23\":1}', 'bashabo,kushumbag,dhaka-1214', 0.00, 'pending'),
(19, 1, NULL, '{\"16\":1,\"2\":1}', 'Mirpur, Dhaka', 0.00, 'pending'),
(20, 1, NULL, '{\"27\":1}', 'Dhaka', 0.00, 'pending'),
(21, 1, NULL, '{\"3\":1,\"10\":1}', 'Dhaka', 0.00, 'pending'),
(22, 1, NULL, '{\"27\":1,\"14\":1,\"9\":1}', 'Uttara, Dhaka', 0.00, 'pending'),
(23, 1, NULL, '{\"2\":2}', 'fgfhg', 0.00, 'pending'),
(24, 14, 7, '{\"2\":1,\"3\":1}', 'house', 0.00, 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `riders`
--

CREATE TABLE `riders` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riders`
--

INSERT INTO `riders` (`id`, `fullname`, `email`, `phone`, `password`) VALUES
(2, 'Jack', 'rider@gmail.com', '01704617747', '$2y$10$d8oYcJlRhQX.jtNxw53giuLfLlTL5ZaYFwRtluQ5Wp04F6MrRziVu'),
(4, 'Rahim Ahmed', 'rahim@gmail.com', '01917287651', '$2y$10$TjHfEW3ZxhyB7FFzoQErIuLss45efbSM77/TAF5bO0pMlh24/O7le'),
(5, 'Sumon Mia', 'sumon@gmail.com', '01303963668', '$2y$10$Vd3Gxybx.6nID./HwX/ge.PYPNkse241ejmB02qtHpYWzhvOhBfka'),
(6, 'Roman Ahmed', 'roman@gmail.com', '01712713838', '$2y$10$Ke.0m3fYRFsX.QhHCSUxK.DNWdK6RqqrBrnvbOWci.G/Ye0X2ckAe'),
(7, 'MD Sayed Hasan', 'blkeydsayed@gmail.com', '01616331437', '$2y$10$xWkVzvqO5I/qTAD.WijOge7cCsz21GMbO6Rlj8mxGTyrWrneVDIxa');

-- --------------------------------------------------------

--
-- Table structure for table `sales_analysts`
--

CREATE TABLE `sales_analysts` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_analysts`
--

INSERT INTO `sales_analysts` (`id`, `fullname`, `email`, `phone`, `password`) VALUES
(1, 'MD Sayed Hasan', 'blkeydsayed@gmail.com', '01616331447', '$2y$10$qAKFhlUq3ovR9u3mol8GNu0kb7d0YqfLLsrUvQo1a/JCcr1gNz53K'),
(2, 'Malai', 'malai@gmail.com', '01616331438', '$2y$10$Am26L4NB7kh4HqaUdQtiYuTjM6h6odJpOKoHHmN3hYbd96uq3iC3m'),
(3, 'Shachho', 'shachho@gmail.com', '01768500104', '$2y$10$G91idN2.4wky9kcD246hBOnehKxDgmKCmgJPaiLmrGbONdoG//01.'),
(4, 'Shachhoo', 'shachh0o@gmail.com', '01768500105', '$2y$10$Fg8/D1ULiw9NoA3qDiBeyehWkINXOkcq/5mcdBVaaJi0jSmHJFtu6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riders`
--
ALTER TABLE `riders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `sales_analysts`
--
ALTER TABLE `sales_analysts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `riders`
--
ALTER TABLE `riders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sales_analysts`
--
ALTER TABLE `sales_analysts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
