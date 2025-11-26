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

$db = Database::getInstance();

try {
    $stmt = $db->query("SELECT * FROM tourism_packages ORDER BY display_order, title");
    $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['packages' => $packages]);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
}