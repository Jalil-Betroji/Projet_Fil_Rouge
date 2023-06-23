-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2023 at 10:19 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chattara`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `Image_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `Image_Path` varchar(500) NOT NULL,
  `Image_Type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`Image_ID`, `Product_ID`, `Image_Path`, `Image_Type`) VALUES
(3, 2, 'disk.png', 'primary'),
(4, 2, 'disk.png', 'secondary'),
(7, 4, 'roller.png', 'primary'),
(8, 4, 'roller.png', 'secondary'),
(9, 5, 'moto.png', 'primary'),
(10, 5, 'piston.png', 'secondary'),
(11, 6, 'bujet.png', 'primary'),
(12, 6, 'bujet.png', 'secondary'),
(13, 7, 'disk4.jpeg', 'primary'),
(14, 7, 'disk4.jpeg', 'secondary'),
(15, 8, 'disk3.png', 'primary'),
(16, 8, 'disk3.png', 'secondary'),
(19, 10, 'disk.png', 'primary'),
(20, 10, 'disk.png', 'secondary'),
(44, 22, 'disk1.png', 'primary'),
(45, 22, 'disk3.png', 'secondary'),
(46, 22, 'disk4.jpeg', 'tertiary'),
(47, 22, 'fc127ab7-image-5.jpg', 'quaternary'),
(68, 1, 'disk1.png', 'primary'),
(69, 1, 'disk3.png', 'secondary'),
(70, 1, 'disk4.jpeg', 'tertiary'),
(71, 1, 'fc127ab7-image-5.jpg', 'quaternary');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `Order_ID` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Full_Name` varchar(60) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `Order_Date` date NOT NULL DEFAULT current_timestamp(),
  `Order_Updated_Date` date NOT NULL DEFAULT current_timestamp(),
  `Phone_Number` int(11) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Order_Status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Order_ID`, `Email`, `Full_Name`, `Product_ID`, `Order_Date`, `Order_Updated_Date`, `Phone_Number`, `City`, `Order_Status`) VALUES
(21, 'betroji.jalil.solicode@gmail.com', 'jalil betroji', 2, '2023-06-10', '2023-06-17', 1234233, 'Tangier', 'Livred'),
(22, 'betroji.jalil.solicode@gmail.com', 'jalil betroji', 2, '2023-06-11', '2023-06-17', 32345434, 'Tangier', 'Pending'),
(23, 'betroji.jalil.solicode@gmail.com', 'jalil betroji', 3, '2023-06-11', '2023-06-17', 2147483647, 'Tangier', 'Pending'),
(24, 'betroji.jalil.solicode@gmail.com', 'jalil betroji', 2, '2023-06-12', '2023-06-17', 2345678, 'Tangier', 'Pending'),
(25, 'betroji.jalil.solicode@gmail.com', 'jalil betroji', 2, '2023-06-17', '2023-06-18', 651782276, 'Tangier', 'Pending'),
(26, 'betroji.jalil.solicode@gmail.com', 'jalil betroji', 4, '2023-06-18', '2023-06-18', 651782276, 'Tangier', 'Pending'),
(27, 'betroji.jalil.solicode@gmail.com', 'jalil betroji', 4, '2023-06-18', '2023-06-18', 651782276, 'Tangier', 'Pending'),
(28, 'betroji.jalil.solicode@gmail.com', 'jalil betroji', 5, '2023-06-18', '2023-06-18', 651782276, 'Tetouan', 'Pending'),
(29, 'betroji.jalil.solicode@gmail.com', 'jalil betroji', 2, '2023-06-18', '2023-06-18', 651782276, 'casablanca', 'Pending'),
(30, 'betroji.jalil.solicode@gmail.com', 'jalil betroji', 6, '2023-06-18', '2023-06-18', 651782276, 'Tangier', 'Pending'),
(31, 'betroji.jalil.solicode@gmail.com', 'jalil betroji', 8, '2023-06-18', '2023-06-18', 651782276, 'casablanca', 'Pending'),
(32, 'betroji.jalil.solicode@gmail.com', 'jalil betroji', 1, '2023-06-20', '2023-06-20', 65715772, 'Tetouan', 'Pending'),
(33, 'betroji.jalil.solicode@gmail.com', 'jalil betroji', 2, '2023-06-20', '2023-06-20', 651782276, 'Tetouan', 'Pending'),
(34, 'betroji.jalil.solicode@gmail.com', 'jalil betroji', 4, '2023-06-20', '2023-06-20', 67155273, 'Chefchaouen', 'Pending'),
(35, 'betroji.jalil.solicode@gmail.com', 'hamza', 1, '2023-06-20', '2023-06-20', 612312211, 'chefchaouen', 'Pending'),
(36, 'betroji.jalil.solicode@gmail.com', 'jalil betroji', 4, '2023-06-20', '2023-06-20', 651782276, 'Chefchaouen', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `Product_ID` int(11) NOT NULL,
  `Email` varchar(80) NOT NULL,
  `Product_Name` varchar(50) NOT NULL,
  `Product_Description` varchar(255) NOT NULL,
  `Product_Serie` varchar(50) NOT NULL,
  `Product_Price` int(11) NOT NULL,
  `Product_Location` varchar(50) NOT NULL,
  `Product_Model` varchar(50) NOT NULL,
  `Product_Added_Date` date NOT NULL,
  `Product_Updated_Date` date NOT NULL DEFAULT current_timestamp(),
  `Product_Status` varchar(30) NOT NULL,
  `Vehicule_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`Product_ID`, `Email`, `Product_Name`, `Product_Description`, `Product_Serie`, `Product_Price`, `Product_Location`, `Product_Model`, `Product_Added_Date`, `Product_Updated_Date`, `Product_Status`, `Vehicule_ID`) VALUES
