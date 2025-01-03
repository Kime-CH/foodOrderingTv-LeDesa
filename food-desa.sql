-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2025 at 07:49 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food-desa`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(1, 'admin', 'a0ea41d85b92d0b8460022dea16fd4880538f733'),
(4, 'abiyyu', 'a0ea41d85b92d0b8460022dea16fd4880538f733'),
(5, 'sasha', '6c891a44cdd90f02a2f032166d231cf1bdcf59be');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `status` varchar(20) NOT NULL DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `status`) VALUES
(20, 8, 'Joglo Desa', '', 'joglodesa@ledesa.com', 'cash on delivery', 'Joglo Desa', 'Cumi Penyet (35000 x 2) - Udang Penyet (40000 x 1) - ', 110000, '2025-01-03', 'pending', 'new'),
(21, 8, 'Joglo Desa', '', 'joglodesa@ledesa.com', 'cash on delivery', 'Joglo Desa', 'Bebek Penyet (40000 x 1) - Cumi Penyet (35000 x 1) - ', 75000, '2025-01-03', 'pending', 'new');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `image`) VALUES
(12, 'Bebek Penyet', 'makanan', 40000, 'bebekPenyet.jpg'),
(13, 'Cumi Penyet', 'makanan', 35000, 'cumiPenyet.jpg'),
(14, 'Udang Penyet', 'makanan', 40000, 'udangPenyet.jpg'),
(15, 'Lele Penyet', 'makanan', 32000, 'lelePenyet.jpg'),
(16, 'Nila Penyet', 'makanan', 35000, 'nilaPenyet.jpg'),
(17, 'Lele Mangut', 'makanan', 32000, 'leleMangut.jpg'),
(18, 'Ati Ampela Penyet', 'makanan', 30000, 'atiPenyet.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `address`) VALUES
(5, 'Cottage 1', 'cottage1@ledesa.com', 'a0ea41d85b92d0b8460022dea16fd4880538f733', 'Cottage 1'),
(6, 'Cottage 2', 'cottage2@ledesa.com', 'a0ea41d85b92d0b8460022dea16fd4880538f733', 'Cottage 2'),
(7, 'Cottage 3', 'cottage3@ledesa.com', 'a0ea41d85b92d0b8460022dea16fd4880538f733', ''),
(8, 'Joglo Desa', 'joglodesa@ledesa.com', 'a0ea41d85b92d0b8460022dea16fd4880538f733', 'Joglo Desa'),
(9, 'Joglo Lasmi', 'joglolasmi@ledesa.com', 'a0ea41d85b92d0b8460022dea16fd4880538f733', ''),
(10, 'Joglo Wayang 6', 'joglowayang6@ledesa.com', 'a0ea41d85b92d0b8460022dea16fd4880538f733', ''),
(11, 'Joglo Wayang 7', 'joglowayang7@ledesa.com', 'a0ea41d85b92d0b8460022dea16fd4880538f733', ''),
(12, 'Villa', 'villa@ledesa.com', 'a0ea41d85b92d0b8460022dea16fd4880538f733', ''),
(13, 'Flatroom 5', 'flatroom5@ledesa.com', 'a0ea41d85b92d0b8460022dea16fd4880538f733', ''),
(14, 'Flatroom 6', 'flatroom6@ledesa.com', 'a0ea41d85b92d0b8460022dea16fd4880538f733', ''),
(15, 'Flatroom 7', 'flatroom7@ledesa.com', 'a0ea41d85b92d0b8460022dea16fd4880538f733', ''),
(16, 'Flatroom 8', 'flatroom8@ledesa.com', 'a0ea41d85b92d0b8460022dea16fd4880538f733', ''),
(17, 'Cabin', 'cabin@ledesa.com', 'a0ea41d85b92d0b8460022dea16fd4880538f733', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
