-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 02, 2025 at 11:08 PM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u611977159_msrdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `username`, `password`, `creation_date`, `last_login`) VALUES
(1, 'Jerin Pacquiao', 'jerin', 'jerin123', '2025-09-27 20:45:38', '2025-11-02 21:58:43'),
(3, 'Kylee Yang', 'kylee', '@kylee1234', '2025-09-27 20:45:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cottage`
--

CREATE TABLE `cottage` (
  `cottage_id` int(11) NOT NULL,
  `cottage_type` varchar(50) NOT NULL,
  `capacity` varchar(50) DEFAULT NULL,
  `cottage_price` decimal(10,2) NOT NULL,
  `cottage_availability` enum('available','maintenance') NOT NULL DEFAULT 'available',
  `photo` varchar(100) NOT NULL,
  `cottage_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cottage`
--

INSERT INTO `cottage` (`cottage_id`, `cottage_type`, `capacity`, `cottage_price`, `cottage_availability`, `photo`, `cottage_description`) VALUES
(1, 'Small Cottage', '2-3 People', 250.00, 'available', '1759058197_standard_cottage.jpg', 'Ordinary Cottage only.');

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `guest_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` varchar(250) NOT NULL,
  `contactno` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guest`
--

INSERT INTO `guest` (`guest_id`, `firstname`, `lastname`, `address`, `contactno`, `email`) VALUES
(4, 'Jerin', 'Pacquiao', 'P1 Lawis, Building 3', '091 234 5678', ''),
(5, 'John', 'Doe', 'Siquijor', '09506587329', ''),
(6, 'Jane', 'Doe', 'Tambulig Zamboanga Del Sur', '09105200950', ''),
(7, 'Jane', 'Doe', 'Sumalig, Tambulig Zamboanga Del Sur', '09105200970', ''),
(15, 'Rodrigo', 'Duterte', 'Sumalig, Tambulig Zamboanga Del Sur', '09105200970', ''),
(16, 'Rodrigo', 'Duterte', 'Sumalig, Tambulig Zamboanga Del Sur', '09105200970', ''),
(17, 'Dariel', 'Miano', 'P1 Lawis\r\nBuilding 3', '09123456789', ''),
(18, 'GUEST NAME', 'GUEST LASTNAME', 'UNITED STATES', '09123456789', ''),
(19, 'Name', 'Lastname', 'Canada', '09123456789', ''),
(20, 'Vince25', 'Tatt', 'United States', '09105200670', '');

-- --------------------------------------------------------

--
-- Table structure for table `owners_info`
--

CREATE TABLE `owners_info` (
  `info_id` int(11) NOT NULL,
  `gcash_number` varchar(50) NOT NULL,
  `gcash_name` varchar(100) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `facebook_account` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owners_info`
--

INSERT INTO `owners_info` (`info_id`, `gcash_number`, `gcash_name`, `email_address`, `phone_number`, `address`, `facebook_account`) VALUES
(1, '0950123456', 'Jerin Pac', 'mabanagspring@gmail.com', '0950123456', 'P-4, Barangay Tuboran, Mahayag, Zamboanga Del Sur', 'Mabanag Spring Resort');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `payment_date` datetime NOT NULL DEFAULT current_timestamp(),
  `paid_at` datetime DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_channel` varchar(50) DEFAULT NULL,
  `payment_reference` varchar(100) DEFAULT NULL,
  `xendit_invoice_id` varchar(100) DEFAULT NULL,
  `xendit_payment_link` varchar(255) DEFAULT NULL,
  `receipt_file` varchar(255) DEFAULT NULL,
  `payment_status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `payment_status_detail` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `reservation_id`, `payment_date`, `paid_at`, `amount`, `payment_method`, `payment_channel`, `payment_reference`, `xendit_invoice_id`, `xendit_payment_link`, `receipt_file`, `payment_status`, `payment_status_detail`) VALUES
(2, 3, '2025-09-28 13:25:04', NULL, 2000.00, 'gcash', NULL, NULL, NULL, NULL, 'uploads/receipts/receipt_1759037104_68d8c6b00c3e7.png', 'verified', NULL),
(3, 4, '2025-10-07 00:18:56', NULL, 250.00, 'gcash', NULL, '1234567', NULL, NULL, 'uploads/receipts/receipt_1759767536_68e3ebf0435e5.png', 'pending', NULL),
(10, 11, '2025-10-10 15:35:30', NULL, 250.00, 'gcash', NULL, '9309577321', NULL, NULL, 'uploads/receipts/receipt_1760081730_68e8b7425e8b8.png', 'verified', NULL),
(11, 12, '2025-10-17 09:15:10', NULL, 250.00, 'gcash', NULL, '4562345', NULL, NULL, 'uploads/receipts/receipt_1760663710_68f1989eb9d4b.jpg', 'verified', NULL),
(13, 14, '2025-10-19 07:31:28', NULL, 9000.00, 'gcash', NULL, '223344', NULL, NULL, 'uploads/receipts/receipt_1760830288_68f423500932e.jpg', 'pending', NULL),
(14, 15, '2025-10-30 11:47:26', NULL, 4500.00, 'gcash', NULL, '45623456', NULL, NULL, 'uploads/receipts/receipt_1761796046_6902dfce546d1.png', 'verified', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--


CREATE TABLE `reservation` (
  `reservation_id` int(11) NOT NULL,
  `guest_id` int(11) NOT NULL,
  `transaction_reference` varchar(10) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `cottage_id` int(11) DEFAULT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `reservation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','confirmed','cancelled') NOT NULL DEFAULT 'pending',
  `is_paid_online` tinyint(1) NOT NULL DEFAULT 0,
  `remarks` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `guest_id`, `transaction_reference`, `room_id`, `cottage_id`, `check_in_date`, `check_out_date`, `total_amount`, `reservation_date`, `status`, `is_paid_online`, `remarks`) VALUES
(3, 4, '4TZK9A', 1, NULL, '2025-09-29', '2025-10-03', 2000.00, '2025-09-28 13:25:04', 'confirmed', 0, NULL),
(4, 5, 'G5ZK7B', NULL, 1, '2025-10-09', NULL, 250.00, '2025-10-07 00:18:56', 'pending', 0, NULL),
(11, 16, 'N6OFBX', NULL, 1, '2025-10-16', NULL, 250.00, '2025-10-10 15:35:30', 'pending', 0, NULL),
(12, 17, '5FSWJN', NULL, 1, '2025-10-22', NULL, 250.00, '2025-10-17 09:15:10', 'confirmed', 0, NULL),
(14, 19, 'SK59TV', 3, NULL, '2025-10-20', '2025-10-22', 9000.00, '2025-10-19 07:31:28', 'pending', 0, NULL),
(15, 20, '1E2NID', 3, NULL, '2025-10-31', '2025-10-31', 4500.00, '2025-10-30 11:47:26', 'confirmed', 0, 'REQUESTING FOR CANCELLATION');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_number` int(11) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `room_price` decimal(10,2) NOT NULL,
  `room_availability` enum('available','occupied','maintenance') NOT NULL,
  `photo` varchar(100) NOT NULL,
  `room_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_number`, `room_type`, `room_price`, `room_availability`, `photo`, `room_description`) VALUES
(1, 1, 'Standard', 500.00, 'available', '1759031429_standard-photo.jpg', 'Good for 3 person with air conditions.'),
(3, 23, 'FAMILY AIRCONDITIONED ROOM', 4500.00, 'available', '1760829092_g2.jpg', 'Good for 8 with kitchen and terrace\r\n'),
(4, 32, ' BARKADAHAN AIRCON ROOM', 3500.00, 'available', '1760829261_g3.jpg', 'Good for 12 pax'),
(5, 12, ' BARKADAHAN AIRCON ROOM', 4000.00, 'available', '1760829301_bgmabanag.jpg', 'Good for 12 pax with terrace'),
(6, 31, 'FAN ROOMS', 700.00, 'available', '1760829371_g3.jpg', 'Good for 2');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `testimonial_id` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `guest_name` varchar(100) NOT NULL,
  `guest_location` varchar(100) DEFAULT NULL,
  `badge_category` varchar(50) DEFAULT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `review_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`testimonial_id`, `review_text`, `guest_name`, `guest_location`, `badge_category`, `rating`, `review_date`) VALUES
(1, 'Nice please to visit with a perfect nature vibes.', 'Jerin Pacquiao', 'Tangub City', 'Nature Lover', 5, '2025-10-17'),
(2, 'Nice view. I love you .', 'John Doe', 'USA', '', 4, '2025-10-17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cottage`
--
ALTER TABLE `cottage`
  ADD PRIMARY KEY (`cottage_id`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`guest_id`);

--
-- Indexes for table `owners_info`
--
ALTER TABLE `owners_info`
  ADD PRIMARY KEY (`info_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `guest_id` (`guest_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `cottage_id` (`cottage_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`testimonial_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cottage`
--
ALTER TABLE `cottage`
  MODIFY `cottage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `guest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `owners_info`
--
ALTER TABLE `owners_info`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `testimonial_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`reservation_id`) ON DELETE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`guest_id`) REFERENCES `guest` (`guest_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`cottage_id`) REFERENCES `cottage` (`cottage_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
