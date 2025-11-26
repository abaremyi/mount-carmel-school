<?php
require_once '../../../helpers/JWTHandler.php';
require_once '../../../config/database.php';

header('Content-Type: application/json');

// Authentication check (same as above)
// ...

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    die(json_encode(['error' => 'Bad request']));
}

$db = Database::getInstance();

try {
    $packageId = $_POST['package_id'] ?? 0;
    $dayNumber = $_POST['day_number'] ?? 1;
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $displayOrder = $_POST['display_order'] ?? 0;
    
    // Handle file upload
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = '../../../assets/image/';
        $fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $fileName = 'DAY_' . time() . '_' . uniqid() . '.' . $fileExt;
        $targetPath = $uploadDir . $fileName;
        
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($fileExt, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = $fileName;
            }
        }
    }
    
    if (empty($imagePath)) {
        http_response_code(400);
        die(json_encode(['error' => 'Valid image file is required']));
    }
    
    $stmt = $db->prepare("INSERT INTO package_days 
                         (package_id, day_number, title, description, image, display_order) 
                         VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$packageId, $dayNumber, $title, $description, $imagePath, $displayOrder]);
    
    echo json_encode(['message' => 'Day added successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
}