<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        echo "Please fill out all required fields.";
        exit;
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Set up email - FIXED: Changed to your correct email
    $to = "website@daniel-hackl.com"; //

    // Create email subject
    $email_subject = "Website Contact Form: " . $subject;
    if (empty($subject)) {
        $email_subject = "Website Contact Form: New Message";
    }

    // Create email message
    $email_body = "You have received a new message from your website contact form.\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Subject: $subject\n\n";
    $email_body .= "Message:\n$message\n";

    // Set email headers - IMPROVED: Better headers for delivery
    $headers = "From: noreply@danielhackl.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "Your message has been sent successfully!";
        exit;
    } else {
        echo "There was a problem sending the email. Please try again later.";
    }
} else {
    echo "Invalid request method.";
}
?>