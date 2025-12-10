<?php
/**
 * Auth Controller
 * File: modules/Authentication/controllers/AuthController.php
 * Handles authentication business logic
 */

// Fix the database path - go up 3 levels to reach the root, then to config
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config/database.php';
require_once dirname(__FILE__) . '/../models/UserModel.php';
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/helpers/JWTHandler.php';

class AuthController {
    private $db;
    public $userModel;
    private $jwtHandler;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->userModel = new UserModel($this->db);
        $this->jwtHandler = new JWTHandler();
    }

    /**
     * Login user
     * @param string $identifier Email or phone number
     * @param string $password User password
     * @return array Response array with success, token, and user data
     */
    public function login($identifier, $password) {
        try {
            // Get user from database
            $user = $this->userModel->getUserByEmailOrPhone($identifier);
            
            if (!$user) {
                return [
                    'success' => false, 
                    'message' => 'Invalid credentials: '.$identifier.' Password: '.$password,
                ];
            }

            // Check if account is active
            if ($user['status'] !== 'active') {
                return [
                    'success' => false, 
                    'message' => 'Account is ' . $user['status'] . '. Please contact administrator.'
                ];
            }

            // Verify password
            if (!password_verify($password, $user['password'])) {
                return [
                    'success' => false, 
                    'message' => 'Invalid credentials(password)'
                ];
            }

            // Convert permissions string to array
            $permissions = $user['permissions'] ? explode(',', $user['permissions']) : [];

            // Prepare JWT payload
            $payload = [
                'user_id' => $user['id'],
                'username' => $user['username'] ?: $user['email'],
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'role_id' => $user['role_id'],
                'role_name' => $user['role_name'],
                'is_super_admin' => (bool)$user['is_super_admin'],
                'permissions' => $permissions,
                'photo' => $user['photo'],
                'iat' => time(),
                'exp' => time() + (int)$_ENV['JWT_EXPIRATION_TIME']
            ];

            // Generate JWT token
            $token = $this->jwtHandler->generateToken($payload);

            // Update last login
            $this->userModel->updateLastLogin($user['id']);

            return [
                'success' => true,
                'message' => 'Login successful',
                'token' => $token,
                'user' => [
                    'id' => $user['id'],
                    'firstname' => $user['firstname'],
                    'lastname' => $user['lastname'],
                    'email' => $user['email'],
                    'phone' => $user['phone'],
                    'role_id' => $user['role_id'],
                    'role_name' => $user['role_name'],
                    'is_super_admin' => (bool)$user['is_super_admin'],
                    'permissions' => $permissions,
                    'photo' => $user['photo']
                ]
            ];

        } catch (Exception $e) {
            error_log("Auth Controller Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Login failed. Please try again.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Register new user
     * @param array $data User data
     * @param int $createdBy User ID who created this account
     * @return array Response array
     */
    public function register($data, $createdBy) {
        try {
            // Check if user exists
            if ($this->userModel->userExists($data['email'], $data['phone'])) {
                return [
                    'success' => false, 
                    'message' => 'Email or phone already registered'
                ];
            }

            // Hash password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['created_by'] = $createdBy;
            $data['status'] = $data['status'] ?? 'pending'; // Default status

            // Create user
            $userId = $this->userModel->createUser($data);
            
            if ($userId) {
                // Send welcome email (optional)
                $this->sendWelcomeEmail($data['email'], $data['firstname']);
                
                return [
                    'success' => true,
                    'message' => 'User registered successfully',
                    'user_id' => $userId
                ];
            }

            return [
                'success' => false, 
                'message' => 'Failed to register user'
            ];

        } catch (Exception $e) {
            error_log("Auth Controller Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Registration failed. Please try again.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Validate JWT token
     * @param string $token JWT token
     * @return mixed Decoded token or false
     */
    public function validateToken($token) {
        return $this->jwtHandler->validateToken($token);
    }

    /**
     * Send welcome email (placeholder)
     * @param string $email User email
     * @param string $name User name
     * @return bool Always true for now
     */
    private function sendWelcomeEmail($email, $name) {
        // Implement email sending logic here
        // Use PHPMailer or similar library
        error_log("Welcome email would be sent to: $email ($name)");
        return true;
    }

    /**
     * Logout user
     * @return array Response array
     */
    public function logout() {
        return [
            'success' => true, 
            'message' => 'Logged out successfully'
        ];
    }

    /**
     * Get user profile
     * @param int $userId User ID
     * @return array Response array with user data
     */
    public function getProfile($userId) {
        try {
            $user = $this->userModel->getUserById($userId);
            
            if (!$user) {
                return [
                    'success' => false, 
                    'message' => 'User not found'
                ];
            }

            // Remove sensitive data
            unset($user['password']);
            
            return [
                'success' => true, 
                'user' => $user
            ];

        } catch (Exception $e) {
            error_log("Auth Controller Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to retrieve profile.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Update user profile
     * @param int $userId User ID
     * @param array $data Updated data
     * @return array Response array
     */
    public function updateProfile($userId, $data) {
        try {
            // Remove fields that shouldn't be updated via profile
            unset($data['password'], $data['role_id'], $data['status']);
            
            $success = $this->userModel->updateUser($userId, $data);
            
            if ($success) {
                return [
                    'success' => true, 
                    'message' => 'Profile updated successfully'
                ];
            }
            
            return [
                'success' => false, 
                'message' => 'Failed to update profile'
            ];

        } catch (Exception $e) {
            error_log("Auth Controller Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to update profile.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Change password
     * @param int $userId User ID
     * @param string $currentPassword Current password
     * @param string $newPassword New password
     * @return array Response array
     */
    public function changePassword($userId, $currentPassword, $newPassword) {
        try {
            $user = $this->userModel->getUserById($userId);
            
            if (!$user) {
                return [
                    'success' => false, 
                    'message' => 'User not found'
                ];
            }

            // Verify current password
            if (!password_verify($currentPassword, $user['password'])) {
                return [
                    'success' => false, 
                    'message' => 'Current password is incorrect'
                ];
            }

            // Hash new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            $success = $this->userModel->changePassword($userId, $hashedPassword);
            
            if ($success) {
                return [
                    'success' => true, 
                    'message' => 'Password changed successfully'
                ];
            }
            
            return [
                'success' => false, 
                'message' => 'Failed to change password'
            ];

        } catch (Exception $e) {
            error_log("Auth Controller Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to change password.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Forgot password - Generate OTP
     * @param string $email User email
     * @return array Response array
     */
    public function forgotPassword($email) {
        try {
            $user = $this->userModel->getUserByEmailOrPhone($email);
            
            if (!$user) {
                return [
                    'success' => false, 
                    'message' => 'Email not found'
                ];
            }

            // Generate 6-digit OTP
            $otp = sprintf("%06d", random_int(0, 999999));
            $expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));
            
            // Store OTP in database
            $success = $this->userModel->storeResetToken($user['id'], $otp, $expiry);
            
            if ($success) {
                // Send OTP via email
                $this->sendOtpEmail($user['email'], $user['firstname'], $otp);
                
                return [
                    'success' => true, 
                    'message' => 'OTP sent to your email',
                    'otp' => $otp // For demo/testing only - remove in production
                ];
            }
            
            return [
                'success' => false, 
                'message' => 'Failed to generate OTP'
            ];

        } catch (Exception $e) {
            error_log("Auth Controller Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to process request.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Reset password with OTP
     * @param string $email User email
     * @param string $otp OTP code
     * @param string $newPassword New password
     * @return array Response array
     */
    public function resetPassword($email, $otp, $newPassword) {
        try {
            // Verify OTP
            $userId = $this->userModel->verifyResetToken($email, $otp);
            
            if (!$userId) {
                return [
                    'success' => false, 
                    'message' => 'Invalid or expired OTP'
                ];
            }
            
            // Hash new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            // Update password
            $success = $this->userModel->changePassword($userId, $hashedPassword);
            
            if ($success) {
                // Clear reset token
                $this->userModel->clearResetToken($userId);
                return [
                    'success' => true, 
                    'message' => 'Password reset successfully'
                ];
            }
            
            return [
                'success' => false, 
                'message' => 'Failed to reset password'
            ];

        } catch (Exception $e) {
            error_log("Auth Controller Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to reset password.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Verify OTP without resetting password
     * @param string $email User email
     * @param string $otp OTP code
     * @return array Response array
     */
    public function verifyOtp($email, $otp) {
        try {
            $userId = $this->userModel->verifyResetToken($email, $otp);
            
            if ($userId) {
                return [
                    'success' => true, 
                    'message' => 'OTP verified successfully'
                ];
            }
            
            return [
                'success' => false, 
                'message' => 'Invalid or expired OTP'
            ];

        } catch (Exception $e) {
            error_log("Auth Controller Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to verify OTP.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send OTP email (placeholder)
     * @param string $email User email
     * @param string $name User name
     * @param string $otp OTP code
     * @return bool Always true for now
     */
    private function sendOtpEmail($email, $name, $otp) {
        // Implement email sending logic here
        error_log("OTP email would be sent to: $email ($name) - OTP: $otp");
        return true;
    }

    /**
     * Send reset email (placeholder)
     * @param string $email User email
     * @param string $name User name
     * @param string $token Reset token
     * @return bool Always true for now
     */
    private function sendResetEmail($email, $name, $token) {
        // Implement reset email sending logic
        error_log("Reset email would be sent to: $email ($name) - Token: $token");
        return true;
    }
}
?>