<?php
/**
 * Database Connection Class
 * File: config/database.php
 * Handles PDO database connection
 */

class Database {
    private static $connection = null;

    // Adding getInstance method to maintain compatibility with the controller
    public static function getInstance() {
        return self::getConnection();  // Reuse the existing getConnection method
    }

    public static function getConnection() {
        if (self::$connection === null) {
            $host = 'localhost';  
            $port = '3308';  // ✅ ADDED PORT FOR YOUR XAMPP
            $db = 'mount_carmel_db';  
            $user = 'root'; 
            $pass = ''; 

            try {
                // ✅ UPDATED: Added port to connection string
                self::$connection = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                
                // Optional: Set charset to UTF-8
                self::$connection->exec("SET NAMES utf8mb4");
                
            } catch (PDOException $e) {
                // Log error instead of displaying it (security best practice)
                error_log("Database Connection Error: " . $e->getMessage());
                
                // Display user-friendly error
                die("Database connection failed. Please check your configuration.");
            }
        }
        return self::$connection;
    }
    
    /**
     * Close the database connection
     */
    public static function closeConnection() {
        self::$connection = null;
    }
    
    /**
     * Test the database connection
     * @return bool True if connection is successful
     */
    public static function testConnection() {
        try {
            $conn = self::getConnection();
            return $conn !== null;
        } catch (Exception $e) {
            error_log("Database Test Connection Error: " . $e->getMessage());
            return false;
        }
    }
}
?>