<?php
/**
 * User Model
 * File: modules/Authentication/models/UserModel.php
 * Handles all database operations for users
 */

class UserModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Check if email/phone exists
     * @param string $email User email
     * @param string $phone User phone
     * @return bool True if exists
     */
    public function userExists($email, $phone)
    {
        try {
            $query = "SELECT COUNT(*) FROM users WHERE email = :email OR phone = :phone";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;

        } catch (PDOException $e) {
            error_log("User Model Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user by email or phone for login
     * @param string $identifier Email, phone, or username
     * @return array|null User data or null
     */
    public function getUserByEmailOrPhone($identifier)
{
    try {
        $query = "SELECT u.*, r.name as role_name, r.is_super_admin
                  FROM users u
                  JOIN roles r ON u.role_id = r.id
                  WHERE u.email = :email_id OR u.phone = :phone_id OR u.username = :username_id 
                  LIMIT 1";

        $stmt = $this->db->prepare($query);

        // FIX: Explicitly bind the identifier value to all three unique placeholders
        $stmt->execute([
            ':email_id' => $identifier,
            ':phone_id' => $identifier,
            ':username_id' => $identifier,
        ]);
        
        $user = $stmt->fetch();
        
        // Fetch permissions here (this calls the next function we will fix)
        if ($user) {
            $user['permissions'] = $this->getUserPermissions($user['role_id']);
        }

        return $user;

    } catch (PDOException $e) {
        // We log the actual error here to help with debugging
        error_log("User Model Error in getUserByEmailOrPhone: " . $e->getMessage());
        // Do not return $e->errorInfo here in final code, just for dev if needed
        // error_log("SQL Error: " . print_r($stmt->errorInfo(), true)); 
        return false;
    }
}

    private function getUserPermissions($roleId)
{
    try {
        $query = "SELECT CONCAT(p.module, '.', p.action) as permission
                  FROM role_permissions rp
                  JOIN permissions p ON rp.permission_id = p.id
                  WHERE rp.role_id = :role_id";

        $stmt = $this->db->prepare($query);
        
        // FIX: Change array(':role_id', $roleId) to associative syntax
        $stmt->execute(array(':role_id' => $roleId)); 

        // FIX: Use fetchAll to get ALL permission strings for this role
        $permissions = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); 
        
        return implode(',', $permissions);

    } catch (PDOException $e) {
        error_log("User Model Error in getUserPermissions: " . $e->getMessage());
        return '';
    }
}

    /**
     * Create new user
     * @param array $data User data
     * @return int|bool User ID or false
     */
    public function createUser($data)
    {
        try {
            $query = "INSERT INTO users (firstname, lastname, email, phone, username, password, role_id, status, created_by) 
                      VALUES (:firstname, :lastname, :email, :phone, :username, :password, :role_id, :status, :created_by)";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':firstname', $data['firstname'], PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $data['lastname'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindParam(':phone', $data['phone'], PDO::PARAM_STR);
            $stmt->bindParam(':username', $data['username'], PDO::PARAM_STR);
            $stmt->bindParam(':password', $data['password'], PDO::PARAM_STR);
            $stmt->bindParam(':role_id', $data['role_id'], PDO::PARAM_INT);
            $stmt->bindParam(':status', $data['status'], PDO::PARAM_STR);
            $stmt->bindParam(':created_by', $data['created_by'], PDO::PARAM_INT);

            return $stmt->execute() ? $this->db->lastInsertId() : false;

        } catch (PDOException $e) {
            error_log("User Model Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update user last login
     * @param int $userId User ID
     * @return bool Success status
     */
    public function updateLastLogin($userId)
    {
        try {
            $query = "UPDATE users SET last_login = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("User Model Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user by ID
     * @param int $id User ID
     * @return array|null User data or null
     */
    public function getUserById($id)
    {
        try {
            $query = "SELECT u.*, r.name as role_name, r.is_super_admin
                      FROM users u
                      LEFT JOIN roles r ON u.role_id = r.id
                      WHERE u.id = :id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("User Model Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Update user
     * @param int $id User ID
     * @param array $data Updated data
     * @return bool Success status
     */
    public function updateUser($id, $data)
    {
        try {
            $fields = [];
            foreach ($data as $key => $value) {
                $fields[] = "$key = :$key";
            }

            $query = "UPDATE users SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($query);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("User Model Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Change password
     * @param int $id User ID
     * @param string $hashedPassword Hashed password
     * @return bool Success status
     */
    public function changePassword($id, $hashedPassword)
    {
        try {
            $query = "UPDATE users SET password = :password WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("User Model Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Store reset token (OTP)
     * @param int $userId User ID
     * @param string $otp OTP code
     * @param string $expiry Expiry datetime
     * @return bool Success status
     */
    public function storeResetToken($userId, $otp, $expiry)
    {
        try {
            $query = "UPDATE users SET reset_token = :otp, reset_expiry = :expiry WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':otp', $otp, PDO::PARAM_STR);
            $stmt->bindParam(':expiry', $expiry, PDO::PARAM_STR);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("User Model Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify reset token (OTP)
     * @param string $email User email
     * @param string $otp OTP code
     * @return int|bool User ID or false
     */
    public function verifyResetToken($email, $otp)
    {
        try {
            $query = "SELECT id FROM users WHERE email = :email AND reset_token = :otp 
                      AND reset_expiry > NOW()";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':otp', $otp, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn();

        } catch (PDOException $e) {
            error_log("User Model Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Clear reset token after use
     * @param int $userId User ID
     * @return bool Success status
     */
    public function clearResetToken($userId)
    {
        try {
            $query = "UPDATE users SET reset_token = NULL, reset_expiry = NULL WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("User Model Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all users with pagination (admin only)
     * @param int $limit Number of users
     * @param int $offset Starting position
     * @param string $search Search term
     * @return array Array of users
     */
    public function getAllUsers($limit = 20, $offset = 0, $search = '')
    {
        try {
            $query = "SELECT u.*, r.name as role_name, 
                             CONCAT(creator.firstname, ' ', creator.lastname) as created_by_name
                      FROM users u
                      LEFT JOIN roles r ON u.role_id = r.id
                      LEFT JOIN users creator ON u.created_by = creator.id
                      WHERE u.firstname LIKE :search OR u.lastname LIKE :search OR u.email LIKE :search
                      ORDER BY u.created_at DESC
                      LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($query);
            $searchTerm = "%$search%";
            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("User Model Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Delete user (admin only)
     * @param int $id User ID
     * @return bool Success status
     */
    public function deleteUser($id)
    {
        try {
            $query = "DELETE FROM users WHERE id = :id AND role_id != 1"; // Prevent deleting super admin
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("User Model Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Count total users
     * @param string $search Search term
     * @return int Total count
     */
    public function countUsers($search = '')
    {
        try {
            $query = "SELECT COUNT(*) FROM users 
                      WHERE firstname LIKE :search OR lastname LIKE :search OR email LIKE :search";

            $stmt = $this->db->prepare($query);
            $searchTerm = "%$search%";
            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchColumn();

        } catch (PDOException $e) {
            error_log("User Model Error: " . $e->getMessage());
            return 0;
        }
    }
}
?>