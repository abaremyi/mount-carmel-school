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
    $packageId = $_POST['id'] ?? 0;
    $title = $_POST['title'] ?? '';
    $shortDescription = $_POST['short_description'] ?? '';
    $durationDays = $_POST['duration_days'] ?? 1;
    $displayOrder = $_POST['display_order'] ?? 0;
    $isActive = isset($_POST['is_active']) ? 1 : 0;
    $region = $_POST['region'] ?? 'rwanda';
    
    // Validate region
    $validRegions = ['rwanda', 'east_africa'];
    if (!in_array($region, $validRegions)) {
        $region = 'rwanda';
    }

    // Handle file upload if new image was provided
    $imagePath = null;
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        $uploadDir = '../../../assets/image/';
        $fileExt = strtolower(pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION));
        $fileName = 'PKG_' . time() . '_' . uniqid() . '.' . $fileExt;
        $targetPath = $uploadDir . $fileName;
        
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($fileExt, $allowedTypes)) {
            if (move_uploaded_file($_FILES['main_image']['tmp_name'], $targetPath)) {
                $imagePath = $fileName;
                
                // Delete old image if exists
                $stmt = $db->prepare("SELECT main_image FROM tourism_packages WHERE id = ?");
                $stmt->execute([$packageId]);
                $oldImage = $stmt->fetchColumn();
                
                if ($oldImage && file_exists($uploadDir . $oldImage)) {
                    unlink($uploadDir . $oldImage);
                }
            }
        }
    }
    
    // Update package in database
    if ($imagePath) {
        $stmt = $db->prepare("UPDATE tourism_packages 
                             SET title = ?, short_description = ?, main_image = ?, 
                                 duration_days = ?, display_order = ?, is_active = ?,
                                 region = ?, updated_at = NOW() 
                             WHERE id = ?");
        $stmt->execute([
            $title, 
            $shortDescription, 
            $imagePath, 
            $durationDays, 
            $displayOrder, 
            $isActive,
            $region,
            $packageId
        ]);
    } else {
        $stmt = $db->prepare("UPDATE tourism_packages 
                             SET title = ?, short_description = ?, 
                                 duration_days = ?, display_order = ?, is_active = ?,
                                 region = ?, updated_at = NOW() 
                             WHERE id = ?");
        $stmt->execute([
            $title, 
            $shortDescription, 
            $durationDays, 
            $displayOrder, 
            $isActive,
            $region,
            $packageId
        ]);
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Package updated successfully',
        'package' => [
            'id' => $packageId,
            'title' => $title,
            'region' => $region
        ]
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}