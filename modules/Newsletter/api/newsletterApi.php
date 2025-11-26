<?php
require_once '../../../config/database.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$email = $_POST['email'] ?? '';

try {
    $db = Database::getInstance();
    
    switch ($action) {
        case 'subscribe':
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => 'Invalid email address']);
                exit;
            }
            
            // Check if already subscribed
            $stmt = $db->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'This email is already subscribed']);
                exit;
            }
            
            // Insert new subscriber
            $stmt = $db->prepare("INSERT INTO newsletter_subscribers (email, subscribed_at) VALUES (?, NOW())");
            if ($stmt->execute([$email])) {
                echo json_encode(['success' => true, 'message' => 'Thank you for subscribing!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Subscription failed. Please try again.']);
            }
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (PDOException $e) {
    error_log("Newsletter error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again.']);
}