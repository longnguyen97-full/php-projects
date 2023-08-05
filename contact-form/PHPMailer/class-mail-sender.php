<?php
require './PHPMailer/vendor/autoload.php'; // If using Composer autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailSender
{
    private $mail;
    protected $userEmail, $userName, $adminEmail, $adminName, $subject, $body;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
    }

    public function deliverEmail($userEmail, $userName, $subject, $body)
    {
        try {
            // Server settings
            $this->mail->SMTPDebug = 0;                      // Enable verbose debug output (set to 0 for no debug output)
            $this->mail->isSMTP();                           // Set mailer to use SMTP
            $this->mail->Host = 'smtp.gmail.com';          // Specify main and backup SMTP servers
            $this->mail->SMTPAuth = true;                    // Enable SMTP authentication
            $this->mail->Username = 'email@gmail.com';    // SMTP username
            $this->mail->Password = '';    // SMTP password/App password
            $this->mail->SMTPSecure = 'tls';                 // Enable TLS encryption, 'ssl' also accepted
            $this->mail->Port = 587;                        // TCP port to connect to

            // Hold details
            $this->userEmail = $userEmail;
            $this->userName = $userName;
            $this->adminEmail = 'email@gmail.com';
            $this->adminName = 'Admin';
            $this->subject = $subject;
            $this->body = $body;

            // User send mail to admin
            $this->sendEmail($this->mail);

            // Admin reply mail to admin
            $this->replyEmail($this->mail);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function sendEmail($mail)
    {
        // Sender details
        $mail->setFrom($this->userEmail, $this->userName);

        // Recipient details
        $mail->addAddress($this->adminEmail, $this->adminName);

        // Email content
        $mail->isHTML(true);                      // Set email format to HTML
        $mail->Subject = $this->subject;
        $mail->Body = $this->body;

        $mail->send();
    }

    public function replyEmail($mail)
    {
        // Sender details
        $mail->setFrom($this->adminEmail, $this->adminName);

        // Recipient details
        $mail->addAddress($this->userEmail, $this->userName);

        // Email content
        $mail->isHTML(true);                      // Set email format to HTML
        $mail->Subject = "From: ABC Company <$this->adminEmail>";
        $mail->Body = "Thank you for your message";

        $mail->send();
    }
}
