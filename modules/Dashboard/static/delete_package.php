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

$packageId = $_POST['id'] ?? 0;
$db = Database::getInstance();

try {
    // First delete the package image
    $stmt = $db->prepare("SELECT main_image FROM tourism_packages WHERE id = ?");
    $stmt->execute([$packageId]);
    $imagePath = $stmt->fetchColumn();
    
    if ($imagePath && file_exists('../../../assets/image/' . $imagePath)) {
        unlink('../../../assets/image/' . $imagePath);
    }
    
    // Delete the package (cascade will delete package days)
    $stmt = $db->prepare("DELETE FROM tourism_packages WHERE id = ?");
    $stmt->execute([$packageId]);
    
    echo json_encode(['message' => 'Package deleted successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
}