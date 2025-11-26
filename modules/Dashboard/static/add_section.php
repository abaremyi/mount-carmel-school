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
    $contentId = $_POST['content_id'];
    $title = $_POST['new_section_title'] ?? null;
    $content = $_POST['new_section_content'] ?? '';
    
    // Get the next section order
    $stmt = $db->prepare("SELECT MAX(section_order) as max_order FROM tourism_sections WHERE tourism_content_id = ?");
    $stmt->execute([$contentId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $order = ($result['max_order'] ?? 0) + 1;
    
    // Handle file upload
    $imagePath = null;
    if (isset($_FILES['new_section_image']) && $_FILES['new_section_image']['error'] == 0) {
        $uploadDir = '../../../assets/image/';
        // $fileName = time() . '_' . basename($_FILES['new_section_image']['name']);
        $fileExt = strtolower(pathinfo($_FILES['new_section_image']['name'], PATHINFO_EXTENSION));
        $fileName = 'SCTN_' . time() . '_' . uniqid() . '.' . $fileExt;
        $targetPath = $uploadDir . $fileName;
        
        // Validate file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['new_section_image']['tmp_name'], $targetPath)) {
                $imagePath = $fileName;
            }
        }
    }
    
    // Insert new section
    $stmt = $db->prepare("INSERT INTO tourism_sections (tourism_content_id, section_order, title, content, image_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$contentId, $order, $title, $content, $imagePath]);
    $sectionId = $db->lastInsertId();
    
    // Handle features if they exist (for why/how pages)
    if (isset($_POST['feature_text'])) {
        foreach ($_POST['feature_text'] as $index => $text) {
            if (!empty(trim($text))) {
                $order = $index + 1;
                $stmt = $db->prepare("INSERT INTO tourism_features (tourism_section_id, feature_text, feature_order) VALUES (?, ?, ?)");
                $stmt->execute([$sectionId, trim($text), $order]);
            }
        }
    }
    
    echo json_encode(['message' => 'Section added successfully', 'section_id' => $sectionId]);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
}