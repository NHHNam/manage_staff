-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-server
-- Generation Time: Apr 05, 2022 at 08:23 AM
-- Server version: 8.0.1-dmr
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlynhanvien`
--
CREATE DATABASE IF NOT EXISTS `quanlynhanvien` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `quanlynhanvien`;

-- --------------------------------------------------------

--
-- Table structure for table `curFiles`
--

CREATE TABLE `curFiles` (
  `id` int(11) NOT NULL,
  `maTask` varchar(100) NOT NULL,
  `files` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `curFiles`
--

INSERT INTO `curFiles` (`id`, `maTask`, `files`) VALUES
(126, 'KT1', 'uploads/myImage.jpg'),
(127, 'KT1', 'uploads/natural.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `phongban`
--

CREATE TABLE `phongban` (
  `id` int(11) NOT NULL,
  `namePB` varchar(50) NOT NULL,
  `destination` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `phongban`
--

INSERT INTO `phongban` (`id`, `namePB`, `destination`) VALUES
(1, 'Kế Toán', 'C103'),
(2, 'Phát Triển', 'A101');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `reason` varchar(1000) NOT NULL,
  `fromDay` date NOT NULL,
  `toDay` date NOT NULL,
  `songay` int(11) NOT NULL,
  `PB` varchar(50) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `name`, `reason`, `fromDay`, `toDay`, `songay`, `PB`, `status`) VALUES
(1, 'Thuỳ Linh', 'I want to traveling to Dalat after working hard.', '2022-04-05', '2022-04-07', 3, 'Phát Triển', 'Waiting'),
(2, 'Nguyễn Hưng Hoài Nam', 'I want to relax', '2022-04-05', '2022-04-06', 2, 'Kế Toán', 'Waiting');

-- --------------------------------------------------------

--
-- Table structure for table `submitTask`
--

CREATE TABLE `submitTask` (
  `id` int(11) NOT NULL,
  `maTask` varchar(50) NOT NULL,
  `arrayFile` varchar(300) NOT NULL,
  `dateTime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `submitTask`
--

INSERT INTO `submitTask` (`id`, `maTask`, `arrayFile`, `dateTime`) VALUES
(1, 'KT1', '2.1.3.7 Lab - Basic Python Programming - ILM.docx, 8e78a3fccf1e0040590f.jpg, ', '2022-04-03 07:42:46pm'),
(2, 'KT1', '2.1.3.7 Lab - Basic Python Programming - ILM.docx, 8e78a3fccf1e0040590f.jpg, 51900763_Task2.2.docx, ', '2022-04-03 07:46:44pm'),
(3, 'KT1', '51900763_Task2.2.docx, ', '2022-04-03 07:47:26pm'),
(5, 'KT1', '', '2022-04-03 09:24:57pm'),
(6, 'KT1', 'myImage.jpg, natural.jpeg, ', '2022-04-03 09:26:30pm'),
(7, 'KT1', 'myImage.jpg, natural.jpeg, ip12.webp, ip13.jpeg, mac16m1.jpeg, mam1.jpeg, ', '2022-04-03 09:27:04pm'),
(8, 'KT1', 'myImage.jpg, natural.jpeg, ', '2022-04-03 09:28:53pm'),
(9, 'KT1', 'myImage.jpg, natural.jpeg, ', '2022-04-03 09:31:35pm'),
(10, 'KT1', 'myImage.jpg, natural.jpeg, ', '2022-04-03 09:33:05pm');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `maTask` varchar(100) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `receiver` varchar(100) NOT NULL,
  `nameTask` varchar(100) NOT NULL,
  `descTask` varchar(4000) NOT NULL,
  `deadline` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `maTask`, `sender`, `receiver`, `nameTask`, `descTask`, `deadline`, `status`) VALUES
(1, 'KT1', 'admin', 'ktNam', 'What is Lorem Ipsum?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2022-03-31', 'Waiting'),
(2, 'KT2', 'admin', 'ktNam', 'What is Lorem Ipsum?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2022-03-31', 'In Progress');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `pwd` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `birth` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phonenumber` varchar(100) NOT NULL,
  `chucvu` varchar(100) NOT NULL,
  `phongban` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `duocnghi` int(11) NOT NULL,
  `tongngaynghi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `pwd`, `firstName`, `lastName`, `birth`, `email`, `address`, `phonenumber`, `chucvu`, `phongban`, `image`, `duocnghi`, `tongngaynghi`) VALUES
(1, 'ktNam', '$2y$10$T9FwFtuKnqIH3d0zma2eDepq/gXn24azE3/yfh44cOye/wcemGTtO', 'Nguyễn Hưng', 'Hoài Nam', '2001-04-30', 'nguyenhunghoainam@gmail.com', '741/31 hương lộ, BTD A, Q. Bình Tân, HCM', '0773762943', 'nhân viên', 'Kế Toán', 'images/natural.jpeg', 15, 0),
(2, 'admin', '$2y$10$7yJwmIHMVtb71Qo/9y02Vek7KbgTmv4uOY6MVKdhzik1AyH1tx8ui', 'Giám', 'Đốc', '1994-03-30', 'giamdoc@gmail.com', 'secret', '0132456789', 'admin', 'admin', 'images/admin.jpg', 0, 0),
(3, 'ktngoctran', '$2y$10$Jkjr9zcaJciOKDxYxSpOl.r4A9Mkd.PToha44fqm4RNka8SoG7YBW', 'Lê', 'Ngọc Trân', '2001-01-28', 'lengoctran@gmail.com', '98 Lê Đình Cẩn, Bình Tân, TP.HCM', '0123456789', 'nhân viên', 'Kế Toán', 'images/830ee79eae81efe027418e3ee6b0112b.JPG', 15, 0),
(4, 'ptLinh', '$2y$10$Y9nBPbZE80dKARA8KJugmu0Kq8NI1WGI1Oj5XjJa3QcbFqXXp0DNW', 'Thuỳ', 'Linh', '2001-07-25', 'ptLinh@gmail.com', '12 Nguyễn Đình Trọng', '07159456789', 'nhân viên', 'Phát Triển', 'images/d1ea735a9e433d4fe0878c83c07e60cd.JPG', 15, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `curFiles`
--
ALTER TABLE `curFiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phongban`
--
ALTER TABLE `phongban`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submitTask`
--
ALTER TABLE `submitTask`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `curFiles`
--
ALTER TABLE `curFiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `phongban`
--
ALTER TABLE `phongban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `submitTask`
--
ALTER TABLE `submitTask`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
