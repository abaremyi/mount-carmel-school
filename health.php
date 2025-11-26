<?php
header('Content-Type: application/json');

try {
    // Test database connection
    require_once 'config/database.php';
    $db = Database::getConnection();
    
    // Test if we can query
    $stmt = $db->query("SELECT 1");
    $db_test = $stmt->fetch();
    
    echo json_encode([
        'status' => 'healthy',
        'database' => 'connected',
        'timestamp' => date('c')
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'unhealthy',
        'error' => $e->getMessage(),
        'timestamp' => date('c')
    ]);
}