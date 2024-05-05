-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2023 at 01:13 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mypoerty_in`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_card`
--

CREATE TABLE `category_card` (
  `id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `data-filter` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_card`
--

INSERT INTO `category_card` (`id`, `title`, `details`, `data-filter`, `img`) VALUES
(1, 'Friendship Day', 'Veniam debitis quaerat officiis quasi cupiditate quo, quisquam velit, magnam voluptatem repellendus sed eaque', 'Friendship', 'source/menu/friendship.png'),
(2, 'Proposal For Crush', 'Veniam debitis quaerat officiis quasi cupiditate quo, quisquam velit, magnam voluptatem repellendus sed eaque', 'love', 'source/menu/propose.png'),
(3, 'For Marriage', 'Veniam debitis quaerat officiis quasi cupiditate quo, quisquam velit, magnam voluptatem repellendus sed eaque', 'love marreige', 'source/menu/marrige.png'),
(4, 'Mother Day', 'Best 49 Poetries collection ', 'perents', 'source/menu/Mothersday.png'),
(5, 'Father Day', 'Veniam debitis quaerat officiis quasi cupiditate quo, quisquam velit, magnam voluptatem repellendus sed eaque', 'perents', 'source/menu/fathersday.png'),
(6, 'Baby Shower', 'Veniam debitis quaerat officiis quasi cupiditate quo, quisquam velit, magnam voluptatem repellendus sed eaque', 'love marreige', 'source/menu/babyshower.png'),
(7, 'Apology / Sorry', 'Veniam debitis quaerat officiis quasi cupiditate quo, quisquam velit, magnam voluptatem repellendus sed eaque', 'sad', 'source/menu/apologyorsorry.png'),
(8, 'Break Up', 'asdadsad', 'sad', ' source/menu/breakup.png'),
(9, 'Death Anniversary', '', 'sad', 'source/menu/deathanniversry.png');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `quiery` varchar(100) NOT NULL,
  `additional` varchar(200) NOT NULL,
  `screenshot` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `rating` int(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_img` varchar(255) NOT NULL,
  `rating_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `user_name`, `rating`, `description`, `user_img`, `rating_date`) VALUES
(1, 20, 'Rinkesh', 5, 'This Website is Awsome. Perfect Customer care and other stuff Ayush', 'source/Images/client1.jpg', '2023-11-21'),
(3, 20, 'Anmol', 5, 'This Website is Awsome. Perfect Customer care and other stuff', 'source/Images/client1.jpg', '2023-09-20'),
(15, 22, 'desirest.exe', 5, 'This site\'s service is top-notch! From navigation to support, it\'s incredibly smooth. Highly recommended! 👌', 'source/profile/defult.jpg', '2023-10-23'),
(19, 21, 'ayush.exe', 5, 'Fast Delevery and superb customer support 5 stars Must Try this Plateform and there services thanks.', 'source/profile/defult.jpg', '2023-10-27'),
(20, 22, 'sattu', 3, 'Khada hone ka tarika thoda casual hai aap khada hona sikhiye pehle baki sab theek hai sab chal raha hai', 'source/Profile/anmol.png', '2023-10-27');

-- --------------------------------------------------------

--
-- Table structure for table `notify_email`
--

CREATE TABLE `notify_email` (
  `email_id` int(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers_cards`
--

CREATE TABLE `offers_cards` (
  `id` int(255) NOT NULL,
  `card_image` varchar(255) NOT NULL,
  `offer_day` varchar(255) NOT NULL,
  `offer_price` int(100) NOT NULL,
  `original_price` int(100) NOT NULL,
  `date` varchar(255) NOT NULL,
  `details_link` varchar(255) NOT NULL,
  `offer_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers_cards`
--

INSERT INTO `offers_cards` (`id`, `card_image`, `offer_day`, `offer_price`, `original_price`, `date`, `details_link`, `offer_name`) VALUES
(1, 'source\\offers\\bestoffer.jpg', 'Special Offer\r\n', 60, 120, '', '', 'Extreme'),
(2, 'source\\offers\\specialoffer.jpg', 'Special Offer', 40, 100, '', '', 'Normal');

-- --------------------------------------------------------

--
-- Table structure for table `payment-details`
--

CREATE TABLE `payment-details` (
  `id` int(11) NOT NULL,
  `fullname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `txt_id` varchar(50) NOT NULL,
  `txt_type` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `txt_status` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `delivery_pan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment-details`
--

INSERT INTO `payment-details` (`id`, `fullname`, `email`, `date`, `txt_id`, `txt_type`, `phone`, `txt_status`, `user_id`, `paid_amount`, `delivery_pan`) VALUES
(45, 'Vaghela rishi', 'ramok26145@dabeixin.com', '2023-11-21', 'TXS7117690726MYPI', 'UPI', '7990541146', 'Paid', 28, 60, 'extreme'),
(46, 'anmol tiwari', 'ayushsolanki2901@gmail.com', '2023-11-21', 'TXS3924053100MYPI', 'UPI', '9723054735', 'Paid', 28, 60, 'extreme'),
(47, 'ayush solanki', 'ramok26145@dabeixin.com', '2023-11-22', 'TXS9574128137MYPI', 'UPI', '9723054735', 'Paid', 28, 40, 'normal');

-- --------------------------------------------------------

--
-- Table structure for table `poetry_cards`
--

CREATE TABLE `poetry_cards` (
  `id` int(11) NOT NULL,
  `poetry` varchar(255) NOT NULL,
  `data_filters` varchar(50) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `author` varchar(50) NOT NULL DEFAULT 'Chahat K arya'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poetry_cards`
--

INSERT INTO `poetry_cards` (`id`, `poetry`, `data_filters`, `date`, `author`) VALUES
(1, 'Friendship Lorem ipsum dolor sit amet consectetur ', 'Friendship Day', '2023-10-30', 'Chahat K arya'),
(2, 'Perents Lorem ipsum dolor sit amet consectetur adi', 'Marriage', '2023-10-30', 'Chahat K arya'),
(3, 'Proposal For Crush Lorem ipsum dolor sit amet cons', 'Proposal For Crush', '2023-10-30', 'Chahat K arya'),
(4, 'Mothers Day Lorem ipsum dolor sit amet consectetur adipisicing', 'Mothers Day', '2023-10-30', 'Chahat K arya'),
(5, 'Fathers Day Lorem ipsum dolor sit amet consectetur adipisicing', 'Fathers Day', '2023-10-30', 'Chahat K arya'),
(6, 'Baby Shower Lorem ipsum dolor sit amet consectetur adipisicing', 'Baby Shower', '2023-10-30', 'Chahat K arya');

-- --------------------------------------------------------

--
-- Table structure for table `poetry_category`
--

CREATE TABLE `poetry_category` (
  `id` int(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `data_filters` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poetry_category`
--

INSERT INTO `poetry_category` (`id`, `category`, `data_filters`) VALUES
(1, 'All', '*'),
(2, 'Friendship', 'Friendship'),
(3, 'Perents ', 'perents '),
(4, 'Love', 'love'),
(5, 'Marreige', 'marreige'),
(23, 'sad', 'sad');

-- --------------------------------------------------------

--
-- Table structure for table `poetry_delivery`
--

CREATE TABLE `poetry_delivery` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `delevery_type` varchar(255) NOT NULL,
  `person_name` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `relation_status` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `person_img` varchar(255) NOT NULL,
  `txt_id` varchar(200) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poetry_delivery`
--

INSERT INTO `poetry_delivery` (`id`, `user_id`, `delevery_type`, `person_name`, `language`, `relation_status`, `payment_status`, `person_img`, `txt_id`, `date`) VALUES
(64, 28, 'extreme', 'Ayush', 'Hindi', 'Normal Person', 'Paid', '', 'TXS7117690726MYPI', '2023-11-21'),
(65, 28, 'extreme', 'Ayush', 'Hindi', 'Friend Male / Female', 'Paid', '', 'TXS3924053100MYPI', '2023-11-21'),
(66, 28, 'normal', 'Ayush', 'English', 'Love', 'Paid', '', 'TXS9574128137MYPI', '2023-11-22');

-- --------------------------------------------------------

--
-- Table structure for table `rememberme_tokens`
--

CREATE TABLE `rememberme_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rememberme_tokens`
--

INSERT INTO `rememberme_tokens` (`id`, `user_id`, `token`, `expiration`) VALUES
(31, 28, '56203935c401f619877e8f4fd8e24612868d9806ed300516547097bff0740ac3', '2023-12-20 13:52:14');

-- --------------------------------------------------------

--
-- Table structure for table `sended-poetry`
--

CREATE TABLE `sended-poetry` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `poetry` varchar(200) NOT NULL,
  `ordered_plan` varchar(100) NOT NULL,
  `txt_id` varchar(200) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `poetry-file` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sended-poetry`
--

INSERT INTO `sended-poetry` (`id`, `name`, `poetry`, `ordered_plan`, `txt_id`, `date`, `poetry-file`) VALUES
(51, 'Ayush', 'cxvvvvvvvvv', 'extreme', 'TXS3924053100MYPI', '2023-11-22', ''),
(52, 'Ayush', '<!DOCTYPE html>\r\n<html lang=\"en\">\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n    <style>\r\n        body {\r\n            font-family:', 'normal', 'TXS9574128137MYPI', '2023-11-22', '');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(100) NOT NULL,
  `Label` varchar(100) NOT NULL,
  `data-value` varchar(255) NOT NULL,
  `data-value2` varchar(200) NOT NULL,
  `data-value3` varchar(200) NOT NULL,
  `data-value4` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `Label`, `data-value`, `data-value2`, `data-value3`, `data-value4`) VALUES
(1, 'View Count', '1', '', '', ''),
(2, 'Tornament-status', 'Deactivate', '2023-11-21', '2023-11-23', ''),
(3, 'revenue', '0', '', '', ''),
(4, 'tornament-token', '', '', '', ''),
(5, 'login-key', 'KxVqSwUjrS', 'WmdAMtn6cD', '6wsYrnuRDL', '?login=true&encryption1=KxVqSwUjrS&encryption2=WmdAMtn6cD&encryption3=6wsYrnuRDL');

-- --------------------------------------------------------

--
-- Table structure for table `top3_cards`
--

CREATE TABLE `top3_cards` (
  `id` int(255) NOT NULL,
  `poetry` varchar(255) NOT NULL,
  `writter` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `top3_cards`
--

INSERT INTO `top3_cards` (`id`, `poetry`, `writter`, `date`) VALUES
(1, 'All begin in delight and end in wisdom, as Frost taught us great poems should.', 'Chahat K. Arya', '2023-11-20'),
(2, 'This blew my mind in high school, and I wasn’t the only one.', '', '2023-11-20'),
(3, 'Because a rose is a rose is a rose is a rose is a rose is a rose is a rose.', '', '2023-11-20');

-- --------------------------------------------------------

--
-- Table structure for table `tornament`
--

CREATE TABLE `tornament` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `otherstate` varchar(100) NOT NULL,
  `poetry` varchar(2000) NOT NULL,
  `poetryfile` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `tornament-token` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tornament`
--

INSERT INTO `tornament` (`id`, `name`, `email`, `mobile`, `state`, `otherstate`, `poetry`, `poetryfile`, `date`, `tornament-token`) VALUES
(5, 'ayush', 'admin@gmail.com', '7990541146', 'gujarat', '', 'daaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaa', ' ', '2023-11-21', ''),
(6, 'test.php', 'ramok26145@dabeixin.com', '7990541146', 'other', 'MP', '', ' source/poetryfile/titanfall-2-4k-gaming-upm0ozmh3a7m8i4s.jpg', '2023-11-21', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `useremail` varchar(255) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `registerdate` varchar(10) NOT NULL,
  `logintype` varchar(255) NOT NULL,
  `userprofile` varchar(255) NOT NULL DEFAULT 'source/profile/defult.jpg',
  `code` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `Feedback` varchar(11) NOT NULL DEFAULT 'False'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `useremail`, `userpassword`, `registerdate`, `logintype`, `userprofile`, `code`, `status`, `Feedback`) VALUES
(20, 'ayush', 'vohom24949@alvisani.com', '$2y$10$FzBTDOA6f0kpeY0tyLqm1ObLGveRy7eVTBPjOc5aZnP7U6vmIgOZG', '2023-09-21', 'Email', 'source/profile/defult.jpg', '', 'active', 'False'),
(27, 'Ayush Solanki', 'ayushsolanki2901@gmail.com', '413299902ad3cd49b3c29453d127fe22', '2023-10-02', 'Google', 'https://lh3.googleusercontent.com/a/ACg8ocJ0Pxag15T5_k3-wOmtw6TbLC9UjLM623LyEiDupygAmw=s96-c', '833fba3f7bb3ad99e2602d62c2591f24', 'active', 'False'),
(28, 'hahha', 'ayushsolanki2901@gmail.com', '$2y$10$rO4jpT9TDe/ECgpqUHRGFePQY33vMeLHPA8zy2x0JEWfhqFEPixrC', '2023-11-20', 'email', 'source/profile/defult.jpg', '85fc8712689b847041395b1164c3eae7', 'active', 'False');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_card`
--
ALTER TABLE `category_card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notify_email`
--
ALTER TABLE `notify_email`
  ADD PRIMARY KEY (`email_id`);

--
-- Indexes for table `offers_cards`
--
ALTER TABLE `offers_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment-details`
--
ALTER TABLE `payment-details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poetry_cards`
--
ALTER TABLE `poetry_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poetry_category`
--
ALTER TABLE `poetry_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poetry_delivery`
--
ALTER TABLE `poetry_delivery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rememberme_tokens`
--
ALTER TABLE `rememberme_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sended-poetry`
--
ALTER TABLE `sended-poetry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `top3_cards`
--
ALTER TABLE `top3_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tornament`
--
ALTER TABLE `tornament`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_card`
--
ALTER TABLE `category_card`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `notify_email`
--
ALTER TABLE `notify_email`
  MODIFY `email_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `offers_cards`
--
ALTER TABLE `offers_cards`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment-details`
--
ALTER TABLE `payment-details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `poetry_cards`
--
ALTER TABLE `poetry_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `poetry_category`
--
ALTER TABLE `poetry_category`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `poetry_delivery`
--
ALTER TABLE `poetry_delivery`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `rememberme_tokens`
--
ALTER TABLE `rememberme_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `sended-poetry`
--
ALTER TABLE `sended-poetry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `top3_cards`
--
ALTER TABLE `top3_cards`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tornament`
--
ALTER TABLE `tornament`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
