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

$currentPage = isset($_GET['page']) ? $_GET['page'] : 'adventure';
$validPages = ['adventure', 'craft', 'museum', 'why', 'how'];

if (!in_array($currentPage, $validPages)) {
    $currentPage = 'adventure';
}

$db = Database::getInstance();

// Fetch page data
$stmt = $db->prepare("SELECT * FROM tourism_content WHERE page_key = ?");
$stmt->execute([$currentPage]);
$pageData = $stmt->fetch(PDO::FETCH_ASSOC);

$response = [
    'page' => $pageData,
    'sections' => []
];

if ($pageData) {
    // Fetch sections
    $stmt = $db->prepare("SELECT * FROM tourism_sections WHERE tourism_content_id = ? ORDER BY section_order ASC");
    $stmt->execute([$pageData['id']]);
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($sections as &$section) {
        $stmt = $db->prepare("SELECT * FROM tourism_features WHERE tourism_section_id = ? ORDER BY feature_order ASC");
        $stmt->execute([$section['id']]);
        $section['features'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    $response['sections'] = $sections;
}

echo json_encode($response);