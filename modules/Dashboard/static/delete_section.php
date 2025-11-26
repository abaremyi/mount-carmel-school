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

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['section_id'])) {
    http_response_code(400);
    die(json_encode(['error' => 'Bad request']));
}

$db = Database::getInstance();
$sectionId = $_POST['section_id'];

try {
    // Get the section order and content ID first
    $stmt = $db->prepare("SELECT tourism_content_id, section_order FROM tourism_sections WHERE id = ?");
    $stmt->execute([$sectionId]);
    $section = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$section) {
        http_response_code(404);
        die(json_encode(['error' => 'Section not found']));
    }
    
    // Begin transaction
    $db->beginTransaction();
    
    // Delete the section
    $stmt = $db->prepare("DELETE FROM tourism_sections WHERE id = ?");
    $stmt->execute([$sectionId]);
    
    // Update the order of remaining sections
    $stmt = $db->prepare("UPDATE tourism_sections SET section_order = section_order - 1 WHERE tourism_content_id = ? AND section_order > ?");
    $stmt->execute([$section['tourism_content_id'], $section['section_order']]);
    
    $db->commit();
    
    echo json_encode(['message' => 'Section deleted successfully']);
} catch (PDOException $e) {
    $db->rollBack();
    http_response_code(500);
    die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
}