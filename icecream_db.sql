-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2024 at 04:41 AM
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
-- Database: `icecream_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` varchar(50) NOT NULL,
  `qty` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `price`, `qty`) VALUES
('73MWjrZSNAmr1do9SbtE', 'TAl1Ck3GFt1Bilg2sS64', '66a662c4e23d0', '140000', '1'),
('HenYFJcbkKo5aAExdqpL', 'TAl1Ck3GFt1Bilg2sS64', '66a5c31f1d8f8', '40000', '1'),
('X900ancWt4FLycKiRDLe', 'TAl1Ck3GFt1Bilg2sS64', '66cff2e35c460', '35000', '1'),
('dpoTaiekTe8ZdNTT93fd', 'TAl1Ck3GFt1Bilg2sS64', '66cff36636ecc', '39000', '1'),
('DXZIpCllGKzW1TdHseHP', 'TAl1Ck3GFt1Bilg2sS64', '66cff07012836', '200000', '1'),
('7zyUA65fGFo1GrWmw44M', 'gdXptI9dajOkgw79idnt', '66cfed8429a8b', '20000', '1'),
('I9qTq5Qu9A0Mf6l6do5M', 'gdXptI9dajOkgw79idnt', '66a5c31f1d8f8', '40000', '1'),
('Fl4NP3BaTOyBMn57ZLKu', 'dHCu3y5R9PKhUikXfGyN', '66a5c31f1d8f8', '40000', '1'),
('8NwoI2ewD8PShnR28yKY', 'dHCu3y5R9PKhUikXfGyN', '66cff2e35c460', '35000', '1');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `subject`, `message`) VALUES
('66d012c3bd720', 'TAl1Ck3GFt1Bilg2sS64', 'khai', 'nqkhai369@gmail.com', 'Sản Phẩm', 'Sản phẩm của bạn rất tuyệt'),
('66dfb9beb5921', 'gdXptI9dajOkgw79idnt', 'a', 'a@gmail.com', 'a', 'a'),
('66dfc985ea944', 'gdXptI9dajOkgw79idnt', 'a', 'a@gmail.com', 'Sản Phẩm', 'Rất ngon');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `seller_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `address_type` varchar(10) NOT NULL,
  `method` varchar(50) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` int(10) NOT NULL,
  `qty` int(2) NOT NULL,
  `date` date DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'in progress',
  `payment_status` varchar(100) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `seller_id`, `name`, `number`, `email`, `address`, `address_type`, `method`, `product_id`, `price`, `qty`, `date`, `status`, `payment_status`) VALUES
