<?php
// Include path helper and database
$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . "/config/paths.php";
require_once $root_path . "/config/database.php";

header('Content-Type: application/json');

try {
    $db = Database::getInstance();
    $projectId = $_GET['project_id'] ?? 0;
    $category = $_GET['category'] ?? '';
    $industry = $_GET['industry'] ?? '';
    
    $query = "SELECT * FROM projects WHERE projid != ? AND status != 'archived'";
    $params = [$projectId];
    
    if (!empty($category) && $category != 'all') {
        $query .= " AND category = ?";
        $params[] = $category;
    }
    
    if (!empty($industry) && $industry != 'all') {
        $query .= " AND industry = ?";
        $params[] = $industry;
    }
    
    $query .= " ORDER BY created_at DESC LIMIT 3";
    
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $html = '';
    if (count($projects) > 0) {
        foreach ($projects as $project) {
            $html .= '
            <div class="col-lg-4 col-md-6 mb-30">
                <div class="item">
                    <figure>
                        <img src="' . img_url('projects/' . htmlspecialchars($project['image_path'])) . '" alt="' . htmlspecialchars($project['title']) . '" class="img-fluid">
                    </figure>
                    <div class="content">
                        <div class="cont">
                            <h5>' . htmlspecialchars($project['title']) . '</h5>
                            <p>' . htmlspecialchars(substr($project['short_description'], 0, 100)) . '...</p>
                            <div class="book">
                                <a href="' . url('project-details?project=' . urlencode($project['projid'])) . '" class="button-4">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
    } else {
        $html = '<div class="col-md-12 text-center"><p>No related projects found.</p></div>';
    }
    
    echo json_encode([
        'success' => true,
        'html' => $html
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>