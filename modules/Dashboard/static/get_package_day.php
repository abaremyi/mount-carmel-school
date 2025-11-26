<?php
require_once '../../../helpers/JWTHandler.php';
require_once '../../../config/database.php';

header('Content-Type: application/json');

// Authentication check (same as above)
// ...

$dayId = $_GET['id'] ?? 0;
$db = Database::getInstance();

try {
    $stmt = $db->prepare("SELECT * FROM package_days WHERE id = ?");
    $stmt->execute([$dayId]);
    $day = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$day) {
        http_response_code(404);
        die(json_encode(['error' => 'Day not found']));
    }
    
    echo json_encode(['day' => $day]);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
}