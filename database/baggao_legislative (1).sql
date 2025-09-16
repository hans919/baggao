-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2025 at 04:55 PM
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
-- Database: `baggao_legislative`
--

-- --------------------------------------------------------

--
-- Table structure for table `councilors`
--

CREATE TABLE `councilors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `position` varchar(50) NOT NULL,
  `term_start` year(4) NOT NULL,
  `term_end` year(4) NOT NULL,
  `committees` text DEFAULT NULL,
  `contact_info` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `councilors`
--

INSERT INTO `councilors` (`id`, `name`, `photo`, `position`, `term_start`, `term_end`, `committees`, `contact_info`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Hon. Maria Santos', NULL, 'Mayor', '2022', '2025', 'Executive Committee', NULL, 'active', '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(2, 'Hon. Juan Dela Cruz', NULL, 'Vice Mayor', '2022', '2025', 'Committee on Rules, Committee on Finance', NULL, 'active', '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(3, 'Hon. Ana Garcia', NULL, 'Councilor', '2022', '2025', 'Committee on Health, Committee on Education', NULL, 'active', '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(4, 'Hon. Pedro Rodriguez', NULL, 'Councilor', '2022', '2025', 'Committee on Public Works, Committee on Agriculture', NULL, 'active', '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(5, 'Hon. Carmen Lopez', NULL, 'Councilor', '2022', '2025', 'Committee on Social Services, Committee on Women', NULL, 'active', '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(6, 'Hon. Miguel Torres', NULL, 'Councilor', '2022', '2025', 'Committee on Youth and Sports, Committee on Tourism', NULL, 'active', '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(7, 'Hon. Rosa Fernandez', NULL, 'Councilor', '2022', '2025', 'Committee on Environment, Committee on Peace and Order', NULL, 'active', '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(8, 'Hon. Antonio Reyes', NULL, 'Councilor', '2022', '2025', 'Committee on Trade and Commerce, Committee on Transportation', NULL, 'active', '2025-09-02 14:01:20', '2025-09-02 14:01:20');

-- --------------------------------------------------------

--
-- Table structure for table `minutes`
--

CREATE TABLE `minutes` (
  `id` int(11) NOT NULL,
  `meeting_date` date NOT NULL,
  `session_type` varchar(100) NOT NULL,
  `agenda` text NOT NULL,
  `attendees` text NOT NULL,
  `summary` text NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `minutes`
--

INSERT INTO `minutes` (`id`, `meeting_date`, `session_type`, `agenda`, `attendees`, `summary`, `file_path`, `status`, `created_at`, `updated_at`) VALUES
(1, '2024-01-15', 'Regular Session', '1. Call to Order\n2. Reading of Minutes\n3. Committee Reports\n4. New Business - Environmental Protection Code\n5. Adjournment', 'Mayor Santos, Vice Mayor Dela Cruz, Councilor Garcia, Councilor Rodriguez, Councilor Lopez, Councilor Torres, Councilor Fernandez, Councilor Reyes', 'The council convened to discuss the proposed Environmental Protection Code. After thorough deliberation, the ordinance was passed unanimously.', NULL, 'published', '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(2, '2024-02-20', 'Special Session', '1. Call to Order\n2. Business Regulation Ordinance\n3. Budget Allocation Discussion\n4. Adjournment', 'Mayor Santos, Vice Mayor Dela Cruz, Councilor Garcia, Councilor Rodriguez, Councilor Lopez, Councilor Torres, Councilor Fernandez, Councilor Reyes', 'Special session focused on business regulation measures and budget considerations.', NULL, 'published', '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(3, '2024-03-10', 'Regular Session', '1. Call to Order\n2. Youth Development Program Proposal\n3. Resolution on Clean Air Support\n4. Committee Reports\n5. Adjournment', 'Mayor Santos, Vice Mayor Dela Cruz, Councilor Garcia, Councilor Rodriguez, Councilor Lopez, Councilor Torres, Councilor Fernandez, Councilor Reyes', 'Discussion and approval of youth development initiatives and environmental resolutions.', NULL, 'published', '2025-09-02 14:01:20', '2025-09-02 14:01:20');

-- --------------------------------------------------------

--
-- Table structure for table `ordinances`
--

CREATE TABLE `ordinances` (
  `id` int(11) NOT NULL,
  `ordinance_number` varchar(50) NOT NULL,
  `title` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `date_passed` date NOT NULL,
  `status` enum('passed','pending','rejected') DEFAULT 'pending',
  `file_path` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordinances`
--

