<?php
class ContactModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function saveContactMessage($name, $email, $phone, $service_type, $message) {
        try {
            $query = "INSERT INTO contact_messages (name, email, phone, service_type, message, created_at) VALUES 
            (:name, :email, :phone, :service_type, :message, NOW())";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':service_type', $service_type, PDO::PARAM_STR);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
         
            if ($stmt->execute()) {
                return true; 
            } else {
                error_log("Database error: " . implode(", ", $stmt->errorInfo()));
                return false; 
            }
        } catch (PDOException $e) {
            error_log("PDO Exception: " . $e->getMessage());
            return false;
        }
    }
}
?>