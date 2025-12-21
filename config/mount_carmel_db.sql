-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2025 at 11:26 AM
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
-- Database: `mount_carmel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(500) NOT NULL,
  `thumbnail_url` varchar(500) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'general',
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `title`, `description`, `image_url`, `thumbnail_url`, `category`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Classroom Activities', 'Students engaged in interactive learning', '/gallery/sport-1.jpeg', NULL, 'academics', 1, 'active', '2025-11-25 20:52:49', '2025-11-28 07:51:09'),
(2, 'Science Laboratory', 'Modern science lab facilities', '/gallery/sport-2.jpeg', NULL, 'facilities', 2, 'active', '2025-11-25 20:52:49', '2025-11-28 07:51:09'),
(3, 'Sports Day Event', 'Annual sports day celebration', '/gallery/sport-3.jpg', NULL, 'events', 3, 'active', '2025-11-25 20:52:49', '2025-11-28 07:51:09'),
(4, 'Library Study', 'Students reading in our library', '/gallery/sport-4.jpeg', NULL, 'facilities', 4, 'active', '2025-11-25 20:52:49', '2025-11-28 07:51:09'),
(5, 'Music Class', 'Learning musical instruments', '/gallery/student-4.jpg', NULL, 'extracurricular', 5, 'active', '2025-11-25 20:52:49', '2025-11-28 07:51:09'),
(6, 'Art Exhibition', 'Student artwork display', '/gallery/student-5.jpg', NULL, 'events', 6, 'active', '2025-11-25 20:52:49', '2025-11-28 07:51:09'),
(7, 'Computer Lab', 'Technology-equipped learning space', '/gallery/student-6.jpg', NULL, 'facilities', 7, 'active', '2025-11-25 20:52:49', '2025-11-28 07:51:09'),
(8, 'Graduation Ceremony', 'Annual graduation celebration', '/gallery/student-7.jpg', NULL, 'events', 8, 'active', '2025-11-25 20:52:49', '2025-11-28 07:51:09'),
(9, 'Playground Activities', 'Students enjoying outdoor time', '/gallery/Gallery-4850.jpeg', NULL, 'campus', 9, 'active', '2025-11-25 20:52:49', '2025-12-15 13:51:57'),
(10, 'Assembly Hall', 'Morning assembly gathering', '/gallery/Gallery-2121.jpg', NULL, 'campus', 10, 'active', '2025-11-25 20:52:49', '2025-12-15 13:52:43');

-- --------------------------------------------------------

--
-- Table structure for table `hero_sliders`
--

CREATE TABLE `hero_sliders` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(500) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(500) NOT NULL,
  `button1_text` varchar(100) DEFAULT 'Learn More',
  `button1_link` varchar(500) DEFAULT '#',
  `button2_text` varchar(100) DEFAULT 'Contact Us',
  `button2_link` varchar(500) DEFAULT '#',
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero_sliders`
--