(1, 'betroji.jalil.solicode@gmail.com', 'Oil filter 1', 'Oil filter for Toyota Camry', 'OF-TOY-CAMRY', 10, 'Tangier', 'Toyota Camry', '2023-05-31', '2023-06-20', 'Active', 1),
(2, 'betroji.jalil.solicode@gmail.com', 'Air Filter Honda', 'Air filter for Honda Civic', 'AF-HON-CIVIC', 15, 'Tangier', 'Honda Civic', '2023-05-31', '2023-05-31', 'Active', 2),
(3, 'betroji.jalil.solicode@gmail.com', 'Brake Pads Ford', 'Brake pads for Ford F-150', 'BP-FOR-F150', 30, 'Tangier', 'Ford F-150', '2023-05-31', '2023-05-31', 'Active', 3),
(4, 'betroji.jalil.solicode@gmail.com', 'Oil filter Cheverolet', 'Oil filter for Chevrolet Silverado', 'OF-CHEV-SILVERADO', 12, 'Tangier', 'Chevrolet Silverado', '2023-05-31', '2023-05-31', 'Sold', 4),
(5, 'betroji.jalil.solicode@gmail.com', 'Air Filter Jeep', 'Air filter for Jeep Wrangler', 'AF-JEE-WRANGLER', 20, 'Tangier', 'Jeep Wrangler', '2023-05-31', '2023-05-31', 'Active', 5),
(6, 'betroji.jalil.solicode@gmail.com', 'Brake Pads Nissan', 'Brake pads for Nissan Altima', 'BP-NIS-ALTIMA', 25, 'Tangier', 'Nissan Altima', '2023-05-31', '2023-05-31', 'Active', 6),
(7, 'betroji.jalil.solicode@gmail.com', 'Oil filter BMW', 'Oil filter for BMW 3 Series', 'OF-BMW-3SERIES', 18, 'Tangier', 'BMW 3 Series', '2023-05-31', '2023-05-31', 'Active', 7),
(8, 'betroji.jalil.solicode@gmail.com', 'Air filter Mercedes-Benz', 'Air filter for Mercedes-Benz E-Class', 'AF-MER-ECLASS', 22, 'Tangier', 'Mercedes-Benz E-Class', '2023-05-31', '2023-05-31', 'Active', 8),
(10, 'betroji.jalil.solicode@gmail.com', 'Oil Filter Volkswagen', 'Oil filter for Volkswagen Jetta', 'OF-VOLK-JETTA', 14, 'Tangier', 'Volkswagen Jetta', '2023-05-31', '2023-05-31', 'Active', 10),
(22, 'betroji.jalil.solicode@gmail.com', 'Brake like new', 'used chevrolet brake still like new in tangier', '1231DFDFE', 123, 'Tangier', '3ZED_1F', '2023-06-16', '2023-06-16', 'Active', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Nickname` varchar(50) NOT NULL,
  `First_Name` varchar(90) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Image_Path` varchar(1000) NOT NULL,
  `Password` varchar(1000) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone` int(11) NOT NULL,
  `CIN` varchar(11) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Account_Type` varchar(30) NOT NULL,
  `Creation_Date` date NOT NULL DEFAULT current_timestamp(),
  `Admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Nickname`, `First_Name`, `Last_Name`, `Image_Path`, `Password`, `Email`, `Phone`, `CIN`, `City`, `Address`, `Account_Type`, `Creation_Date`, `Admin`) VALUES