('KoiAstakbSuWwpxfqVnX', 'TAl1Ck3GFt1Bilg2sS64', 'vHzPzEr2CoB3GLU4fZIK', 'john doe', '6677889900', 'johndoe@gmail.com', '504, tkd, delhi, india, 110019', 'office', 'net banking', 'irTt2KT6TxF8fpdxYbtk', 50, 1, '2023-08-12', 'canceled', 'pending'),
('Xg31gq3b84muqgUOjj1U', 'TAl1Ck3GFt1Bilg2sS64', 'vHzPzEr2CoB3GLU4fZIK', 'john doe', '6677889900', 'johndoe@gmail.com', '504, tkd, delhi, india, 110019', 'home', 'paytm', 'K5XFwTZGTV0p7emZgfm5', 25, 1, '2023-08-12', 'in progress', 'pending'),
('66cfe5f9514db', 'TAl1Ck3GFt1Bilg2sS64', 'AR7ktiueFqxTtsnzVuY1', 'khai', '0379209120', 'nqkhai369@gmail.com', '1, a, gcv, Vietnam, 111111', 'home', 'cash on delivery', 'JPrztZw0rmxzfr89iGpg', 20, 2, '2024-08-29', 'in progress', 'pending'),
('66cfe5f952113', 'TAl1Ck3GFt1Bilg2sS64', 'vHzPzEr2CoB3GLU4fZIK', 'khai', '0379209120', 'nqkhai369@gmail.com', '1, a, gcv, Vietnam, 111111', 'home', 'cash on delivery', 'cEtreNTJhgvHekQ5qJMB', 35, 2, '2024-08-29', 'in progress', 'order_delivered'),
('66cfe5f95300a', 'TAl1Ck3GFt1Bilg2sS64', 'vHzPzEr2CoB3GLU4fZIK', 'khai', '0379209120', 'nqkhai369@gmail.com', '1, a, gcv, Vietnam, 111111', 'home', 'cash on delivery', 'N8AIGKbxKD9uvt495fzy', 65, 1, '2024-08-29', 'in progress', 'pending'),
('66cfe5f953395', 'TAl1Ck3GFt1Bilg2sS64', 'vHzPzEr2CoB3GLU4fZIK', 'khai', '0379209120', 'nqkhai369@gmail.com', '1, a, gcv, Vietnam, 111111', 'home', 'cash on delivery', 'jkkP1VxIl7LkGtbyxrwN', 89, 1, '2024-08-29', 'in progress', ''),
('66cfe5f953a03', 'TAl1Ck3GFt1Bilg2sS64', 'vHzPzEr2CoB3GLU4fZIK', 'khai', '0379209120', 'nqkhai369@gmail.com', '1, a, gcv, Vietnam, 111111', 'home', 'cash on delivery', 'irTt2KT6TxF8fpdxYbtk', 50, 1, '2024-08-29', 'in progress', 'pending'),
('66cfe5f9549f3', 'TAl1Ck3GFt1Bilg2sS64', 'vHzPzEr2CoB3GLU4fZIK', 'khai', '0379209120', 'nqkhai369@gmail.com', '1, a, gcv, Vietnam, 111111', 'home', 'cash on delivery', 'K5XFwTZGTV0p7emZgfm5', 25, 1, '2024-08-29', 'in progress', 'pending'),
('66cfe5f9553e9', 'TAl1Ck3GFt1Bilg2sS64', 'vHzPzEr2CoB3GLU4fZIK', 'khai', '0379209120', 'nqkhai369@gmail.com', '1, a, gcv, Vietnam, 111111', 'home', 'cash on delivery', 'EDZevI323yLSZa9gok98', 100, 1, '2024-08-29', 'in progress', 'pending'),
('66df8e8a600f0', 'TAl1Ck3GFt1Bilg2sS64', '2rf9HrPdpwDg3ov3zTK3', 'khai', '0346515698', 'nqkhai369@gmail.com', 'mxc bkjcxb mc, a, gcv, Việt Nam, 65652', 'home', 'cash on delivery', '66a5c31f1d8f8', 40000, 1, '2024-09-10', 'in progress', 'Đã giao hàng'),
('66df8e8a602f8', 'TAl1Ck3GFt1Bilg2sS64', '2rf9HrPdpwDg3ov3zTK3', 'khai', '0346515698', 'nqkhai369@gmail.com', 'mxc bkjcxb mc, a, gcv, Việt Nam, 65652', 'home', 'cash on delivery', '66cff2e35c460', 35000, 1, '2024-09-10', 'in progress', 'Đã giao hàng'),
('66df8e8a6062e', 'TAl1Ck3GFt1Bilg2sS64', '2rf9HrPdpwDg3ov3zTK3', 'khai', '0346515698', 'nqkhai369@gmail.com', 'mxc bkjcxb mc, a, gcv, Việt Nam, 65652', 'home', 'cash on delivery', '66cff36636ecc', 39000, 1, '2024-09-10', 'in progress', 'Chờ xử lý'),
('66dfbfa34e1aa', 'gdXptI9dajOkgw79idnt', '2rf9HrPdpwDg3ov3zTK3', 'a', '1651650', 'a@gmail.com', 'a, a, Hồ Ch&iacute; Minh, Việt Nam, 1235', 'home', 'cash on delivery', '66a5c31f1d8f8', 40000, 2, '2024-09-10', 'in progress', 'pending'),
('66dfbfa34e46c', 'gdXptI9dajOkgw79idnt', 'rB0EkEYuq91OSof9znp8', 'a', '1651650', 'a@gmail.com', 'a, a, Hồ Ch&iacute; Minh, Việt Nam, 1235', 'home', 'cash on delivery', '66a662c4e23d0', 140000, 2, '2024-09-10', 'Đã hủy', 'Đã giao hàng'),
('66dfe6957c7a5', 'dHCu3y5R9PKhUikXfGyN', 'rB0EkEYuq91OSof9znp8', 'Qu&acirc;n', '0368965327', '2251120239@ut.edu.vn', 'Lan m&aacute;c, 12, HCM, VN, 123', 'home', 'cash on delivery', '66a662c4e23d0', 140000, 1, '2024-09-10', 'Đã hủy', 'pending'),
('66dfe6957e13e', 'dHCu3y5R9PKhUikXfGyN', '2rf9HrPdpwDg3ov3zTK3', 'Qu&acirc;n', '0368965327', '2251120239@ut.edu.vn', 'Lan m&aacute;c, 12, HCM, VN, 123', 'home', 'cash on delivery', '66cfed8429a8b', 20000, 3, '2024-09-10', 'Đã hủy', 'pending'),
('66dfe6957eace', 'dHCu3y5R9PKhUikXfGyN', 'vHzPzEr2CoB3GLU4fZIK', 'Qu&acirc;n', '0368965327', '2251120239@ut.edu.vn', 'Lan m&aacute;c, 12, HCM, VN, 123', 'home', 'cash on delivery', 'jkkP1VxIl7LkGtbyxrwN', 152000, 1, '2024-09-10', 'Đã hủy', 'pending'),
('66dfe6957f1e1', 'dHCu3y5R9PKhUikXfGyN', '2rf9HrPdpwDg3ov3zTK3', 'Qu&acirc;n', '0368965327', '2251120239@ut.edu.vn', 'Lan m&aacute;c, 12, HCM, VN, 123', 'home', 'cash on delivery', '66cff07012836', 200000, 1, '2024-09-10', 'Đã hủy', 'pending'),
('66dfe6957fb0e', 'dHCu3y5R9PKhUikXfGyN', '2rf9HrPdpwDg3ov3zTK3', 'Qu&acirc;n', '0368965327', '2251120239@ut.edu.vn', 'Lan m&aacute;c, 12, HCM, VN, 123', 'home', 'cash on delivery', '66cff0ee4938e', 200000, 1, '2024-09-10', 'Đã hủy', 'pending'),
('66dfe69580629', 'dHCu3y5R9PKhUikXfGyN', '2rf9HrPdpwDg3ov3zTK3', 'Qu&acirc;n', '0368965327', '2251120239@ut.edu.vn', 'Lan m&aacute;c, 12, HCM, VN, 123', 'home', 'cash on delivery', '66cff18f0ea8f', 42000, 1, '2024-09-10', 'Đã hủy', 'pending'),
('66dff45e1583b', 'dHCu3y5R9PKhUikXfGyN', 'rB0EkEYuq91OSof9znp8', 'jon', '640546', 'jonhdoe@gmail.com', 'a, 12, Hồ Ch&iacute; Minh, Việt Nam, 1265', 'home', 'cash on delivery', '66a662c4e23d0', 140000, 1, '2024-09-10', 'in progress', 'pending'),
('66dff45e16111', 'dHCu3y5R9PKhUikXfGyN', '2rf9HrPdpwDg3ov3zTK3', 'jon', '640546', 'jonhdoe@gmail.com', 'a, 12, Hồ Ch&iacute; Minh, Việt Nam, 1265', 'home', 'cash on delivery', '66cfed8429a8b', 20000, 3, '2024-09-10', 'in progress', 'pending'),
('66dff45e16569', 'dHCu3y5R9PKhUikXfGyN', 'vHzPzEr2CoB3GLU4fZIK', 'jon', '640546', 'jonhdoe@gmail.com', 'a, 12, Hồ Ch&iacute; Minh, Việt Nam, 1265', 'home', 'cash on delivery', 'jkkP1VxIl7LkGtbyxrwN', 152000, 1, '2024-09-10', 'in progress', 'pending'),
('66dff45e168aa', 'dHCu3y5R9PKhUikXfGyN', '2rf9HrPdpwDg3ov3zTK3', 'jon', '640546', 'jonhdoe@gmail.com', 'a, 12, Hồ Ch&iacute; Minh, Việt Nam, 1265', 'home', 'cash on delivery', '66cff07012836', 200000, 1, '2024-09-10', 'in progress', 'pending'),
('66dff45e16e42', 'dHCu3y5R9PKhUikXfGyN', '2rf9HrPdpwDg3ov3zTK3', 'jon', '640546', 'jonhdoe@gmail.com', 'a, 12, Hồ Ch&iacute; Minh, Việt Nam, 1265', 'home', 'cash on delivery', '66cff0ee4938e', 200000, 1, '2024-09-10', 'in progress', 'pending'),
('66dff45e173de', 'dHCu3y5R9PKhUikXfGyN', '2rf9HrPdpwDg3ov3zTK3', 'jon', '640546', 'jonhdoe@gmail.com', 'a, 12, Hồ Ch&iacute; Minh, Việt Nam, 1265', 'home', 'cash on delivery', '66cff18f0ea8f', 42000, 1, '2024-09-10', 'in progress', 'pending'),
('66dff9a52ccf9', 'dHCu3y5R9PKhUikXfGyN', '2rf9HrPdpwDg3ov3zTK3', 'jon', '111', 'jonhdoe@gmail.com', '1, 12, Hồ Ch&iacute; Minh, Việt Nam, 12321312321', 'home', 'cash on delivery', '66a5c31f1d8f8', 40000, 1, '2024-09-10', 'in progress', 'pending'),
('66dff9e9e73e1', 'dHCu3y5R9PKhUikXfGyN', '2rf9HrPdpwDg3ov3zTK3', 'jon', '123123', 'jonhdoe@gmail.com', '1, 12, Hồ Ch&iacute; Minh, Việt Nam, 1265', 'home', 'cash on delivery', '66a5c31f1d8f8', 40000, 1, '2024-09-10', 'in progress', 'pending'),
('66dffb574ee7d', 'dHCu3y5R9PKhUikXfGyN', '2rf9HrPdpwDg3ov3zTK3', 'jon', '1231231231', 'jonhdoe@gmail.com', '1, 12, Hồ Ch&iacute; Minh, Việt Nam, 1265', 'home', 'cash on delivery', '66a5c31f1d8f8', 40000, 1, '2024-09-10', 'in progress', 'pending'),
('66dffb574f3c4', 'dHCu3y5R9PKhUikXfGyN', '2rf9HrPdpwDg3ov3zTK3', 'jon', '1231231231', 'jonhdoe@gmail.com', '1, 12, Hồ Ch&iacute; Minh, Việt Nam, 1265', 'home', 'cash on delivery', '66cff2e35c460', 35000, 1, '2024-09-10', 'in progress', 'pending'),
('66dffbc0314e0', 'dHCu3y5R9PKhUikXfGyN', 'rB0EkEYuq91OSof9znp8', 'jon', '123123', 'jonhdoe@gmail.com', '123, 12, Hồ Ch&iacute; Minh, Việt Nam, 1265', 'home', 'cash on delivery', '66dfeb7ed8bf9', 30000, 1, '2024-09-10', 'in progress', 'pending'),
('66dffc2814397', 'gdXptI9dajOkgw79idnt', '2rf9HrPdpwDg3ov3zTK3', 'duong dep trsai', '123123', 'jonhdoe@gmail.com', '1, 12, Hồ Ch&iacute; Minh, Việt Nam, 1265', 'home', 'cash on delivery', '66cfed8429a8b', 20000, 1, '2024-09-10', 'in progress', 'Đã giao hàng'),
('66dffc28147e0', 'gdXptI9dajOkgw79idnt', '2rf9HrPdpwDg3ov3zTK3', 'duong dep trsai', '123123', 'jonhdoe@gmail.com', '1, 12, Hồ Ch&iacute; Minh, Việt Nam, 1265', 'home', 'cash on delivery', '66a5c31f1d8f8', 40000, 1, '2024-09-10', 'Đã hủy', 'Chờ xử lý');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` varchar(20) NOT NULL,
  `seller_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `stock` int(100) NOT NULL,
  `product_detail` varchar(1000) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `name`, `price`, `image`, `stock`, `product_detail`, `status`) VALUES
