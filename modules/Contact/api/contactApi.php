<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Calculate the root path - go up 4 levels from this file's location
$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . "/config/paths.php";
require_once $root_path . "/config/database.php";
require_once $root_path . "/modules/Contact/controllers/ContactController.php";
require_once $root_path . "/modules/Contact/models/ContactModel.php";

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

// Log the request for debugging
error_log("Contact API called with action: " . $action);

switch ($action) {
    case 'contact':
        try {
            $contactController = new ContactController();
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $service_type = $_POST['service_type'] ?? '';
            $message = $_POST['message'] ?? '';

            // Log received data
            error_log("Contact form data - Name: $name, Email: $email, Phone: $phone, Service: $service_type");

            // Validate required fields
            if (empty($name) || empty($email) || empty($phone) || empty($service_type) || empty($message)) {
                echo json_encode(['success' => false, 'message' => 'All fields are required.']);
                exit;
            }

            $result = $contactController->handleContactForm($name, $email, $phone, $service_type, $message);

            if ($result['success']) {
                echo json_encode(['success' => true, 'message' => $result['message']]);
            } else {
                echo json_encode(['success' => false, 'message' => $result['message']]);
            }
        } catch (Exception $e) {
            error_log("Exception in contact API: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
        }
        exit;
    
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
        break;
}
?>