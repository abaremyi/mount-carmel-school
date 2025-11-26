<?php
/**
 * Database Import Script for Railway
 * Run this once after deployment to import your data
 */

// Only allow in production environment
if (!getenv('RAILWAY_ENVIRONMENT')) {
    die('This script can only run in production environment.');
}

// Simple security check
$token = $_GET['token'] ?? '';
if ($token !== 'import123') {
    die('Invalid token');
}

require_once '../config/paths.php';
require_once '../config/database.production.php';

try {
    $db = Database::getConnection();
    
    echo "<h2>Starting Database Import...</h2>";
    
    // Your SQL from the export
    $sql = "
    -- Drop tables if they exist
    DROP TABLE IF EXISTS `gallery_images`;
    DROP TABLE IF EXISTS `news_events`;

    -- Table structure for table `gallery_images`
    CREATE TABLE `gallery_images` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `description` text DEFAULT NULL,
      `image_url` varchar(500) NOT NULL,
      `thumbnail_url` varchar(500) DEFAULT NULL,
      `category` varchar(100) DEFAULT 'general',
      `display_order` int(11) DEFAULT 0,
      `status` enum('active','inactive') DEFAULT 'active',
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`),
      KEY `status` (`status`),
      KEY `display_order` (`display_order`),
      KEY `category` (`category`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    -- Dumping data for table `gallery_images`
    INSERT INTO `gallery_images` (`id`, `title`, `description`, `image_url`, `thumbnail_url`, `category`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
    (1, 'Classroom Activities', 'Students engaged in interactive learning', '/img/gallery/classroom-1.jpg', NULL, 'academics', 1, 'active', '2025-11-25 20:52:49', '2025-11-25 20:52:49'),
    (2, 'Science Laboratory', 'Modern science lab facilities', '/img/gallery/lab-1.jpg', NULL, 'facilities', 2, 'active', '2025-11-25 20:52:49', '2025-11-25 20:52:49'),
    (3, 'Sports Day Event', 'Annual sports day celebration', '/img/gallery/sports-1.jpg', NULL, 'events', 3, 'active', '2025-11-25 20:52:49', '2025-11-25 20:52:49'),
    (4, 'Library Study', 'Students reading in our library', '/img/gallery/library-1.jpg', NULL, 'facilities', 4, 'active', '2025-11-25 20:52:49', '2025-11-25 20:52:49'),
    (5, 'Music Class', 'Learning musical instruments', '/img/gallery/music-1.jpg', NULL, 'extracurricular', 5, 'active', '2025-11-25 20:52:49', '2025-11-25 20:52:49'),
    (6, 'Art Exhibition', 'Student artwork display', '/img/gallery/art-1.jpg', NULL, 'events', 6, 'active', '2025-11-25 20:52:49', '2025-11-25 20:52:49'),
    (7, 'Computer Lab', 'Technology-equipped learning space', '/img/gallery/computer-1.jpg', NULL, 'facilities', 7, 'active', '2025-11-25 20:52:49', '2025-11-25 20:52:49'),
    (8, 'Graduation Ceremony', 'Annual graduation celebration', '/img/gallery/graduation-1.jpg', NULL, 'events', 8, 'active', '2025-11-25 20:52:49', '2025-11-25 20:52:49'),
    (9, 'Playground Activities', 'Students enjoying outdoor time', '/img/gallery/playground-1.jpg', NULL, 'campus', 9, 'active', '2025-11-25 20:52:49', '2025-11-25 20:52:49'),
    (10, 'Assembly Hall', 'Morning assembly gathering', '/img/gallery/assembly-1.jpg', NULL, 'campus', 10, 'active', '2025-11-25 20:52:49', '2025-11-25 20:52:49');

    -- Table structure for table `news_events`
    CREATE TABLE `news_events` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `excerpt` text DEFAULT NULL,
      `description` longtext NOT NULL,
      `image_url` varchar(500) NOT NULL,
      `thumbnail_url` varchar(500) DEFAULT NULL,
      `category` enum('news','event','announcement','achievement') DEFAULT 'news',
      `author` varchar(100) DEFAULT NULL,
      `published_date` date NOT NULL,
      `status` enum('draft','published','archived') DEFAULT 'draft',
      `views` int(11) DEFAULT 0,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`),
      KEY `status` (`status`),
      KEY `published_date` (`published_date`),
      KEY `category` (`category`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    -- Dumping data for table `news_events`
    INSERT INTO `news_events` (`id`, `title`, `excerpt`, `description`, `image_url`, `thumbnail_url`, `category`, `author`, `published_date`, `status`, `views`, `created_at`, `updated_at`) VALUES
    (1, 'Annual Sports Day 2024', 'Join us for our exciting Annual Sports Day featuring various competitions and activities for all students.', 'Our Annual Sports Day is a celebration of athleticism, teamwork, and school spirit. Students from all grades participate in various sporting events including track and field, basketball, football, and many more. This year promises to be even more exciting with new activities and competitions. Parents and guardians are warmly invited to attend and cheer for their children.', '/img/news/news-1.jpg', NULL, 'event', 'Admin', '2024-12-15', 'published', 0, '2025-11-25 21:57:33', '2025-11-25 21:57:33'),
    (2, 'Science Fair Winners', 'Congratulations to our students who won top prizes at the Regional Science Fair competition.', 'We are proud to announce that our students have excelled at the Regional Science Fair, bringing home multiple awards including first place in the Biology category and second place in Physics. Their innovative projects and dedication to scientific inquiry have made Mount Carmel School proud. Special congratulations to Sarah Mugisha, John Kamanzi, and their team members for their outstanding achievements.', '/img/news/news-2.jpg', NULL, 'achievement', 'Admin', '2024-12-10', 'published', 0, '2025-11-25 21:57:33', '2025-11-25 21:57:33'),
    (3, 'Parent-Teacher Meeting', 'Quarterly parent-teacher meeting scheduled to discuss student progress and development.', 'We invite all parents to attend our quarterly parent-teacher meeting where we will discuss student progress, upcoming events, and ways parents can support their children\\'s learning at home. This is an excellent opportunity to meet with teachers, understand your child\\'s academic journey, and participate in planning for the next term. Refreshments will be served.', '/img/news/news-3.jpg', NULL, 'announcement', 'Admin', '2024-12-05', 'published', 0, '2025-11-25 21:57:33', '2025-11-25 21:57:33'),
    (4, 'New Library Inauguration', 'Our new state-of-the-art library has been officially inaugurated with over 5000 books.', 'Mount Carmel School is proud to announce the inauguration of our new library facility, equipped with modern amenities, comfortable reading spaces, and over 5,000 books covering various subjects and interests. The library features dedicated sections for different age groups, computer stations for research, and quiet study areas. We thank all our donors and supporters who made this project possible.', '/img/news/news-4.jpg', NULL, 'news', 'Admin', '2024-11-28', 'published', 0, '2025-11-25 21:57:33', '2025-11-25 21:57:33');
    ";

    // Split SQL by semicolons, but be careful with triggers/procedures
    $queries = array_filter(array_map('trim', explode(';', $sql)));
    
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($queries as $query) {
        if (!empty($query)) {
            try {
                $db->exec($query);
                $successCount++;
                echo "<p style='color: green;'>✓ Executed: " . substr($query, 0, 50) . "...</p>";
            } catch (Exception $e) {
                $errorCount++;
                echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
            }
        }
    }
    
    echo "<h3>Import Complete: $successCount successful, $errorCount errors</h3>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Fatal Error: " . $e->getMessage() . "</p>";
}
?>