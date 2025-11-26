<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Add CORS headers for debugging
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

// Include path helper and database
$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . "/config/paths.php";
require_once $root_path . "/config/database.php";

try {
    // Log the request for debugging
    error_log("AJAX Request Received: " . print_r($_GET, true));
    
    $db = Database::getInstance();
    
    // Get parameters with defaults
    $search = $_GET['search'] ?? '';
    $status = $_GET['status'] ?? 'all';
    $category = $_GET['category'] ?? 'all';
    $industry = $_GET['industry'] ?? 'all';
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $perPage = isset($_GET['per_page']) ? intval($_GET['per_page']) : 6;
    
    // Validate page number
    if ($page < 1) $page = 1;
    
    // Calculate offset
    $offset = ($page - 1) * $perPage;
    
    // Build query
    $whereConditions = ["status != 'archived'"];
    $params = [];
    
    if (!empty($search)) {
        $whereConditions[] = "(title LIKE ? OR description LIKE ? OR short_description LIKE ?)";
        $searchTerm = "%" . $search . "%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }
    
    if ($status != 'all') {
        $whereConditions[] = "status = ?";
        $params[] = $status;
    }
    
    if ($category != 'all') {
        $whereConditions[] = "category = ?";
        $params[] = $category;
    }
    
    if ($industry != 'all') {
        $whereConditions[] = "industry = ?";
        $params[] = $industry;
    }
    
    $whereClause = implode(" AND ", $whereConditions);
    
    error_log("Where Clause: " . $whereClause);
    error_log("Params: " . print_r($params, true));
    
    // Count total projects
    $countQuery = "SELECT COUNT(*) as total FROM projects WHERE $whereClause";
    error_log("Count Query: " . $countQuery);
    
    $countStmt = $db->prepare($countQuery);
    $countStmt->execute($params);
    $totalProjects = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalProjects / $perPage);
    
    error_log("Total Projects: " . $totalProjects);
    error_log("Total Pages: " . $totalPages);
    
    // Get projects for current page
    $query = "SELECT * FROM projects WHERE $whereClause ORDER BY created_at DESC LIMIT $perPage OFFSET $offset";
    
    error_log("Main Query: " . $query);
    error_log("Final Params: " . print_r($params, true));
    
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    error_log("Projects Found: " . count($projects));
    
    // Generate HTML
    $html = '';
    if (count($projects) > 0) {
        foreach ($projects as $project) {
            // Status badge class
            $statusClass = '';
            $statusText = '';
            switch ($project['status']) {
                case 'completed':
                    $statusClass = 'completed';
                    $statusText = 'Completed';
                    break;
                case 'in_progress':
                    $statusClass = 'pending';
                    $statusText = 'In Progress';
                    break;
                case 'under_development':
                    $statusClass = 'development';
                    $statusText = 'Development';
                    break;
                case 'planning':
                    $statusClass = 'planning';
                    $statusText = 'Planning';
                    break;
                default:
                    $statusClass = 'planning';
                    $statusText = ucfirst(str_replace('_', ' ', $project['status']));
            }
            
            // Category icon
            $categoryIcon = 'ti-briefcase';
            switch ($project['category']) {
                case 'website_development':
                    $categoryIcon = 'ti-world';
                    break;
                case 'ecommerce':
                    $categoryIcon = 'ti-shopping-cart';
                    break;
                case 'mobile_app':
                    $categoryIcon = 'ti-mobile';
                    break;
                case 'enterprise_solution':
                    $categoryIcon = 'ti-server';
                    break;
                case 'charity':
                    $categoryIcon = 'ti-hand-open';
                    break;
                case 'education':
                    $categoryIcon = 'ti-book';
                    break;
            }

            // Check if preview is allowed
            $previewAllowed = ($project['preview'] == 1 || $project['preview'] == 'allowed') && !empty($project['project_url']);
            $previewClass = $previewAllowed ? 'btn-secondary' : 'btn-disabled';
            $previewHref = $previewAllowed ? 'href="' . htmlspecialchars($project['project_url']) . '" target="_blank"' : '';
            $previewOnclick = $previewAllowed ? '' : 'onclick="return false;"';

            $html .= '
            <div class="col-lg-4 col-md-6 mb-30">
                <div class="project-card">
                    <div class="project-image">
                        <img src="' . img_url('projects/' . htmlspecialchars($project['image_path'] ?? 'default.jpg')) . '" alt="' . htmlspecialchars($project['title']) . '">
                        <div class="status-badge ' . $statusClass . '">' . $statusText . '</div>
                    </div>
                    <div class="project-content">
                        <h4 class="project-title">' . htmlspecialchars($project['title']) . '</h4>
                        
                        <div class="project-meta">
                            <i class="' . $categoryIcon . '"></i>
                            <span>' . ucfirst(str_replace('_', ' ', $project['category'])) . '</span>
                        </div>
                        
                        <div class="project-meta">
                            <i class="ti-briefcase"></i>
                            <span>' . ucfirst(str_replace('_', ' ', $project['industry'] ?? 'Not specified')) . '</span>
                        </div>
                        
                        <div class="project-meta">
                            <i class="ti-calendar"></i>
                            <span>';
            
            if (!empty($project['launch_date']) && $project['launch_date'] != '0000-00-00') {
                $html .= 'Launched: ' . date('Y', strtotime($project['launch_date']));
            } elseif (!empty($project['expected_date']) && $project['expected_date'] != '0000-00-00') {
                $html .= 'Expected: ' . date('M Y', strtotime($project['expected_date']));
            } else {
                $html .= 'Ongoing Project';
            }
            
            $html .= '</span>
                        </div>
                        
                        <div class="btn-compact">
                            <a href="' . url('project-details?project=' . urlencode($project['projid'])) . '" class="btn-primary">View Details</a>
                            <a ' . $previewHref . ' class="' . $previewClass . '" ' . $previewOnclick . ' title="' . ($previewAllowed ? 'View Live Project' : 'Preview not available') . '">Preview</a>
                        </div>
                    </div>
                </div>
            </div>';
        }
    } else {
        $html = '<div class="col-md-12 text-center"><p>No projects found matching your criteria.</p></div>';
    }
    
    // Generate pagination
    $pagination = '';
    if ($totalPages > 1) {
        $pagination .= '<ul class="pagination-wrap">';
        
        // Previous button
        if ($page > 1) {
            $pagination .= '<li><a href="#" data-page="' . ($page - 1) . '"><i class="ti-angle-left"></i></a></li>';
        } else {
            $pagination .= '<li class="disabled"><span><i class="ti-angle-left"></i></span></li>';
        }
        
        // Page numbers
        $startPage = max(1, $page - 2);
        $endPage = min($totalPages, $startPage + 4);
        
        for ($i = $startPage; $i <= $endPage; $i++) {
            $active = $i == $page ? 'class="active"' : '';
            $pagination .= '<li><a href="#" data-page="' . $i . '" ' . $active . '>' . $i . '</a></li>';
        }
        
        // Next button
        if ($page < $totalPages) {
            $pagination .= '<li><a href="#" data-page="' . ($page + 1) . '"><i class="ti-angle-right"></i></a></li>';
        } else {
            $pagination .= '<li class="disabled"><span><i class="ti-angle-right"></i></span></li>';
        }
        
        $pagination .= '</ul>';
    }
    
    $response = [
        'success' => true,
        'html' => $html,
        'pagination' => $pagination,
        'total' => $totalProjects,
        'totalPages' => $totalPages,
        'debug' => [
            'query' => $query,
            'params' => $params,
            'projects_count' => count($projects)
        ]
    ];
    
    error_log("Response: " . json_encode($response));
    
    echo json_encode($response);
    
} catch (Exception $e) {
    error_log("Error in get_projects.php: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'debug' => [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]
    ]);
}
?>