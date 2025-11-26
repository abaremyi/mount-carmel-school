-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2025 at 07:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mushya_web_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('new','read','replied') DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `service_type`, `message`, `created_at`, `status`) VALUES
(18, 'ABAYO', 'abaremy1997@gmail.com', '+250787254817', 'Technology Partnership', 'Test Nb 2', '2025-11-04 07:56:02', 'new'),
(19, 'ABA REMY', 'remy.abayo@auca.ac.rw', '+250787254817', 'Reseller Services', 'Test Email Sending', '2025-11-04 08:27:24', 'new'),
(20, 'ABAYO Remy', 'remy.abayo@auca.ac.rw', '0785720549', 'Software & Website Development', 'I need to test whether this contact us page works', '2025-11-04 08:34:43', 'new'),
(21, 'KEVIN UZA', 'aba1remy@gmail.com', '0798855224', 'IT Support & Maintenance', 'I would Like to as the way we may meet and have conversation about the services ', '2025-11-04 08:38:04', 'new'),
(22, 'ABA REMY', 'aba1remy@gmail.com', '250788678211', 'IT Support & Maintenance', 'Double test', '2025-11-08 15:40:42', 'new'),
(23, 'THE CHILD Man', 'info.abaremy@gmail.com', '+250721053807', 'Software & Website Development', 'Hello,\nI want to make a request from you.\nWould you mind if you make me a software of managing my entire company?\nPlease talk to me soon!', '2025-11-08 15:44:55', 'new');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `author` varchar(100) DEFAULT 'MUSHYA Group',
  `status` enum('published','draft','archived') DEFAULT 'published',
  `featured` tinyint(1) DEFAULT 0,
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `published_at` timestamp NULL DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `short_description`, `content`, `image_path`, `category`, `tags`, `author`, `status`, `featured`, `views`, `created_at`, `updated_at`, `published_at`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
(1, 'Essential Documents Required for Software Development Projects', 'essential-documents-software-development-projects', 'Discover the complete documentation needed for successful software development projects with MUSHYA Group.', 'Comprehensive guide on the essential documentation required for software development projects. Learn about project requirements documents, technical specifications, user stories, and project planning documentation that ensures successful delivery of technology solutions.', 'news/software-docs.jpg', 'Software Development', 'documentation,software development,project management', 'MUSHYA Group', 'published', 1, 0, '2025-10-31 16:40:15', '2025-10-31 16:40:15', '2025-10-31 16:40:15', NULL, NULL, NULL),
(2, 'Understanding Development Costs for Enterprise Software Solutions', 'understanding-development-costs-enterprise-software', 'Get detailed insights into the pricing structure for custom software development services.', 'Detailed analysis of enterprise software development costs. Compare different pricing models, understand factors affecting development costs, and learn about MUSHYA Group\'s transparent pricing structure for custom software solutions, mobile apps, and web applications.', 'news/development-costs.jpg', 'Business Insights', 'pricing,enterprise software,development costs', 'MUSHYA Group', 'published', 1, 0, '2025-10-31 16:40:15', '2025-10-31 16:40:15', '2025-10-29 16:40:15', NULL, NULL, NULL),
(3, 'How to Manage and Track Software Development Projects Effectively', 'manage-track-software-development-projects', 'Comprehensive guide on project management methodologies and tracking tools for software development.', 'Explore effective project management strategies for software development. Learn about agile methodologies, scrum frameworks, and the tools MUSHYA Group uses to ensure timely delivery and quality assurance in all our technology projects.', 'news/project-management.jpg', 'Project Management', 'project management,agile,scrum,development', 'MUSHYA Group', 'published', 0, 0, '2025-10-31 16:40:15', '2025-10-31 16:40:15', '2025-10-27 16:40:15', NULL, NULL, NULL),
(4, 'Premium Maintenance: Keeping Software Systems in Perfect Condition', 'premium-maintenance-software-systems', 'Explore MUSHYA Group\'s rigorous maintenance protocols for software systems and applications.', 'Learn about MUSHYA Group\'s comprehensive software maintenance protocols that ensure every application meets the highest standards of performance and security. Discover our scheduled updates, quality checks, and commitment to delivering exceptional user experiences with well-maintained software solutions.', 'news/software-maintenance.jpg', 'Software Maintenance', 'maintenance,updates,security,performance', 'MUSHYA Group', 'published', 0, 0, '2025-10-31 16:40:15', '2025-10-31 16:40:15', '2025-10-25 16:40:15', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE `pictures` (
  `picid` int(11) NOT NULL,
  `prodid` int(11) NOT NULL,
  `projid` int(11) NOT NULL,
  `url` varchar(1000) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`picid`, `prodid`, `projid`, `url`, `status`) VALUES
(1, 0, 1, 'Everretreat-1.png', 'active'),
(2, 0, 1, 'Everretreat-2.png', 'active'),
(3, 0, 1, 'Everretreat-3.png', 'active'),
(4, 0, 2, 'Heratbeat-1.png', 'active'),
(5, 0, 2, 'Heratbeat-2.png', 'active'),
(6, 0, 3, 'Fabafrican-1.png', 'active'),
(7, 0, 3, 'Fabafrican-2.png', 'active'),
(8, 0, 3, 'Fabafrican-3.png', 'active'),
(9, 0, 3, 'Fabafrican-4.png', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `projid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` varchar(500) DEFAULT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `pictureid` int(11) NOT NULL,
  `project_url` varchar(500) DEFAULT NULL,
  `status` enum('completed','in_progress','under_development','planning') NOT NULL,
  `category` enum('website_development','ecommerce','mobile_app','enterprise_solution','charity','education','healthcare','wellness') NOT NULL,
  `industry` enum('wellness','non_profit','business','ecommerce','education','healthcare','technology') NOT NULL,
  `technologies` varchar(500) DEFAULT NULL,
  `launch_date` date DEFAULT NULL,
  `expected_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `featured` tinyint(1) DEFAULT 0,
  `preview` enum('allowed','blocked','','') NOT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `project_duration` varchar(100) DEFAULT NULL,
  `project_budget` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`projid`, `title`, `description`, `short_description`, `image_path`, `pictureid`, `project_url`, `status`, `category`, `industry`, `technologies`, `launch_date`, `expected_date`, `created_at`, `updated_at`, `featured`, `preview`, `client_name`, `project_duration`, `project_budget`) VALUES
(1, 'EverRetreat - Wellness Platform', 'A comprehensive wellness platform connecting users with retreat experiences worldwide', 'A comprehensive wellness platform connecting users with retreat experiences, wellness practitioners, and holistic health resources worldwide.', 'Everretreat.png', 0, 'https://everretreat.com/', 'completed', 'website_development', 'wellness', 'PHP,React,MySQL', '2025-04-11', NULL, '2025-10-30 11:38:15', '2025-11-01 14:19:07', 1, 'allowed', NULL, NULL, NULL),
(2, 'Heartbeat Africa - Charity Platform', 'Digital platform supporting healthcare initiatives across Africa', 'A digital platform supporting healthcare initiatives across Africa, connecting donors with impactful medical projects.', 'Heartbeat.png', 0, 'https://heart-beat-africa.vercel.app/', 'in_progress', 'charity', 'non_profit', 'PHP,JavaScript,MySQL', NULL, '2025-09-30', '2025-10-30 11:38:15', '2025-10-30 21:56:57', 1, 'allowed', NULL, NULL, NULL),
(3, 'FAB African Things Website', 'E-commerce platform for natural skincare products', 'Fab African Things offers 100 percent natural, rejuvenating products for holistic skincare approach.', 'Fabafricanthings.png', 0, 'https://fabafricanthings.com', 'completed', 'ecommerce', 'business', 'PHP,JavaScript,CSS', '2023-11-20', NULL, '2025-10-30 11:38:15', '2025-10-31 06:25:19', 1, 'blocked', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`picid`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`projid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `picid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `projid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