('66a662c4e23d0', 'rB0EkEYuq91OSof9znp8', 'Kem Sô-Cô-La Dạng Hộp', 140000, 'boc - Sao chép - Sao chép.webp', 126, 'Kem Sô-Cô-La Dạng Hộp là món tráng miệng lý tưởng cho tín đồ sô-cô-la. Với hương vị đậm đà, kem màu nâu sẫm được làm từ nguyên liệu tươi ngon, mang đến trải nghiệm mát lạnh và sảng khoái.\r\n\r\nKem được trang trí bằng các mảnh sô-cô-la nhỏ, tạo thêm độ giòn và hấp dẫn. Đây là lựa chọn hoàn hảo cho những ngày hè hay các buổi tiệc bên gia đình và bạn bè. Thưởng thức ngay để cảm nhận vị ngon tuyệt vời của Kem Sô-Cô-La Dạng Hộp!', 'Đang bán'),
('jkkP1VxIl7LkGtbyxrwN', 'vHzPzEr2CoB3GLU4fZIK', 'Kem Sô-Cô-La Dạng Hộp', 152000, 'boc - Sao chép.webp', 900, 'Kem Sô-Cô-La Dạng Hộp là một món tráng miệng hấp dẫn và thơm ngon, hoàn hảo cho những ai yêu thích vị ngọt ngào và đậm đà của sô-cô-la. Với lớp kem mịn màng, sản phẩm mang đến trải nghiệm thưởng thức tuyệt vời với mỗi muỗng kem.', 'active'),
('66dfea75cc065', 'rB0EkEYuq91OSof9znp8', 'Kem Sô-cô-la siêu cực', 80000, 'product5.jpg', 33, 'Kem Sô-cô-la siêu cực ăn là thấy ngon tuyệt vời.', 'Đang bán'),
('66dfeb7ed8bf9', 'rB0EkEYuq91OSof9znp8', 'Kem Dâu Vanila', 30000, 'type5.png', 0, 'Ăn khi nào cũng được hai hương vì thân thuộc với trẻ em và cả người lớn', 'Đang bán'),
('66dff41c1ef6a', 'rB0EkEYuq91OSof9znp8', 'Kem Dâu Xoài combo thập cẩm', 55000, 'product14-removebg-preview - Sao chép.png', 99, 'Kem Dâu Xoài combo thập cẩm có vị xoài độc đáo', 'Đang bán');

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `name`, `email`, `password`, `image`) VALUES
('2rf9HrPdpwDg3ov3zTK3', 'selenna ansari', 'selena@gmail.com', '12', '66a6f5c5476bb.jpg'),
('rB0EkEYuq91OSof9znp8', 'john doe', 'johndoe@gmail.com', '1', '6aXbBnzSPwFVN3aLdOXS.jpg'),
('AR7ktiueFqxTtsnzVuY1', 'anabia ahmad', 'anabia786@gmail.com', '1', 'GU7l4mNhblEjxtXHBgzT.jpg'),
('vHzPzEr2CoB3GLU4fZIK', 'Taylor Swift', 'selenaa@gmail.com', '1', '66cff6a4db3ce.jpg'),
('DXq27zYwM77OIRfGQf5H', 'khaia', 'n@gmail.com', '1', 'dA0b72ruvumE9opRseBb.jpg'),
('CkCpeCyYnn7gF1XYqOvH', 'a', 'a@gmail.com', 'a', 'PKinEb0jXCLpbJwug3Tc.png'),
('JrlKOVUsh8otyHUMln27', 'c', 'c@gmail.com', 'c', 'dcX8G37cjkrNuvvdmJIy.jpg'),
('0MFNIxW4BAUeCdiDCpVw', 'b', 'b@gmail.com', '1', 'IcVMol6ygzNEyWllJSSI.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`) VALUES
('TAl1Ck3GFt1Bilg2sS64', 'john doe', 'johndoe@gmail.com', 'a51dda7c7ff50b61eaea0444371f4a6a9301e501', '66cffb472e821.jpg'),
('gdXptI9dajOkgw79idnt', 'jonh kartor', 'jonhkator@gmail.com', '123', '66afb2a5a3139.jpg'),
('dHCu3y5R9PKhUikXfGyN', 'zen smith', 'zensmith@gmail.com', '123123', 'yNP0eBteMbDaA0wATpLJ.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `price`) VALUES
('lMMiu1zB4bHjz48fcsOJ', 'TAl1Ck3GFt1Bilg2sS64', '66cff0ee4938e', 200000),
('Kc53SyN5dOroLLI1fV1s', 'TAl1Ck3GFt1Bilg2sS64', '66cff07012836', 200000),
('JI5xteclFygRLbiN9jZ4', 'TAl1Ck3GFt1Bilg2sS64', '66cfed8429a8b', 20000),
('idO5IGTcDJNPWdi9SoIo', 'TAl1Ck3GFt1Bilg2sS64', '66cff18f0ea8f', 42000),
('YZIMP2FL8biFruErAC7A', 'gdXptI9dajOkgw79idnt', '66cff2794ba7e', 50000),
('5jbWOZRtoADnfJ6loXe7', 'gdXptI9dajOkgw79idnt', '66a5c31f1d8f8', 40000),
('4PuH8GDMM5WkwIGUb5d4', 'dHCu3y5R9PKhUikXfGyN', '66a662c4e23d0', 140000),
('KeCQmmzf78YHtPmWqSBl', 'dHCu3y5R9PKhUikXfGyN', '66cff2794ba7e', 50000),
('O6onzhP0vLLAKBkZfUmh', 'dHCu3y5R9PKhUikXfGyN', '66cff2e35c460', 35000),
('HMisCOgBKP04Z6HQUNo9', 'dHCu3y5R9PKhUikXfGyN', '66cff36636ecc', 39000);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