INSERT INTO `hero_sliders` (`id`, `title`, `subtitle`, `description`, `image_url`, `button1_text`, `button1_link`, `button2_text`, `button2_link`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Start Your Beautiful And Bright Future', 'Excellence in Education', 'Empowering students to achieve excellence through quality education, modern facilities, and dedicated faculty members.', '/slider/Slider-3232.jpg', 'Explore Programs', '#programs', 'Contact Us', '/contact', 1, 'active', '2025-11-29 10:50:53', '2025-12-15 10:15:06'),
(2, 'Excellence In Education Since 2013', 'Building Future Leaders', 'Building tomorrow\'s leaders through comprehensive learning programs and character development.', '/slider/Slider-6031.jpg', 'Apply Now', '#admissions', 'Learn More', '/about', 2, 'active', '2025-11-29 10:50:53', '2025-12-15 10:18:16'),
(3, 'Modern Facilities Expert Teachers', 'Quality Education', 'State-of-the-art infrastructure combined with experienced educators for the best learning experience.', '/slider/slider-3.jpg', 'Our Facilities', '#facilities', 'View Gallery', '/gallery', 3, 'active', '2025-11-29 10:50:53', '2025-11-29 10:50:53');

-- --------------------------------------------------------

--
-- Table structure for table `news_events`
--

CREATE TABLE `news_events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `description` longtext NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `thumbnail_url` varchar(500) DEFAULT NULL,
  `category` enum('news','event','announcement','achievement') DEFAULT 'news',
  `author` varchar(100) DEFAULT NULL,
  `published_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `featured` tinyint(1) DEFAULT 0,
  `event_location` varchar(255) DEFAULT NULL,
  `event_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news_events`
--

INSERT INTO `news_events` (`id`, `title`, `excerpt`, `description`, `image_url`, `thumbnail_url`, `category`, `author`, `published_date`, `end_date`, `status`, `views`, `created_at`, `updated_at`, `featured`, `event_location`, `event_time`, `end_time`) VALUES
(1, 'Annual Sports Day 2024', 'Join us for our exciting Annual Sports Day featuring various competitions and activities for all students.', 'Our Annual Sports Day is a celebration of athleticism, teamwork, and school spirit. Students from all grades participate in various sporting events including track and field, basketball, football, and many more. This year promises to be even more exciting with new activities and competitions. Parents and guardians are warmly invited to attend and cheer for their children.', '/news/news-1.jpg', NULL, 'event', 'Admin', '2026-01-02', NULL, 'published', 5, '2025-11-25 21:57:33', '2025-12-15 22:07:02', 1, 'School Playground', '09:00:00', NULL),
(2, 'Science Fair Winners', 'Congratulations to our students who won top prizes at the Regional Science Fair competition.', 'We are proud to announce that our students have excelled at the Regional Science Fair, bringing home multiple awards including first place in the Biology category and second place in Physics. Their innovative projects and dedication to scientific inquiry have made Mount Carmel School proud. Special congratulations to Sarah Mugisha, John Kamanzi, and their team members for their outstanding achievements.', '/news/news-2.jpg', NULL, 'achievement', 'Admin', '2025-12-14', NULL, 'published', 4, '2025-11-25 21:57:33', '2025-12-15 22:06:38', 0, 'Science Lab', '10:00:00', NULL),
(3, 'Parent-Teacher Meeting', 'Quarterly parent-teacher meeting scheduled to discuss student progress and development.', 'We invite all parents to attend our quarterly parent-teacher meeting where we will discuss student progress, upcoming events, and ways parents can support their children\'s learning at home. This is an excellent opportunity to meet with teachers, understand your child\'s academic journey, and participate in planning for the next term. Refreshments will be served.', '/news/news-3.jpg', NULL, 'announcement', 'Admin', '2025-12-26', NULL, 'published', 4, '2025-11-25 21:57:33', '2025-12-15 22:07:46', 0, 'Main Hall', '14:00:00', NULL),
(4, 'New Library Inauguration', 'Our new state-of-the-art library has been officially inaugurated with over 5000 books.', 'Mount Carmel School is proud to announce the inauguration of our new library facility, equipped with modern amenities, comfortable reading spaces, and over 5,000 books covering various subjects and interests. The library features dedicated sections for different age groups, computer stations for research, and quiet study areas. We thank all our donors and supporters who made this project possible.', '/news/news-4.jpg', NULL, 'news', 'Admin', '2025-12-19', NULL, 'published', 3, '2025-11-25 21:57:33', '2025-12-15 22:09:24', 0, 'Library', '15:00:00', NULL),
(5, 'New Computer Lab Opens', 'Our new computer lab with 30 modern computers is now open for students.', 'Mount Carmel School is excited to announce the opening of our new state-of-the-art computer laboratory. Equipped with 30 modern computers, high-speed internet, and educational software, this facility will enhance digital literacy among our students.', '/news/computer-lab.jpg', NULL, 'news', 'Admin', '2024-11-15', NULL, 'published', 0, '2025-12-06 22:03:27', '2025-12-06 22:03:27', 0, NULL, NULL, NULL),
(6, 'Math Olympiad Winners', 'Our students win gold medals in the National Math Olympiad competition.', 'Congratulations to our mathematics team for winning three gold medals in the National Math Olympiad. Their dedication and problem-solving skills have brought great honor to our school.', '/news/math-olympiad.jpg', NULL, 'achievement', 'Admin', '2024-11-10', NULL, 'published', 0, '2025-12-06 22:03:27', '2025-12-06 22:03:27', 0, NULL, NULL, NULL),
(7, 'Thanksgiving Celebration', 'Join us for our annual Thanksgiving celebration and cultural show.', 'Our annual Thanksgiving celebration will feature cultural performances, traditional food, and expressions of gratitude. All parents and guardians are invited to join this joyful occasion.', '/news/thanksgiving.jpg', NULL, 'event', 'Admin', '2025-12-09', NULL, 'published', 3, '2025-12-06 22:03:27', '2025-12-15 22:01:30', 0, NULL, NULL, NULL),
(8, 'Exam Schedule Released', 'Important: End of term examination schedule is now available.', 'The end of term examination schedule has been released. Please check with class teachers for detailed timetables and preparation guidelines.', '/news/exam-schedule.jpg', NULL, 'announcement', 'Admin', '2024-11-12', NULL, 'published', 1, '2025-12-06 22:03:27', '2025-12-15 13:23:16', 0, NULL, NULL, NULL),
(9, 'Environmental Club Plantation Drive', 'Students plant 100 trees in the school campus as part of environmental awareness.', 'Our Environmental Club organized a successful plantation drive, planting 100 trees across the school campus. This initiative promotes environmental conservation and sustainability.', '/news/plantation-drive.jpg', NULL, 'news', 'Admin', '2024-11-08', NULL, 'published', 0, '2025-12-06 22:03:27', '2025-12-06 22:03:27', 0, NULL, NULL, NULL),
(10, 'Annual Day Preparations', 'Rehearsals for Annual Day celebrations begin next week.', 'Preparations for our Annual Day celebrations are underway. Students will participate in various performances showcasing their talents in music, dance, and drama.', '/news/annual-day.jpg', NULL, 'event', 'Admin', '2025-12-15', NULL, 'published', 5, '2025-12-06 22:03:27', '2025-12-15 22:11:14', 0, NULL, NULL, NULL),
(11, 'Debate Competition Results', 'Mount Carmel debaters win inter-school debate competition.', 'Our debate team emerged victorious in the Inter-School Debate Competition, showcasing exceptional oratory skills and critical thinking abilities.', '/news/debate.jpg', NULL, 'achievement', 'Admin', '2024-11-05', NULL, 'published', 0, '2025-12-06 22:03:27', '2025-12-06 22:03:27', 0, NULL, NULL, NULL),
(12, 'Parent Workshop: Digital Safety', 'Free workshop for parents on digital safety and cyber security.', 'Learn how to keep your children safe online in our special workshop for parents. Experts will share practical tips and strategies for digital safety.', '/news/digital-safety.jpg', NULL, 'announcement', 'Admin', '2024-11-18', NULL, 'published', 1, '2025-12-06 22:03:27', '2025-12-15 16:03:28', 0, NULL, NULL, NULL),
(14, 'Sports Equipment Donation', 'Local business donates new sports equipment to the school.', '<p>We thank XYZ Sports for their generous donation of new sports equipment including footballs, basketballs, and athletic gear.</p>\r\n', '/news/News-8260.jpg', NULL, 'news', 'Admin', '2024-11-03', '0000-00-00', 'published', 1, '2025-12-06 22:03:27', '2025-12-15 13:23:21', 0, '', '00:00:00', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `page_content`
--

CREATE TABLE `page_content` (
  `id` int(11) NOT NULL,
  `page_name` varchar(100) NOT NULL,
  `section_name` varchar(100) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_content`
--

INSERT INTO `page_content` (`id`, `page_name`, `section_name`, `title`, `content`, `image_url`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'about', 'who_we_are', 'Who We Are', '<h3>Building Tomorrow\'s Leaders</h3>\r\n<p>Mount Carmel School is a nurturing bilingual institution founded in 2013 by Reverend Pastor Jeanne D\'Arc Uwanyiligira. We are dedicated to providing quality education that combines academic excellence with spiritual growth.</p>\r\n<p>Our commitment extends beyond academics. We nurture curiosity, character, and a lifelong love of learning through comprehensive programs in academics, outdoor education, arts, sports, leadership, and community service.</p>', '/about/school-venue-1.jpg', 1, 'active', '2025-12-13 11:35:40', '2025-12-13 11:35:40'),
(2, 'about', 'mission', 'Our Mission', '<p>To train child to honor GOD, develop their potential skills; achieve excellence in academics, wisdom and character.</p>\r\n', '/about/mission2.png', 2, 'active', '2025-12-13 11:35:40', '2025-12-15 12:57:09'),
(3, 'about', 'vision', 'Our Vision', 'To bless Rwanda with GOD fearing citizens, highly skilled and generation transformers for GOD\'S glory.', '/about/vision.png', 3, 'active', '2025-12-13 11:35:40', '2025-12-13 11:35:40'),
(4, 'about', 'philosophy', 'Our Philosophy', 'We believe in holistic education that nurtures the mind, body, and spirit. Every child is unique and capable of excellence when given proper guidance, support, and a nurturing environment rooted in faith.', '/about/philosophy.png', 4, 'active', '2025-12-13 11:35:40', '2025-12-13 11:35:40'),
(5, 'about', 'history', 'Our History', '<h3>A Legacy of Faith and Excellence</h3>\r\n<p>Mount Carmel School was founded in 2013 by <strong>Reverend Pastor Jeanne D\'Arc Uwanyiligira</strong>, who was inspired by a deep desire to promote quality education rooted in Christian values.</p>', '/about/school-venue-2.jpg', 5, 'active', '2025-12-13 11:35:40', '2025-12-13 11:35:40'),
(6, 'home', 'director_message', 'A Message from Our Director', '<h2>A Letter from the Acting Legal Representative</h2>\r\n<p class=\"letter-greeting\">Dear Parents and Guardians,</p>\r\n<p>It is with great joy and privilege that I welcome you to <span class=\"highlight-text\">Mount Carmel School</span>, a nurturing bilingual institution committed to academic excellence and strong Christian values.</p>', '/director-photo.jpg', 1, 'active', '2025-12-13 11:35:40', '2025-12-13 11:35:40'),
(7, 'about', 'core_values', 'Our Core Values', 'Academic Excellence, Stewardship, Hard Work & Unity, Patriotism, Discipleship, Wisdom, Integrity, Love for All', NULL, 6, 'active', '2025-12-13 11:35:40', '2025-12-13 11:35:40');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `module` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`, `module`, `action`, `created_at`) VALUES
(1, 'view_dashboard', 'View dashboard', 'dashboard', 'view', '2025-12-09 16:32:49'),
(2, 'view_users', 'View users list', 'users', 'view', '2025-12-09 16:32:49'),
(3, 'create_users', 'Create new users', 'users', 'create', '2025-12-09 16:32:49'),
(4, 'edit_users', 'Edit users', 'users', 'edit', '2025-12-09 16:32:49'),
(5, 'delete_users', 'Delete users', 'users', 'delete', '2025-12-09 16:32:49'),
(6, 'view_roles', 'View roles', 'roles', 'view', '2025-12-09 16:32:49'),
(7, 'create_roles', 'Create roles', 'roles', 'create', '2025-12-09 16:32:49'),
(8, 'edit_roles', 'Edit roles', 'roles', 'edit', '2025-12-09 16:32:49'),
(9, 'delete_roles', 'Delete roles', 'roles', 'delete', '2025-12-09 16:32:49'),
(10, 'assign_permissions', 'Assign permissions to roles', 'roles', 'assign_permissions', '2025-12-09 16:32:49'),
(11, 'view_students', 'View students', 'students', 'view', '2025-12-09 16:32:49'),
(12, 'create_students', 'Add students', 'students', 'create', '2025-12-09 16:32:49'),
(13, 'edit_students', 'Edit student info', 'students', 'edit', '2025-12-09 16:32:49'),
(14, 'delete_students', 'Remove students', 'students', 'delete', '2025-12-09 16:32:49'),
(15, 'view_staff', 'View staff', 'staff', 'view', '2025-12-09 16:32:49'),
(16, 'create_staff', 'Add staff', 'staff', 'create', '2025-12-09 16:32:49'),
(17, 'edit_staff', 'Edit staff info', 'staff', 'edit', '2025-12-09 16:32:49'),
(18, 'delete_staff', 'Remove staff', 'staff', 'delete', '2025-12-09 16:32:49'),
(19, 'manage_classes', 'Manage classes', 'academics', 'manage_classes', '2025-12-09 16:32:49'),
(20, 'manage_subjects', 'Manage subjects', 'academics', 'manage_subjects', '2025-12-09 16:32:49'),
(21, 'manage_timetable', 'Manage timetable', 'academics', 'manage_timetable', '2025-12-09 16:32:49'),
(22, 'view_finances', 'View finances', 'finance', 'view', '2025-12-09 16:32:49'),
(23, 'manage_fees', 'Manage fee structure', 'finance', 'manage_fees', '2025-12-09 16:32:49'),
(24, 'process_payments', 'Process payments', 'finance', 'process_payments', '2025-12-09 16:32:49'),
(25, 'manage_news', 'Manage news & events', 'website', 'manage_news', '2025-12-09 16:32:49'),
(26, 'manage_gallery', 'Manage gallery', 'website', 'manage_gallery', '2025-12-09 16:32:49'),
(27, 'manage_testimonials', 'Manage testimonials', 'website', 'manage_testimonials', '2025-12-09 16:32:49'),
(28, 'manage_sliders', 'Manage hero sliders', 'website', 'manage_sliders', '2025-12-09 16:32:49'),
(29, 'manage_content', 'Manage page content', 'website', 'manage_content', '2025-12-13 11:35:40');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `is_super_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `is_super_admin`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'Has full system access', 1, '2025-12-09 16:32:49', '2025-12-09 16:32:49'),
(2, 'Administrator', 'School administration staff', 0, '2025-12-09 16:32:49', '2025-12-09 16:32:49'),
(3, 'Teacher', 'Teaching staff', 0, '2025-12-09 16:32:49', '2025-12-09 16:32:49'),
(4, 'Parent', 'Student parents', 0, '2025-12-09 16:32:49', '2025-12-09 16:32:49'),
(5, 'Student', 'School students', 0, '2025-12-09 16:32:49', '2025-12-09 16:32:49');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`, `created_at`) VALUES
(1, 1, 19, '2025-12-09 16:32:49'),
(2, 1, 20, '2025-12-09 16:32:49'),
(3, 1, 21, '2025-12-09 16:32:49'),
(4, 1, 1, '2025-12-09 16:32:49'),
(5, 1, 23, '2025-12-09 16:32:49'),
(6, 1, 24, '2025-12-09 16:32:49'),
(7, 1, 22, '2025-12-09 16:32:49'),
(8, 1, 10, '2025-12-09 16:32:49'),
(9, 1, 7, '2025-12-09 16:32:49'),
(10, 1, 9, '2025-12-09 16:32:49'),
(11, 1, 8, '2025-12-09 16:32:49'),
(12, 1, 6, '2025-12-09 16:32:49'),
(13, 1, 16, '2025-12-09 16:32:49'),
(14, 1, 18, '2025-12-09 16:32:49'),
(15, 1, 17, '2025-12-09 16:32:49'),
(16, 1, 15, '2025-12-09 16:32:49'),
(17, 1, 12, '2025-12-09 16:32:49'),
(18, 1, 14, '2025-12-09 16:32:49'),
(19, 1, 13, '2025-12-09 16:32:49'),
(20, 1, 11, '2025-12-09 16:32:49'),
(21, 1, 3, '2025-12-09 16:32:49'),
(22, 1, 5, '2025-12-09 16:32:49'),
(23, 1, 4, '2025-12-09 16:32:49'),
(24, 1, 2, '2025-12-09 16:32:49'),
(25, 1, 26, '2025-12-09 16:32:49'),
(26, 1, 25, '2025-12-09 16:32:49'),
(27, 1, 28, '2025-12-09 16:32:49'),
(28, 1, 27, '2025-12-09 16:32:49'),
(32, 1, 29, '2025-12-13 11:35:40');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `rating` int(11) DEFAULT 5,
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `role`, `content`, `image_url`, `rating`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Alice Johnson', 'Parent of Grade 5 Student', 'Mount Carmel School has provided an excellent learning environment for my child. The bilingual program and dedicated teachers have made a significant difference in his academic growth.', '/testimonials/parent-1.jpg', 5, 0, 'active', '2025-11-28 14:54:03', '2025-11-29 10:08:51'),
(2, 'David Smith', 'Parent of Nursery Student', 'The holistic approach to education at MCS has helped my daughter develop not just academically but also as a confident individual with strong moral values.', '/testimonials/parent-2.jpg', 5, 0, 'active', '2025-11-28 14:54:03', '2025-11-29 10:08:51'),
(3, 'Sarah Williams', 'Parent of Grade 3 Student', 'We\'re impressed with the school\'s commitment to safety and the individual attention given to each student. The bilingual education is preparing our child for global opportunities.', '/testimonials/parent-3.jpg', 5, 0, 'active', '2025-11-28 14:54:03', '2025-11-29 10:08:51'),
(4, 'Robert Brown', 'Parent of Grade 2 Student', 'The teachers at Mount Carmel are exceptional. They truly care about each student\'s success and provide personalized support when needed.', '/testimonials/parent-4.jpg', 4, 0, 'active', '2025-11-28 14:54:03', '2025-11-29 10:08:51'),
(5, 'Maria Garcia', 'Parent of Grade 4 Student', 'The school\'s facilities are outstanding, and the extracurricular activities have helped my child discover new interests and talents.', '/testimonials/parent-5.jpg', 5, 0, 'active', '2025-11-28 14:54:03', '2025-11-29 10:08:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT 'default-profile.jpg',
  `role_id` int(11) NOT NULL,
  `status` enum('active','inactive','pending','suspended') DEFAULT 'pending',
  `last_login` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reset_token` varchar(10) DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `phone`, `username`, `password`, `photo`, `role_id`, `status`, `last_login`, `created_by`, `created_at`, `updated_at`, `reset_token`, `reset_expiry`) VALUES
(1, 'BAHATI', 'Gerchom', 'info@mountcarmel.ac.rw', '250787254817', 'superadmin', '$2y$10$U8MPqa6EFv0sKwCuUKY/sOJoBLgkbsiBlSZ4q1p4aeS84IdoDdKyq', 'default-profile.jpg', 1, 'active', '2025-12-15 16:33:02', NULL, '2025-12-09 16:32:49', '2025-12-15 14:33:02', NULL, NULL),
(3, 'Admin', 'User', 'aba1remy@gmail.com', '1234567890', 'admin', '$2y$10$cTKQFPz493I5.QQkU1MwzOW.YLOdQKqnHbWzpsnO13eI54jLUnCt6', 'default-profile.jpg', 1, 'active', '2025-12-15 09:50:13', 1, '2025-12-10 08:07:50', '2025-12-15 07:50:13', '949474', '2025-12-13 09:47:31'),
(4, 'Cathy', 'Den', 'info.abaremy@gmail.com', '250721053807', 'info.abaremy@gmail.com', '$2y$10$tRnGp6vT61jeg1ryn9FwcOD6CJ645S.ppvpAL4DP2.f7jLx9k.iR6', 'default-profile.jpg', 3, 'pending', NULL, 1, '2025-12-11 12:13:07', '2025-12-11 12:13:07', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `display_order` (`display_order`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `hero_sliders`
--
ALTER TABLE `hero_sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_events`
--
ALTER TABLE `news_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `published_date` (`published_date`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `page_content`
--
ALTER TABLE `page_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_section_unique` (`page_name`,`section_name`),
  ADD KEY `status` (`status`),
  ADD KEY `display_order` (`display_order`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_unique` (`module`,`action`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_permission_unique` (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `created_by` (`created_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `hero_sliders`
--
ALTER TABLE `hero_sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news_events`
--
ALTER TABLE `news_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `page_content`
--
ALTER TABLE `page_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