INSERT INTO `ordinances` (`id`, `ordinance_number`, `title`, `author_id`, `date_passed`, `status`, `file_path`, `summary`, `keywords`, `created_at`, `updated_at`) VALUES
(1, 'ORD-2024-001', 'An Ordinance Establishing the Baggao Environmental Protection Code', 3, '2024-01-15', 'passed', NULL, 'This ordinance establishes comprehensive environmental protection measures for Baggao.', 'environment, protection, code', '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(2, 'ORD-2024-002', 'An Ordinance Regulating the Operation of Business Establishments', 8, '2024-02-20', 'passed', NULL, 'Regulation of business operations within the municipality.', 'business, regulation, establishments', '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(3, 'ORD-2024-003', 'An Ordinance Creating the Baggao Youth Development Program', 6, '2024-03-10', 'passed', NULL, 'Establishment of youth development initiatives and programs.', 'youth, development, program', '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(4, '2025-01', 'TEST', 5, '2025-09-12', 'passed', 'ordinances/module-1--introduction-to-web-interactivity-and-engagement_68c37b3996b06.pdf', 'ASDASD', 'ASDSAD', '2025-09-12 01:31:52', '2025-09-12 01:45:29');

-- --------------------------------------------------------

--
-- Table structure for table `ordinance_comments`
--

CREATE TABLE `ordinance_comments` (
  `id` int(11) NOT NULL,
  `ordinance_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordinance_comments`
--

INSERT INTO `ordinance_comments` (`id`, `ordinance_id`, `comment_text`, `status`, `created_at`) VALUES
(1, 4, 'NICE', 'pending', '2025-09-12 02:09:42');

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

CREATE TABLE `publications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` enum('memo','announcement','legislative_update','notice') NOT NULL,
  `date_posted` date NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'published',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publications`
--

INSERT INTO `publications` (`id`, `title`, `content`, `category`, `date_posted`, `file_path`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Municipal Health Advisory', 'The Municipal Health Office advises all residents to follow health protocols during the flu season.', 'announcement', '2024-01-10', NULL, 'published', 1, '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(2, 'Legislative Update: Environmental Ordinance', 'The Municipal Council has passed a comprehensive environmental protection ordinance effective immediately.', 'legislative_update', '2024-01-16', NULL, 'published', 1, '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(3, 'Memorandum: Office Hours During Holy Week', 'All municipal offices will observe modified schedules during the Holy Week period.', 'memo', '2024-03-25', NULL, 'published', 1, '2025-09-02 14:01:20', '2025-09-02 14:01:20');

-- --------------------------------------------------------

--
-- Table structure for table `resolutions`
--

CREATE TABLE `resolutions` (
  `id` int(11) NOT NULL,
  `resolution_number` varchar(50) NOT NULL,
  `subject` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `date_approved` date NOT NULL,
  `status` enum('approved','pending','rejected') DEFAULT 'pending',
  `file_path` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resolutions`
--

INSERT INTO `resolutions` (`id`, `resolution_number`, `subject`, `author_id`, `date_approved`, `status`, `file_path`, `summary`, `keywords`, `created_at`, `updated_at`) VALUES
(1, 'RES-2024-001', 'Resolution Declaring Support for National Clean Air Program', 7, '2024-01-25', 'approved', NULL, 'Municipal support for national environmental initiatives.', 'clean air, environment, support', '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(2, 'RES-2024-002', 'Resolution Authorizing the Mayor to Enter into MOA with Provincial Government', 1, '2024-02-15', 'approved', NULL, 'Authorization for memorandum of agreement execution.', 'MOA, provincial, authorization', '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(3, 'RES-2024-003', 'Resolution Commending Outstanding Teachers of Baggao', 3, '2024-03-05', 'approved', NULL, 'Recognition of exemplary educators in the municipality.', 'teachers, commendation, education', '2025-09-02 14:01:20', '2025-09-02 14:01:20'),
(4, 'RES-2024', 'TEST', 8, '2025-09-12', '', 'resolutions/module-1--introduction-to-web-interactivity-and-engagement_68c37b3996b06_68c37c2d12d70.pdf', 'ASDAS', 'ASSAD', '2025-09-12 01:49:33', '2025-09-12 01:49:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','secretary') NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `full_name`, `created_at`, `updated_at`) VALUES
(1, 'admin@baggao.gov.ph', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'System Administrator', '2025-09-02 14:01:20', '2025-09-16 12:27:30'),
(2, 'admin123@baggao.gov.ph', '$2y$10$zOqvU86QWZAT4lzxU3jW1u7MygbbKFxfBlHstQ9EF.3EBZc7zBxdi', 'admin', '', '2025-09-12 01:15:04', '2025-09-16 12:27:30'),
(3, 'admin@example.com', '$2y$10$YK2uFHYMhvK40p0FPVyHoORNO6tYzxaUoSOMG/1ww4MJzf.3.AZia', 'admin', '', '2025-09-16 12:29:11', '2025-09-16 12:29:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `councilors`
--
ALTER TABLE `councilors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `minutes`
--
ALTER TABLE `minutes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordinances`
--
ALTER TABLE `ordinances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ordinance_number` (`ordinance_number`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `ordinance_comments`
--
ALTER TABLE `ordinance_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ordinance_id` (`ordinance_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `resolutions`
--
ALTER TABLE `resolutions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `resolution_number` (`resolution_number`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `councilors`
--
ALTER TABLE `councilors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `minutes`
--
ALTER TABLE `minutes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ordinances`
--
ALTER TABLE `ordinances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ordinance_comments`
--
ALTER TABLE `ordinance_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `publications`
--
ALTER TABLE `publications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `resolutions`
--
ALTER TABLE `resolutions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ordinances`
--
ALTER TABLE `ordinances`
  ADD CONSTRAINT `ordinances_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `councilors` (`id`);

--
-- Constraints for table `ordinance_comments`
--
ALTER TABLE `ordinance_comments`
  ADD CONSTRAINT `fk_comment_ordinance` FOREIGN KEY (`ordinance_id`) REFERENCES `ordinances` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `publications`
--
ALTER TABLE `publications`
  ADD CONSTRAINT `publications_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `resolutions`
--
ALTER TABLE `resolutions`
  ADD CONSTRAINT `resolutions_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `councilors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
