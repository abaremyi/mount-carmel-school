<?php

// autoload.php should include all necessary classes (like controllers, DB classes)
require_once '../../../config/database.php';
require_once '../controllers/AuthenticationController.php';
require_once '../../../helpers/JWTHandler.php'; // Include your JWT helper

header('Content-Type: application/json');

// Initialize JWT handler
$jwt = new JWTHandler();

// $action = $_GET['action'] ?? '';
$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

switch ($action) {
        
    case 'login':
        $authController = new AuthenticationController();
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
    
        // Call the login method to verify credentials
        $result = $authController->loginUser($username, $password);
    
        if ($result['success']) {
            echo json_encode([
                'success' => true, 
                'message' => 'Login successful.', 
                'roleid' => $result['roleid'],   
                'status' => $result['status'],   
                'rights' => $result['rights']   // ✅ Send rights as an array
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => $result['message']]);
        }
        exit;

    case 'register':
        $authController = new AuthenticationController();
        $firstname = $_POST['firstname'] ?? '';
        $lastname = $_POST['lastname'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $username = $_POST['username'] ?? '';
        $address = $_POST['address'] ?? '';
       
        $startingDate = $_POST['startingDate'] ?? '';
        $roleid = $_POST['roleid'] ?? '';
        
        // echo '<script>console.log("phone:'.$phone.', email:'.$email.', password:'.$password.', username:'.$username.' ")</script>';

        // Call the register method and check if the registration is successful
        $result = $authController->registerUser($firstname, $lastname, $phone, $email, $password, $username, $address, $startingDate, $roleid);

        if ($result['success']) {
            echo json_encode(['success' => true, 'message' => $result['message']]);
        } else {
            echo json_encode(['success' => false, 'message' => $result['message']]);
        }
        exit;

    case 'adminRegister':
        $authController = new AuthenticationController();
        $firstname = $_POST['firstname'] ?? '';
        $lastname = $_POST['lastname'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $username = $_POST['username'] ?? '';
        $address = $_POST['address'] ?? '';
        
        $startingDate = $_POST['startingDate'] ?? '';
        $roleid = $_POST['roleid'] ?? '';
        
        // echo '<script>console.log("phone:'.$phone.', email:'.$email.', password:'.$password.', username:'.$username.' ")</script>';

        // Call the register method and check if the registration is successful
        $result = $authController->adminRegisterUser($firstname, $lastname, $phone, $email, $password, $username, $address, $startingDate, $roleid);

        if ($result['success']) {
            echo json_encode(['success' => true, 'message' => $result['message']]);
        } else {
            echo json_encode(['success' => false, 'message' => $result['message']]);
        }
        exit;
        
    case 'checkEmail':
        $authController = new AuthenticationController();
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';

        // Check if the email already exists in the database
        if ($authController->userModel->emailExists($email, $phone)) {
            echo json_encode(['exists' => true]);
        } else {
            echo json_encode(['exists' => false]);
        }
        exit;
        
    case 'verifyEmail':
        $authController = new AuthenticationController();
        $email = $_POST['email'] ?? '';

        // Check if the email already exists in the database
        if ($authController->userModel->verifyEmail($email)) {
            echo json_encode(['success' => true, 'message' => 'Email Found!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Email Not Found!']);
        }
        exit;

    case 'reset_password':
        $authController = new AuthenticationController();
        $password = $_POST['password'] ?? '';
        $email = $_POST['email'] ?? '';
        
        $result = $authController->resetUserPassword($email,$password);

        if ($result['success']) {
            echo json_encode(['success' => true, 'message' => $result['message']]);
        } else {
            echo json_encode(['success' => false, 'message' => $result['message']]);
        }
        exit;
    
    case 'fetchFarmer':
        $authController = new AuthenticationController();

        // Check if the email already exists in the database
        $farmers = $authController->userModel->farmerFetch();
        if ($farmers) {
            echo json_encode($farmers);
        } else {
            echo json_encode(['exists' => false, 'message' => 'No Farmer Found']);
        }
        exit;
    
    case 'fetchUsers':
        $authController = new AuthenticationController();

        $users = $authController->usersFetch();
        if ($users) {
            echo json_encode($users);
        } else {
            echo json_encode(['exists' => false, 'message' => 'No Farmer Found']);
        }
        exit;

    case 'updateUserStatus':
        $userId = $_POST['userId'];
        $status = $_POST['status'];
        $authController = new AuthenticationController();
        $result = $authController->updateUserStatus($userId, $status);
        echo json_encode($result);
        exit;
    
    case 'deleteUser':
        $userId = $_POST['userId'];
        $authController = new AuthenticationController();
        $result = $authController->deleteUser($userId);
        echo json_encode($result);
        exit;
    
    case 'viewUserDetails':
        $userId = $_POST['userId'];
        $authController = new AuthenticationController();
        $result = $authController->viewUserDetails($userId);
        echo json_encode($result);
        exit;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
        break;
}
