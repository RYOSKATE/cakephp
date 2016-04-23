-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016 年 4 朁E23 日 13:56
-- サーバのバージョン： 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `visualizetool`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `graphs`
--

CREATE TABLE IF NOT EXISTS `graphs` (
  `id` int(11) NOT NULL,
  `upload_data_id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `filepath` text NOT NULL,
  `0` text NOT NULL,
  `1` int(11) NOT NULL,
  `2` int(11) NOT NULL,
  `3` int(11) NOT NULL,
  `4` int(11) NOT NULL,
  `5` int(11) NOT NULL,
  `6` int(11) NOT NULL,
  `7` int(11) NOT NULL,
  `8` int(11) NOT NULL,
  `9` int(11) NOT NULL,
  `10` int(11) NOT NULL,
  `11` int(11) NOT NULL,
  `12` int(11) NOT NULL,
  `13` int(11) NOT NULL,
  `14` int(11) NOT NULL,
  `15` int(11) NOT NULL,
  `16` int(11) NOT NULL,
  `17` int(11) NOT NULL,
  `18` int(11) NOT NULL,
  `19` int(11) NOT NULL,
  `20` int(11) NOT NULL,
  `21` int(11) NOT NULL,
  `22` int(11) NOT NULL,
  `23` int(11) NOT NULL,
  `24` int(11) NOT NULL,
  `25` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `group_data`
--

CREATE TABLE IF NOT EXISTS `group_data` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `group_name` text NOT NULL,
  `defact_num` int(11) NOT NULL,
  `file_num` int(11) NOT NULL,
  `loc` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `group_data`
--

INSERT INTO `group_data` (`id`, `model`, `group_name`, `defact_num`, `file_num`, `loc`, `date`) VALUES
(52, 'testA', 'ã‚»ã‚­ãƒ¥ãƒªãƒE??', 0, 6, 11067, '2016-04-23'),
(53, 'testA', 'Miracast', 0, 5, 9110, '2016-04-23'),
(54, 'testA', 'å…ˆé€²ã‚«ãƒ¡ãƒ©', 0, 11, 23104, '2016-04-23'),
(55, 'testA', 'FeliCa/NFCã‚¢ãƒ—ãƒª', 0, 2, 309, '2016-04-23'),
(56, 'testA', 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE', 1, 22, 18105, '2016-04-23'),
(57, 'testA', 'QCRIL', 0, 2, 8614, '2016-04-23'),
(58, 'testA', 'Display', 1, 10, 18895, '2016-04-23'),
(59, 'testA', 'REGZA/Multimedia', 0, 1, 364, '2016-04-23'),
(60, 'testA', 'Connectivity', 0, 3, 13853, '2016-04-23'),
(61, 'testA', 'Audio', 0, 3, 5734, '2016-04-23'),
(62, 'testA', 'BSP', 0, 10, 13004, '2016-04-23'),
(63, 'testA', 'AndroidPF', 0, 4, 5127, '2016-04-23'),
(64, 'testA', 'GPSãƒ‰ãƒ©ã‚¤ãƒE', 0, 1, 2857, '2016-04-23'),
(65, 'testA', 'aDriver', 4, 1, 4518, '2016-04-23'),
(66, 'testA', 'é›»è©±', 0, 1, 332, '2016-04-23'),
(67, 'testA', 'mDriver', 0, 2, 1016, '2016-04-23'),
(68, 'testA', 'å…E??ãƒ‰ãƒ©ã‚¤ãƒE', 0, 1, 163, '2016-04-23');

-- --------------------------------------------------------

--
-- テーブルの構造 `group_names`
--

CREATE TABLE IF NOT EXISTS `group_names` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `group_names`
--

INSERT INTO `group_names` (`id`, `name`) VALUES
(1, 'Audio'),
(2, 'BSP'),
(3, 'Connectivity'),
(4, 'Display'),
(5, 'FeliCa/NFCã‚¢ãƒ—ãƒª'),
(6, 'GPSãƒ‰ãƒ©ã‚¤ãƒE'),
(7, 'Miracast'),
(8, 'QCRIL'),
(9, 'REGZA/Multimedia'),
(10, 'aDriver'),
(11, 'mDriver'),
(12, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(13, 'ã‚»ã‚­ãƒ¥ãƒªãƒE??'),
(14, 'å…E??ãƒ‰ãƒ©ã‚¤ãƒE'),
(15, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(16, 'é›»è©±');

-- --------------------------------------------------------

--
-- テーブルの構造 `model_names`
--

CREATE TABLE IF NOT EXISTS `model_names` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `model_names`
--

INSERT INTO `model_names` (`id`, `name`) VALUES
(1, 'testA');

-- --------------------------------------------------------

--
-- テーブルの構造 `stickies`
--

CREATE TABLE IF NOT EXISTS `stickies` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `page` varchar(32) CHARACTER SET utf8 NOT NULL,
  `color` varchar(7) CHARACTER SET utf8 NOT NULL,
  `time` datetime NOT NULL,
  `left` int(11) NOT NULL,
  `top` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `upload_data`
--

CREATE TABLE IF NOT EXISTS `upload_data` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `modelname_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` tinytext CHARACTER SET utf8 NOT NULL,
  `password` tinytext CHARACTER SET utf8 NOT NULL,
  `role` tinytext CHARACTER SET utf8 NOT NULL,
  `group` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `group`) VALUES
(1, 'root', '918f4ef9e35af3bf2ff5d99310ba2f98bcda2a20', 'admin', 'ALL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `graphs`
--
ALTER TABLE `graphs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_names`
--
ALTER TABLE `group_names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_names`
--
ALTER TABLE `model_names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stickies`
--
ALTER TABLE `stickies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload_data`
--
ALTER TABLE `upload_data`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `date` (`date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `graphs`
--
ALTER TABLE `graphs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=253;
--
-- AUTO_INCREMENT for table `group_names`
--
ALTER TABLE `group_names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `model_names`
--
ALTER TABLE `model_names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stickies`
--
ALTER TABLE `stickies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `upload_data`
--
ALTER TABLE `upload_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
