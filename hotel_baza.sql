-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2022 at 11:43 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `sobe`
--

CREATE TABLE `sobe` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `tip_sobe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sobe`
--

INSERT INTO `sobe` (`id`, `naziv`, `tip_sobe_id`) VALUES
(1, 'soba 1', 16),
(2, 'soba 1', 17),
(3, 'soba 2', 17),
(4, 'soba 3', 17),
(5, 'soba 4', 17),
(6, 'soba 5', 17),
(7, 'soba 1', 18),
(8, 'soba 2', 18),
(9, 'soba 3', 18),
(10, 'soba 1', 19),
(11, 'soba 1', 20);

-- --------------------------------------------------------

--
-- Table structure for table `tip_sobe`
--

CREATE TABLE `tip_sobe` (
  `id` int(11) NOT NULL,
  `naziv` varchar(200) NOT NULL,
  `skraceni_naziv` varchar(4) NOT NULL,
  `opis` varchar(200) NOT NULL,
  `cena` decimal(10,0) NOT NULL,
  `broj_soba` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tip_sobe`
--

INSERT INTO `tip_sobe` (`id`, `naziv`, `skraceni_naziv`, `opis`, `cena`, `broj_soba`) VALUES
(16, 'Gostinjska soba', 'GK', 'Soba za goste', '1', 1),
(17, 'Jednokrevetna soba', 'JK', 'Soba sa jednim krevetom', '20', 5),
(18, 'Dvokrevetna soba', 'DK', 'Soba sa dva kreveta', '40', 3),
(19, 'Trokrevetna soba', 'TK', 'Soba sa tri kreveta', '60', 1),
(20, 'Kraljevski apartman', 'KA', 'Francuski lezaj i terasa', '90', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sobe`
--
ALTER TABLE `sobe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tip_sobe_id` (`tip_sobe_id`);

--
-- Indexes for table `tip_sobe`
--
ALTER TABLE `tip_sobe`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sobe`
--
ALTER TABLE `sobe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tip_sobe`
--
ALTER TABLE `tip_sobe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sobe`
--
ALTER TABLE `sobe`
  ADD CONSTRAINT `sobe_ibfk_1` FOREIGN KEY (`tip_sobe_id`) REFERENCES `tip_sobe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
