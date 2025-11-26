<?php
require_once '../../../helpers/JWTHandler.php';
require_once '../../../config/database.php';

header('Content-Type: application/json');

// Authentication check
if (!isset($_COOKIE['jwtToken'])) {
    http_response_code(401);
    die(json_encode(['error' => 'Unauthorized']));
}

$jwtHandler = new JWTHandler();
$decodedToken = $jwtHandler->validateToken($_COOKIE['jwtToken']);

if ($decodedToken === false) {
    http_response_code(401);
    die(json_encode(['error' => 'Unauthorized']));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    die(json_encode(['error' => 'Bad request']));
}

$db = Database::getInstance();

try {
    // Get and validate input data
    $title = trim($_POST['title'] ?? '');
    $shortDescription = trim($_POST['short_description'] ?? '');
    $durationDays = intval($_POST['duration_days'] ?? 1);
    $displayOrder = intval($_POST['display_order'] ?? 0);
    $isActive = isset($_POST['is_active']) ? 1 : 0;
    $region = $_POST['region'] ?? 'rwanda';
    
    // Validate required fields
    if (empty($title) || empty($shortDescription)) {
        http_response_code(400);
        die(json_encode(['error' => 'Title and description are required']));
    }
    
    // Validate region
    $validRegions = ['rwanda', 'east_africa'];
    if (!in_array($region, $validRegions)) {
        $region = 'rwanda';
    }

    // Handle file upload
    $imagePath = '';
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        $uploadDir = '../../../assets/image/';
        $fileExt = strtolower(pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION));
        $fileName = 'PKG_' . time() . '_' . uniqid() . '.' . $fileExt;
        $targetPath = $uploadDir . $fileName;
        
        // Validate file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($fileExt, $allowedTypes)) {
            http_response_code(400);
            die(json_encode(['error' => 'Only JPG, PNG, GIF, and WEBP images are allowed']));
        }
        
        // Validate file size (max 5MB)
        if ($_FILES['main_image']['size'] > 5242880) {
            http_response_code(400);
            die(json_encode(['error' => 'Image size must be less than 5MB']));
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES['main_image']['tmp_name'], $targetPath)) {
            $imagePath = $fileName;
        } else {
            http_response_code(500);
            die(json_encode(['error' => 'Failed to upload image']));
        }
    }
    
    if (empty($imagePath)) {
        http_response_code(400);
        die(json_encode(['error' => 'Valid image file is required']));
    }
    
    // Insert new package
    $stmt = $db->prepare("INSERT INTO tourism_packages 
                         (title, short_description, main_image, duration_days, 
                          display_order, is_active, region) 
                         VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $title, 
        $shortDescription, 
        $imagePath, 
        $durationDays, 
        $displayOrder, 
        $isActive,
        $region
    ]);
    
    $packageId = $db->lastInsertId();
    
    // Return success response with package data
    echo json_encode([
        'success' => true,
        'message' => 'Package added successfully',
        'package' => [
            'id' => $packageId,
            'title' => $title,
            'region' => $region,
            'image' => $imagePath
        ]
    ]);
    
} catch (PDOException $e) {
    // Clean up uploaded file if database insert failed
    if (!empty($imagePath) && file_exists($uploadDir . $imagePath)) {
        unlink($uploadDir . $imagePath);
    }
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}