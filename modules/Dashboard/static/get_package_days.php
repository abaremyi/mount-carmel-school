<?php
require_once '../../../helpers/JWTHandler.php';
require_once '../../../config/database.php';

header('Content-Type: application/json');

// Authentication check (same as above)
// ...

$packageId = $_GET['package_id'] ?? 0;
$db = Database::getInstance();

try {
    // Get package info
    $stmt = $db->prepare("SELECT * FROM tourism_packages WHERE id = ?");
    $stmt->execute([$packageId]);
    $package = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$package) {
        http_response_code(404);
        die(json_encode(['error' => 'Package not found']));
    }
    
    // Get package days
    $stmt = $db->prepare("SELECT * FROM package_days WHERE package_id = ? ORDER BY day_number");
    $stmt->execute([$packageId]);
    $days = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'package' => $package,
        'days' => $days
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
}