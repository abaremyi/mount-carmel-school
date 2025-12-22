<?php
/**
 * Administration API Endpoint
 * File: modules/Administration/api/administrationApi.php
 * Handles all administration API requests
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . "/config/paths.php";
require_once $root_path . "/config/database.php";
require_once $root_path . "/modules/Administration/controllers/AdministrationController.php";
require_once $root_path . "/modules/Administration/models/AdministrationModel.php";

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

error_log("Administration API called with action: " . $action);

try {
    $administrationController = new AdministrationController();

    switch ($action) {
        case 'get_all_data':
        case 'getAllData':
        case '':
            // Get all administration data
            $result = $administrationController->getAllData();
            echo json_encode($result);
            break;

        case 'get_statistics':
        case 'getStatistics':
            // Get statistics only
            $result = $administrationController->getStatistics();
            echo json_encode($result);
            break;

        case 'get_staff_by_id':
        case 'getStaffById':
            // Get single staff member by ID
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            $result = $administrationController->getStaffById($id);
            echo json_encode($result);
            break;

        case 'get_department_by_id':
        case 'getDepartmentById':
            // Get department by ID
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            $result = $administrationController->getDepartmentById($id);
            echo json_encode($result);
            break;

        case 'get_leadership':
        case 'getLeadership':
            // Get leadership team only
            $result = $administrationController->getAllData();
            echo json_encode([
                'success' => $result['success'],
                'data' => $result['data']['leadership'] ?? [],
                'total' => count($result['data']['leadership'] ?? [])
            ]);
            break;

        case 'get_staff':
        case 'getStaff':
            // Get all staff only
            $result = $administrationController->getAllData();
            echo json_encode([
                'success' => $result['success'],
                'data' => $result['data']['staff'] ?? [],
                'total' => count($result['data']['staff'] ?? [])
            ]);
            break;

        case 'get_departments':
        case 'getDepartments':
            // Get departments only
            $result = $administrationController->getAllData();
            echo json_encode([
                'success' => $result['success'],
                'data' => $result['data']['departments'] ?? [],
                'total' => count($result['data']['departments'] ?? [])
            ]);
            break;

        default:
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action. Available actions: get_all_data, get_statistics, get_staff_by_id, get_department_by_id, get_leadership, get_staff, get_departments'
            ]);
            break;
    }

} catch (Exception $e) {
    error_log("Administration API Exception: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error occurred.',
        'error' => $e->getMessage()
    ]);
}
?>