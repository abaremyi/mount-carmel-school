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
    $sectionId = $_POST['section_id'];
    $title = $_POST['section_title'] ?? null;
    $content = $_POST['section_content'] ?? '';
    
    // Handle file upload if new image was provided
    $imagePath = null;
    if (isset($_FILES['section_image']) && $_FILES['section_image']['error'] == 0) {
        $uploadDir = '../../../assets/image/';
        // $fileName = time() . '_' . basename($_FILES['section_image']['name']);
        $fileExt = strtolower(pathinfo($_FILES['section_image']['name'], PATHINFO_EXTENSION));
        $fileName = 'SCTN_' . time() . '_' . uniqid() . '.' . $fileExt;
        $targetPath = $uploadDir . $fileName;
        
        // Validate file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['section_image']['tmp_name'], $targetPath)) {
                $imagePath = $fileName;
                
                // Delete old image if exists
                $stmt = $db->prepare("SELECT image_path FROM tourism_sections WHERE id = ?");
                $stmt->execute([$sectionId]);
                $oldImage = $stmt->fetchColumn();
                
                if ($oldImage && file_exists($uploadDir . $oldImage)) {
                    unlink($uploadDir . $oldImage);
                }
            }
        }
    }
    
    // Update section in database
    if ($imagePath) {
        $stmt = $db->prepare("UPDATE tourism_sections SET title = ?, content = ?, image_path = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$title, $content, $imagePath, $sectionId]);
    } else {
        $stmt = $db->prepare("UPDATE tourism_sections SET title = ?, content = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$title, $content, $sectionId]);
    }
    
    // Handle features if they exist (for why/how pages)
    if (isset($_POST['feature_text'])) {
        $featureTexts = $_POST['feature_text'];
        $featureIds = $_POST['feature_id'] ?? [];
        
        // First delete features not in the current list
        if (!empty($featureIds)) {
            $placeholders = implode(',', array_fill(0, count($featureIds), '?'));
            $stmt = $db->prepare("DELETE FROM tourism_features WHERE tourism_section_id = ? AND id NOT IN ($placeholders)");
            $params = array_merge([$sectionId], $featureIds);
            $stmt->execute($params);
        } else {
            $stmt = $db->prepare("DELETE FROM tourism_features WHERE tourism_section_id = ?");
            $stmt->execute([$sectionId]);
        }
        
        // Update or insert features
        foreach ($featureTexts as $index => $text) {
            $featureId = $featureIds[$index] ?? null;
            $order = $index + 1;
            
            if ($featureId) {
                $stmt = $db->prepare("UPDATE tourism_features SET feature_text = ?, feature_order = ? WHERE id = ?");
                $stmt->execute([$text, $order, $featureId]);
            } else {
                $stmt = $db->prepare("INSERT INTO tourism_features (tourism_section_id, feature_text, feature_order) VALUES (?, ?, ?)");
                $stmt->execute([$sectionId, $text, $order]);
            }
        }
    }
    
    echo json_encode(['message' => 'Section updated successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
}