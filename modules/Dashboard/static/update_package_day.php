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
    $dayId = $_POST['id'] ?? 0;
    $packageId = $_POST['package_id'] ?? 0;
    $dayNumber = $_POST['day_number'] ?? 1;
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $displayOrder = $_POST['display_order'] ?? 0;
    
    // Handle file upload if new image was provided
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = '../../../assets/image/';
        $fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $fileName = 'DAY_' . time() . '_' . uniqid() . '.' . $fileExt;
        $targetPath = $uploadDir . $fileName;
        
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($fileExt, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = $fileName;
                
                // Delete old image if exists
                $stmt = $db->prepare("SELECT image FROM package_days WHERE id = ?");
                $stmt->execute([$dayId]);
                $oldImage = $stmt->fetchColumn();
                
                if ($oldImage && file_exists($uploadDir . $oldImage)) {
                    unlink($uploadDir . $oldImage);
                }
            }
        }
    }
    
    // Update day in database
    if ($imagePath) {
        $stmt = $db->prepare("UPDATE package_days 
                             SET package_id = ?, day_number = ?, title = ?, 
                                 description = ?, image = ?, display_order = ?, 
                                 updated_at = NOW() 
                             WHERE id = ?");
        $stmt->execute([$packageId, $dayNumber, $title, $description, $imagePath, $displayOrder, $dayId]);
    } else {
        $stmt = $db->prepare("UPDATE package_days 
                             SET package_id = ?, day_number = ?, title = ?, 
                                 description = ?, display_order = ?, 
                                 updated_at = NOW() 
                             WHERE id = ?");
        $stmt->execute([$packageId, $dayNumber, $title, $description, $displayOrder, $dayId]);
    }
    
    echo json_encode(['message' => 'Day updated successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
}