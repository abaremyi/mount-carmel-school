<?php

require_once '../../../config/database.php';
require_once '../models/User.php';
require_once '../../../helpers/JWTHandler.php';  // Include your JWTHandler class

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class AuthenticationController
{
    private $db;
    public $userModel;
    private $jwtHandler;

    public function __construct()
    {
        // Get database connection and initialize the User model
        $this->db = Database::getInstance();
        $this->userModel = new User($this->db);

        // Initialize JWTHandler to manage JWT tokens
        $this->jwtHandler = new JWTHandler();
    }

    // Register a new user
    public function registerUser($firstname, $lastname, $phone, $email, $password, $username, $address, $startingDate, $roleid)
    {
        // Check if email already exists
        if ($this->userModel->emailExists($email, $phone)) {
            return ['success' => false, 'message' => 'Email or Phone Number is already taken.'];
        }

        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create user
        if ($this->userModel->createUser($firstname, $lastname, $phone, $email, $hashedPassword, $username, $address, $startingDate, $roleid)) {
            return ['success' => true, 'message' => 'Registration successful!'];
        }

        return ['success' => false, 'message' => 'Failed to register user.'];
    }

    // ADMIN CREATE USER CONTROLLER
    public function adminRegisterUser($firstname, $lastname, $phone, $email, $password, $username, $address, $startingDate, $roleid)
    {
        // Check if email already exists
        if ($this->userModel->emailExists($email, $phone)) {
            return ['success' => false, 'message' => 'Email or Phone Number is already taken.'];
        }

        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create user
        if ($this->userModel->adminCreateUser($firstname, $lastname, $phone, $email, $hashedPassword, $username, $address, $startingDate, $roleid)) {
            // Send email with reset password link
            $resetLink = "http://localhost:8080/milk/modules/Authentication/views/resetPassword.php?email=$email";
            $this->sendAccountCreationEmail($email, $resetLink);
            return ['success' => true, 'message' => 'Registration successful!'];
        }

        return ['success' => false, 'message' => 'Failed to register user.'];
    }

    // User login method
    public function loginUser($username, $password) {
        $user = $this->userModel->getUserByUsername($username);
    
        if ($user && password_verify($password, $user['password'])) {
            // Convert rights string into an array
            $rights = isset($user['rights']) && !empty($user['rights']) ? explode(',', $user['rights']) : [];
    
            // Assign role name based on roleid
            $role = 'Unknown'; // Default value

            switch ($user['roleid']) {
                case 1:
                    $role = 'MANAGER';
                    break;
                case 2:
                    $role = 'MILK COLLECTOR';
                    break;
                case 3:
                    $role = 'FARMER';
                    break;
                case 4:
                    $role = 'CUSTOMER';
                    break;
            }
    
            // Prepare JWT payload
            $payload = [
                'userid' => $user['userid'],
                'username' => $user['username'],
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'role' => $user['roleid'],
                'displayed_role' => $role,
                'photo' => $user['photo'],
                'account_status' => $user['status'],
                'rights' => $rights,  // 
                'iat' => time(),
                'exp' => time() + 3600 // Expire in 1 hour
            ];
    
            // Generate JWT token
            $token = $this->jwtHandler->generateToken($payload);
    
            // Set JWT token as an HttpOnly cookie
            setcookie('jwtToken', $token, time() + 3600, '/', '', false, true);
    
            return [
                'success' => true,
                'message' => 'Login successful.',
                'roleid' => $user['roleid'],
                'status' => $user['status'],
                'rights' => $rights // ✅ Send rights as an array
            ];
        }
    
        return ['success' => false, 'message' => 'Invalid email or password.'];
    }  

    // Reset User Password
    public function resetUserPassword($email, $password)
    {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create user
        if ($this->userModel->resetUserPasswordModel($email,$hashedPassword)) {
            return ['success' => true, 'message' => 'Password Reset successful!'];
        }

        return ['success' => false, 'message' => 'Failed to Reset User Password.'];
    }

    // Fetch USERS Information method 
    public function usersFetch()
    {
        $users = $this->userModel->usersFetchModel();
        if (!empty($users)) {
            return $users; // Return the fetched data
        }
        return [];
    }
    
    
    public function updateUserStatus($userId, $status) {
        // Update the user status in the database
        if ($this->userModel->updateUserStatus($userId, $status)) {
            // Send email notification
            $user = $this->userModel->getUserById($userId);
            $this->sendStatusChangeEmail($user['email'], $status);
            return ['success' => true, 'message' => 'User status updated successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to update user status.'];
        }
    }
    
    public function deleteUser($userId) {
        if ($this->userModel->deleteUser($userId)) {
            return ['success' => true, 'message' => 'User deleted successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to delete user.'];
        }
    }
    
    public function viewUserDetails($userId) {
        $user = $this->userModel->getUserById($userId);
        if ($user) {
            return ['success' => true, 'user' => $user];
        } else {
            return ['success' => false, 'message' => 'User not found.'];
        }
    }
    
    private function sendStatusChangeEmail($email, $status) {
        $subject = 'Account Status Update';
        $message = "Your account status has been updated to: $status.";
    
        // Use PHP Mailer to send the email
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'abaremy1997@gmail.com'; // Your Gmail address
            $mail->Password = 'tdkkisnekobxueuo'; // Your Gmail app password
            $mail->SMTPSecure = 'ssl';      // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465; 
    
            // Recipients
            $mail->setFrom($email, 'URUHIMBI MILK COLLECTION'); // Sender email and name
            $mail->addAddress($email); // Recipient email
    
            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
    
            // Send the email
            $mail->send();
            return true; // Email sent successfully
        } catch (Exception $e) {
            error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false; // Email failed to send
        }
    }

    // SEND RESET LINK
    private function sendAccountCreationEmail($email, $resetLink) {
        $subject = 'Account Created - Reset Your Password';
        $message = "
            <h2>Welcome to Milk Collection and Delivery Record Keeping Platform!</h2>
            <p>Your account has been successfully created by the administrator.</p>
            <p>To set your password, please click the link below:</p>
            <p>
                <a href='$resetLink' style='font-size: 18px; font-weight: bold; color: blue; text-decoration: none;' target='_blank'>
                    Reset Your Password
                </a>
            </p>
            <p>If you did not request this, please ignore this email.</p>
            <p>Best regards,<br>UMCD Team</p>
        ";
    
        // Use PHP Mailer to send the email
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'abaremy1997@gmail.com'; // Your Gmail address
            $mail->Password = 'tdkkisnekobxueuo'; // Your Gmail app password
            $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;
    
            // Recipients
            $mail->setFrom('abaremy1997@gmail.com', 'URUHIMBI MILK COLLECTION'); // Sender email and name
            $mail->addAddress($email); // Recipient email
    
            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $message;
    
            // Send the email
            $mail->send();
            return true; // Email sent successfully
        } catch (Exception $e) {
            error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false; // Email failed to send
        }
    }

    // Validate the provided JWT token
    public function validateToken($token)
    {
        return $this->jwtHandler->validateToken($token);
    }
}
