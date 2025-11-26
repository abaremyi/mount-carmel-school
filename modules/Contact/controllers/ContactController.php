<?php
// Fix the database path - go up 3 levels to reach the root, then to config
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config/database.php';
require_once dirname(__FILE__) . '/../models/ContactModel.php';

// Include PHPMailer - adjust path based on where your vendor directory is located
// If vendor is in root, use:
$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController
{
    private $db;
    public $contactModel;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->contactModel = new ContactModel($this->db);
    }
    
    public function handleContactForm($name, $email, $phone, $service_type, $message)
    {
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email address.'];
        }

        // Validate required fields
        if (empty($name) || empty($email) || empty($phone) || empty($service_type) || empty($message)) {
            return ['success' => false, 'message' => 'All fields are required.'];
        }

        // SAVE CONTACT MESSAGE
        if ($this->contactModel->saveContactMessage($name, $email, $phone, $service_type, $message)) {
            $contactData = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'service_type' => $service_type,
                'message' => $message
            ];
            
            // Send notification email to admin
            $emailSent = $this->sendAdminNotificationEmail($contactData);
            
            // Send confirmation email to client
            $clientEmailSent = $this->sendClientConfirmationEmail($contactData);

            return ['success' => true, 'message' => 'Your message has been sent successfully! We will get back to you soon.'];
        }

        return ['success' => false, 'message' => 'Failed to send message. Please try again.'];
    }

    public function sendAdminNotificationEmail($contactData) {
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'abaremy1997@gmail.com';
            $mail->Password   = 'emnxgufwmehjdiii';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            
            // Recipients
            $mail->setFrom('abaremy1997@gmail.com', 'MUSHYA Group Website');
            $mail->addAddress('mushyagroup@gmail.com', 'MUSHYA Group Ltd');
            $mail->addReplyTo($contactData['email'], $contactData['name']);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'New Contact Message - ' . $contactData['service_type'];
            
            $emailBody = "
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background-color: #47b0d6; color: white; padding: 20px; text-align: center; }
                    .content { padding: 20px; background-color: #f9f9f9; }
                    .field { margin-bottom: 10px; }
                    .label { font-weight: bold; color: #555; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>NEW CONTACT MESSAGE</h1>
                    </div>
                    <div class='content'>
                        <p>Dear Admin,</p>
                        <p>A new contact message has been received through the website. Below are the details:</p>
                        
                        <div class='field'>
                            <span class='label'>Name:</span> {$contactData['name']}
                        </div>
                        <div class='field'>
                            <span class='label'>Email:</span> {$contactData['email']}
                        </div>
                        <div class='field'>
                            <span class='label'>Phone:</span> {$contactData['phone']}
                        </div>
                        <div class='field'>
                            <span class='label'>Service Type:</span> {$contactData['service_type']}
                        </div>
                        <div class='field'>
                            <span class='label'>Message:</span><br>
                            <p>{$contactData['message']}</p>
                        </div>
                        
                        <p>Please respond to this inquiry as soon as possible.</p>
                    </div>
                </div>
            </body>
            </html>
            ";
            
            $mail->Body = $emailBody;
            $mail->AltBody = "New contact message from {$contactData['name']} ({$contactData['email']}). Service: {$contactData['service_type']}. Message: {$contactData['message']}";
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Admin notification email could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
    
    public function sendClientConfirmationEmail($contactData) {
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'abaremy1997@gmail.com';
            $mail->Password   = 'emnxgufwmehjdiii';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            
            // Recipients
            $mail->setFrom('abaremy1997@gmail.com', 'MUSHYA Group');
            $mail->addAddress($contactData['email'], $contactData['name']);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Thank You for Contacting MUSHYA Group';
            
            $emailBody = "
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { color: #47b0d6; padding: 20px; text-align: center; }
                    .content { padding: 20px; background-color: #f9f9f9; }
                    .footer { text-align: center; padding: 20px; color: #666; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>Thank You for Contacting Us</h1>
                    </div>
                    <div class='content'>
                        <p>Dear {$contactData['name']},</p>
                        <p>Thank you for reaching out to Mushya Group Ltd. We have received your message regarding <strong>{$contactData['service_type']}</strong> and will get back to you within 24 hours.</p>
                        
                        <p><strong>Here's a summary of your inquiry:</strong></p>
                        <p>{$contactData['message']}</p>
                        
                        <p>If you have any urgent questions, feel free to contact us directly at +250 796 504 983.</p>
                    </div>
                    <div class='footer'>
                        <p>Best Regards,<br>The MUSHYA GROUP Team</p>
                        <p>Email: mushyagroup@gmail.com<br>Phone: +250 796 504 983</p>
                    </div>
                </div>
            </body>
            </html>
            ";
            
            $mail->Body = $emailBody;
            $mail->AltBody = "Thank you for contacting MUSHYA Group. We have received your message and will get back to you within 24 hours.";
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Client confirmation email could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
?>