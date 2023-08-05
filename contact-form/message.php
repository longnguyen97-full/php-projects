<?php
$name = !empty($_POST['name']) ? $_POST['name'] : '';
$email = !empty($_POST['email']) ? $_POST['email'] : '';
$phone = !empty($_POST['phone']) ? $_POST['phone'] : '';
$website = !empty($_POST['website']) ? $_POST['website'] : '';
$message = !empty($_POST['message']) ? $_POST['message'] : '';

if (!empty($email) && !empty($message)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Email details
        $userEmail = $email;
        $userName = $name;
        $subject = "From: $name <$email>";
        $body = "
            Name: $name\n
            Email: $email\n
            Phone: $phone\n
            Website: $website\n
            Message: $message\n
            Regards,\n
            $name
        ";
        deliver_email($userEmail, $userName, $subject, $body);
    } else {
        echo "Enter a valid email address!";
    }
} else {
    echo "Email and message fields are required!";
}

/**
 * Send email function
 *
 * @param String $userEmail
 * @param String $userName
 * @param String $subject
 * @param String $body
 * @return void
 */
function deliver_email($userEmail, $userName, $subject, $body)
{
    require './PHPMailer/class-mail-sender.php';

    // Create an instance of the MailSender class
    $mailSender = new MailSender();

    // Send the email to admin
    if ($mailSender->deliverEmail($userEmail, $userName, $subject, $body)) {
        echo "Email sent successfully!";
    } else {
        echo "Email could not be sent.";
    }
}