('Ali_Betroji', 'Ali', 'Betroji', '', '$2y$10$QicD0fQ2Ogj8SInruB6WJOGeBQUUXx9W.PK/n2Dr9.FQ..QIehylK', 'ali.betroji@gmail.com', 651782276, 'GM172537', 'Tangier', 'Tangier ahlan', 'Seller', '2023-06-20', 0),
('amin_lamchatab', 'amin', 'lamchatab', '', '$2y$10$RFG.0rNLQ5fZjMqXhgSOoOlfkn9O.BNVA7I.8ZJZ/liqX1MoYWQp6', 'amin@gmail.com', 65167112, 'GM186412', 'Tangier', 'Tangier ahlan', 'Buyer', '2023-06-13', 0),
('Jalil_Betroji', 'Jalil', 'Betroji', 'etest.jfif', '$2y$10$CY9mPNGqlYz5WFabyzqpZO2tdCmmjaI.aCONkEUF/uOx6RVpfBxHm', 'betroji.jalil.solicode@gmail.com', 651782276, 'GM111333', 'Tangier', 'Tangier ahlan', 'Seller', '2023-06-06', 1),
('hamid_achauo', 'hamid', 'achauo', '', '$2y$10$OdkU57gJopouWcYwJ.ONK.wHakXEOL8as/D.MDz1yaqqU4QcLBxB2', 'hamid@gmail.com', 65167212, 'GM186412', 'Tangier', 'Tangier ahlan', 'Buyer', '2023-06-13', 0),
('imrane_sarsri', 'imrane', 'sarsri', '', '$2y$10$wRUBIfDqeK5GcRtfc2tswOvDB6rK/bFHItC5l76LWevqF7cpCuJBq', 'imran@gmail.com', 65167265, 'GM186456', 'Tangier', 'Tangier ahlan', 'Seller', '2023-06-13', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicules`
--

CREATE TABLE `vehicules` (
  `Vehicule_ID` int(11) NOT NULL,
  `Vehicule_Name` varchar(30) NOT NULL,
  `Vehicule_Serie` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicules`
--

INSERT INTO `vehicules` (`Vehicule_ID`, `Vehicule_Name`, `Vehicule_Serie`) VALUES
(1, 'Toyota', 'Camry'),
(2, 'Honda', 'Civic'),
(3, 'Ford', 'F-150'),
(4, 'Chevrolet', 'Silverado'),
(5, 'Jeep', 'Wrangler'),
(6, 'Nissan', 'Altima'),
(7, 'BMW', '3 Series'),
(8, 'Mercedes-Benz', 'E-Class'),
(9, 'Audi', 'A4'),
(10, 'Volkswagen', 'Jetta');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`Image_ID`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `Email` (`Email`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `Email` (`Email`),
  ADD KEY `Vehicule_ID` (`Vehicule_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Email`);

--
-- Indexes for table `vehicules`
--
ALTER TABLE `vehicules`
  ADD PRIMARY KEY (`Vehicule_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `Image_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `Order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `vehicules`
--
ALTER TABLE `vehicules`
  MODIFY `Vehicule_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `products` (`Product_ID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `users` (`Email`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `products` (`Product_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
