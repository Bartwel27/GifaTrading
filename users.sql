-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 13, 2024 at 07:24 PM
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
-- Database: `gifa_trading`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL,
  `currency` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
); 
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `currency`) VALUES
(1, 'Hassan Banda', 'hb1@gmail.com', 'e10adc3949ba59abbe56e057f', ''),
(2, 'Ramona Chaks', 'rchaks@gmail.com', '513689a21ca93615f43feec52', ''),
(6, 'Beauty Banda', 'bb@gmail.com', 'eaaf0bb3531808179a7670df9', ''),
(7, 'kasongokasanga', 'kk@gmail.com', '04781da55351748e6e15a256d', ''),
(8, 'mercy mutambo', 'mm@gmail.com', '8ddcff3a80f4189ca1c9d4d90', ''),
(9, 'jane bwalya', 'jenebwalya@gmail.com', '827ccb0eea8a706c4c34a1689', ''),
(10, 'james', 'jamesb@gmail.com', '202cb962ac59075b964b07152', ''),
(11, 'bwalya mumba', 'bm@gmail.com', 'b59c67bf196a4758191e42f76', ''),
(12, 'kennedy mwewa', 'km@gmail.com', '202cb962ac59075b964b07152', '');
COMMIT;

create table users (
  id int(11) not null primary key auto_increment,
  varchar username(25) not null,
  varchar email(25) not null,
  varchar password(25) not null,
  varchar currency(25) not null,  
);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;