<?php
require_once '../../../config/database.php';

header('Content-Type: application/json');

// Get the region parameter from the request
$region = $_GET['region'] ?? 'rwanda';
$validRegions = ['rwanda', 'east_africa'];

// Validate the region parameter
if (!in_array($region, $validRegions)) {
    $region = 'rwanda';
}

// Initialize database
$db = Database::getInstance();

try {
    // Prepare and execute the query with region filter
    $stmt = $db->prepare("SELECT * FROM tourism_packages 
                         WHERE is_active = TRUE AND region = ? 
                         ORDER BY display_order");
    $stmt->execute([$region]);
    $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the packages as JSON
    echo json_encode([
        'success' => true,
        'packages' => $packages
    ]);
    
} catch (PDOException $e) {
    // Handle database errors
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}