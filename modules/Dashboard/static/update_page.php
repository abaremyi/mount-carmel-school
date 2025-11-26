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
    $pageId = $_POST['page_id'];
    $title = $_POST['title'] ?? '';
    
    // Handle file upload
    $heroImage = null;
    if (isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] == 0) {
        $uploadDir = '../../../assets/image/';
        $fileExt = strtolower(pathinfo($_FILES['hero_image']['name'], PATHINFO_EXTENSION));
        $fileName = 'Hero_' . time() . '_' . uniqid() . '.' . $fileExt;
        $targetPath = $uploadDir . $fileName;
        
        // Validate file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['hero_image']['tmp_name'], $targetPath)) {
                $heroImage = $fileName;
                
                // Delete old image if exists
                $stmt = $db->prepare("SELECT hero_image FROM tourism_content WHERE id = ?");
                $stmt->execute([$pageId]);
                $oldImage = $stmt->fetchColumn();
                
                if ($oldImage && file_exists($uploadDir . $oldImage)) {
                    unlink($uploadDir . $oldImage);
                }
            }
        }
    }
    
    // Update database
    if ($heroImage) {
        $stmt = $db->prepare("UPDATE tourism_content SET title = ?, hero_image = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$title, $heroImage, $pageId]);
    } else {
        $stmt = $db->prepare("UPDATE tourism_content SET title = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$title, $pageId]);
    }
    
    echo json_encode(['message' => 'Page updated successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
}