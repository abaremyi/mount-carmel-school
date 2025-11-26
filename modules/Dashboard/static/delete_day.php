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

$dayId = $_POST['id'] ?? 0;
$db = Database::getInstance();

try {
    // First delete the day image
    $stmt = $db->prepare("SELECT image FROM package_days WHERE id = ?");
    $stmt->execute([$dayId]);
    $imagePath = $stmt->fetchColumn();
    
    if ($imagePath && file_exists('../../../assets/image/' . $imagePath)) {
        unlink('../../../assets/image/' . $imagePath);
    }
    
    // Delete the day
    $stmt = $db->prepare("DELETE FROM package_days WHERE id = ?");
    $stmt->execute([$dayId]);
    
    echo json_encode(['message' => 'Day deleted successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
}