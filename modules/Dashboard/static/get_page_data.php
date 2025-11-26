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

echo json_encode([
    'page' => $pageData
]);