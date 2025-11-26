<?php
// Include path helper and database
$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . "/config/paths.php";
require_once $root_path . "/config/database.php";

header('Content-Type: application/json');

try {
    $db = Database::getInstance();
    $projectId = $_GET['project_id'] ?? 0;
    
    $images = [];
    
    // First, get project main image
    $stmt = $db->prepare("SELECT image_path FROM projects WHERE projid = ?");
    $stmt->execute([$projectId]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Add main project image as first image
    if ($project && !empty($project['image_path'])) {
        $images[] = [
            'url' => img_url('projects/' . $project['image_path']),
            'alt' => 'Main Project Image',
            'type' => 'main'
        ];
    }
    
    // Get additional pictures from pictures table
    $stmt = $db->prepare("SELECT * FROM pictures WHERE projid = ? AND status = 'active' ORDER BY picid ASC");
    $stmt->execute([$projectId]);
    $pictures = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Add additional pictures
    foreach ($pictures as $picture) {
        $images[] = [
            'url' => img_url('projects/' . $picture['url']),
            'alt' => $picture['alt_text'] ?? 'Project Image',
            'type' => 'gallery'
        ];
    }
    
    // If no images found, use default
    if (empty($images)) {
        $images[] = [
            'url' => img_url('projects/default.jpg'),
            'alt' => 'Project Image',
            'type' => 'default'
        ];
    }
    
    echo json_encode([
        'success' => true,
        'images' => $images,
        'total' => count($images),
        'hasMultiple' => count($images) > 1
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>