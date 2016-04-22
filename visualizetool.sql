-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016 年 4 朁E23 日 01:54
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
-- テーブルの構造 `csvs`
--

CREATE TABLE IF NOT EXISTS `csvs` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `model_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `csv_id` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `graphs`
--

CREATE TABLE IF NOT EXISTS `graphs` (
  `file_path` text NOT NULL,
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
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
  `25` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- テーブルの構造 `group_names`
--

CREATE TABLE IF NOT EXISTS `group_names` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `model_names`
--

CREATE TABLE IF NOT EXISTS `model_names` (
  `name` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indexes for table `csvs`
--
ALTER TABLE `csvs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stickies`
--
ALTER TABLE `stickies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `csvs`
--
ALTER TABLE `csvs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stickies`
--
ALTER TABLE `stickies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
