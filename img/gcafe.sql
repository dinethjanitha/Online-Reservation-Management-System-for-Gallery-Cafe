-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2024 at 07:36 AM
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
-- Database: `gallerycafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `catagory_id` int(11) NOT NULL,
  `catagory_name` varchar(100) NOT NULL,
  `catagory_description` varchar(200) NOT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`catagory_id`, `catagory_name`, `catagory_description`, `is_deleted`) VALUES
(1, 'Special', 'This is our very Spcial Food', 0);

-- --------------------------------------------------------

--
-- Table structure for table `food_origin`
--

CREATE TABLE `food_origin` (
  `origin_id` int(11) NOT NULL,
  `origin_name` varchar(100) NOT NULL,
  `origin_description` varchar(200) NOT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_origin`
--

INSERT INTO `food_origin` (`origin_id`, `origin_name`, `origin_description`, `is_deleted`) VALUES
(1, 'Sri lanka', 'This is sri lanka food', 0),
(2, 'Chainice', 'This is china foods', 0);

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `mealid` int(11) NOT NULL,
  `meal_name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` int(11) NOT NULL,
  `catagory_id` int(11) NOT NULL,
  `origin_id` int(11) NOT NULL,
  `meal_img` varchar(200) NOT NULL,
  `is_delete` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`mealid`, `meal_name`, `description`, `price`, `catagory_id`, `origin_id`, `meal_img`, `is_delete`) VALUES
(3, 'sandwich', 'this is new food', 250, 1, 1, 'img_upload/667a7094059ac6.76880999sandwich.webp', 0),
(4, 'Burger', 'this is new food', 200, 1, 2, 'img_upload/66837f2dea8628.27029582burger.webp', 0);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(20) NOT NULL,
  `menu_img` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menu_id`, `menu_name`, `menu_img`) VALUES
(13, 'promo one', 'img_upload/6696b64955b957.53088594pexels-photo-20147091.webp');

-- --------------------------------------------------------

--
-- Table structure for table `order_meals`
--

CREATE TABLE `order_meals` (
  `order_id` int(11) NOT NULL,
  `mealid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `preorders`
--

CREATE TABLE `preorders` (
  `order_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `orderdate` datetime NOT NULL,
  `needed_date` datetime NOT NULL,
  `order_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `promotion_id` int(11) NOT NULL,
  `promotion_name` varchar(20) NOT NULL,
  `promotion_description` varchar(200) NOT NULL,
  `promotion_img` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`promotion_id`, `promotion_name`, `promotion_description`, `promotion_img`) VALUES
(2, 'new one', 'hehee', 'promotion_imgs/6696bb962ab045.32039479pexels-photo-16499257.webp'),
(3, 'new promo', 'dssdfsdfsf', 'promotion_imgs/6696c064166084.23382997free-photo-of-fields-in-countryside.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `reserved_tables`
--

CREATE TABLE `reserved_tables` (
  `userid` int(11) NOT NULL,
  `table_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `table_id` int(11) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `table_description` varchar(500) NOT NULL,
  `capacity` int(11) NOT NULL,
  `availability` varchar(20) NOT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`table_id`, `table_name`, `table_description`, `capacity`, `availability`, `is_deleted`) VALUES
(1, 'Table Gold', 'This is Vip Table', 8, 'Yes', 0),
(2, 'Table First', 'This is First Table', 4, 'Yes', 0),
(3, 'Main Table', 'This is Main Table', 5, 'Yes', 0),
(4, 'VVIP Table', 'This is VVip Table', 2, 'Yes', 1),
(5, 'Table VVVIP', 'Super Table ', 6, 'Yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_reservation`
--

CREATE TABLE `table_reservation` (
  `reservation_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `reservation_title` varchar(100) NOT NULL,
  `reservation_description` varchar(500) NOT NULL,
  `number_of_guest` int(11) NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_status` varchar(15) NOT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` varchar(50) NOT NULL,
  `lastlogin` datetime NOT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `first_name`, `last_name`, `email`, `password`, `usertype`, `lastlogin`, `is_deleted`) VALUES
(2, 'Dineth', 'Janitha', 'dineth@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'SystemAdmin', '0000-00-00 00:00:00', 0),
(4, 'mess', 'mila', 'messmilame@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'SystemAdmin', '0000-00-00 00:00:00', 0),
(5, 'Indusara', 'Samaranayaka', 'indusara@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'operational', '0000-00-00 00:00:00', 0),
(6, 'dahan', 'tharunetu', 'dahan@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'normaluser', '0000-00-00 00:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`catagory_id`);

--
-- Indexes for table `food_origin`
--
ALTER TABLE `food_origin`
  ADD PRIMARY KEY (`origin_id`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`mealid`),
  ADD KEY `catagory_id` (`catagory_id`),
  ADD KEY `orgin_id` (`origin_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `order_meals`
--
ALTER TABLE `order_meals`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `mealid` (`mealid`);

--
-- Indexes for table `preorders`
--
ALTER TABLE `preorders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`promotion_id`);

--
-- Indexes for table `reserved_tables`
--
ALTER TABLE `reserved_tables`
  ADD KEY `userid` (`userid`),
  ADD KEY `table_id` (`table_id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `table_reservation`
--
ALTER TABLE `table_reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `catagory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `food_origin`
--
ALTER TABLE `food_origin`
  MODIFY `origin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `mealid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `preorders`
--
ALTER TABLE `preorders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `promotion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `table_reservation`
--
ALTER TABLE `table_reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `meals`
--
ALTER TABLE `meals`
  ADD CONSTRAINT `meals_ibfk_1` FOREIGN KEY (`catagory_id`) REFERENCES `categories` (`catagory_id`),
  ADD CONSTRAINT `meals_ibfk_2` FOREIGN KEY (`origin_id`) REFERENCES `food_origin` (`origin_id`);

--
-- Constraints for table `order_meals`
--
ALTER TABLE `order_meals`
  ADD CONSTRAINT `order_meals_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `preorders` (`order_id`),
  ADD CONSTRAINT `order_meals_ibfk_2` FOREIGN KEY (`mealid`) REFERENCES `meals` (`mealid`);

--
-- Constraints for table `preorders`
--
ALTER TABLE `preorders`
  ADD CONSTRAINT `preorders_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `reserved_tables`
--
ALTER TABLE `reserved_tables`
  ADD CONSTRAINT `reserved_tables_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `reserved_tables_ibfk_2` FOREIGN KEY (`table_id`) REFERENCES `tables` (`table_id`);

--
-- Constraints for table `table_reservation`
--
ALTER TABLE `table_reservation`
  ADD CONSTRAINT `table_reservation_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
