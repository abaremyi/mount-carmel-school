<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Check if the email already exists in the database
    public function emailExists($email, $phone) {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email or phone = :phone";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0; // If count > 0, email exists
    }
    
    public function verifyEmail($email) {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0; // If count > 0, email exists
    }

    // Create a new user (for registration)
    public function createUser($firstname, $lastname, $phone, $email, $hashedPassword, $username, $address, $startingDate, $roleid) {
        $status = 'Waiting';
        $query = "INSERT INTO users (firstname, lastname, phone, email, password, username, address, startingDate, roleid, status) VALUES (:firstname, :lastname, :phone, :email, :password, :username, :address, :startingDate, :roleid, :status)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
       
        $stmt->bindParam(':startingDate', $startingDate, PDO::PARAM_STR);
        $stmt->bindParam(':roleid',$roleid, PDO::PARAM_STR);
        $stmt->bindParam(':status',$status, PDO::PARAM_STR);
       

        if ($stmt->execute()) {
            return true; // Return true if registration was successful
        } else {
            return false; // Return false if registration failed
        }
    }

    // ADMIN CREATE COLLECTOR OR MANAGER ACCOUNTS
    public function adminCreateUser($firstname, $lastname, $phone, $email, $hashedPassword, $username, $address, $startingDate, $roleid) {
        $status = 'Pending';
        $query = "INSERT INTO users (firstname, lastname, phone, email, password, username, address, startingDate, roleid, status) VALUES (:firstname, :lastname, :phone, :email, :password, :username, :address, :startingDate, :roleid, :status)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
       
        $stmt->bindParam(':startingDate', $startingDate, PDO::PARAM_STR);
        $stmt->bindParam(':roleid',$roleid, PDO::PARAM_STR);
        $stmt->bindParam(':status',$status, PDO::PARAM_STR);
       

        if ($stmt->execute()) {
            return true; // Return true if registration was successful
        } else {
            return false; // Return false if registration failed
        }
    }

    // Get user by email or Phone (for login)
    public function getUserByUsername($username) { 
        $query = "SELECT u.userid, u.username, u.firstname, u.lastname, u.phone, u.email, u.password, u.roleid,  u.photo,  u.status, 
                         GROUP_CONCAT(r.right_name SEPARATOR ',') AS rights
                  FROM users u
                  LEFT JOIN role_rights rr ON u.roleid = rr.roleid
                  LEFT JOIN rights r ON rr.right_id = r.id
                  WHERE u.email = :email OR u.phone = :phone OR u.username = :username
                  GROUP BY u.userid";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $username, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $username, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Reset Password 
    public function resetUserPasswordModel($email, $hashedPassword) {
        $status = 'Active';
        $query = "UPDATE users SET password = :password, status = :status WHERE email=:email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
       

        if ($stmt->execute()) {
            return true; // Return true if Update was successful
        } else {
            return false; // Return false if Update failed
        }
    }

    // Select all Farmers exists in the database
    public function farmerFetch() {
        $roleid = 3;
        $query = "SELECT * FROM users WHERE roleid = :roleid ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':roleid', $roleid, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // retur all fetched farmers
    }

    // Select all Farmers exists in the database
    public function usersFetchModel() {

        $query = "SELECT * FROM users  ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // retur all fetched farmers
    }

    public function updateUserStatus($userId, $status) {
        $query = "UPDATE users SET status = :status WHERE userid = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function deleteUser($userId) {
        $query = "DELETE FROM users WHERE userid = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function getUserById($userId) {
        $query = "SELECT * FROM users WHERE userid = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
