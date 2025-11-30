<?php
/**
 * Gallery API Endpoint
 * File: modules/Gallery/api/galleryApi.php
 * Handles all gallery API requests
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Calculate the root path - go up 4 levels from this file's location
$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . "/config/paths.php";
require_once $root_path . "/config/database.php";
require_once $root_path . "/modules/Gallery/controllers/GalleryController.php";
require_once $root_path . "/modules/Gallery/models/GalleryModel.php";

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

// Log the request for debugging
error_log("Gallery API called with action: " . $action);

try {
    $galleryController = new GalleryController();

    switch ($action) {
        case 'get_images':
        case 'getImages':
        case '':
            // Get images with optional filters
            $params = [
                'limit' => isset($_GET['limit']) ? (int)$_GET['limit'] : 10,
                'offset' => isset($_GET['offset']) ? (int)$_GET['offset'] : 0,
                'category' => isset($_GET['category']) ? $_GET['category'] : null
            ];

            $result = $galleryController->getGalleryImages($params);
            echo json_encode($result);
            break;

        case 'get_categories':
        case 'getCategories':
            // Get all categories
            $result = $galleryController->getCategories();
            echo json_encode($result);
            break;

        case 'get_image':
        case 'getImage':
            // Get single image by ID
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            $result = $galleryController->getImageById($id);
            echo json_encode($result);
            break;

        case 'get_navigation':
        case 'getNavigation':
            // Get navigation IDs for next/previous
            $currentId = isset($_GET['current_id']) ? (int)$_GET['current_id'] : 0;
            $category = isset($_GET['category']) ? $_GET['category'] : null;
            $result = $galleryController->getNavigationIds($currentId, $category);
            echo json_encode($result);
            break;

        default:
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action. Available actions: get_images, get_categories, get_image, get_navigation'
            ]);
            break;
    }

} catch (Exception $e) {
    error_log("Gallery API Exception: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error occurred.',
        'error' => $e->getMessage()
    ]);
}
?>