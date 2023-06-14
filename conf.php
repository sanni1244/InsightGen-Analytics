<?php
require 'vendor/autoload.php'; // Load PHPMailer library

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Retrieve form data
$email = $_POST['email'];
echo $email;

// Validate the input data
if (empty($email)) {
  // Handle validation errors
  die("Name and email are required.");
}

// Store subscriber information (example using a text file)
$file = fopen("subscribers.txt", "a");
fwrite($file, "$email\n");
fclose($file);

// Send confirmation email using PHPMailer
$mail = new PHPMailer(true);

try {
  // Server settings
  $mail->SMTPDebug = 0; // Set to 2 for debugging information
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com'; // Set your SMTP host
  $mail->SMTPAuth = true;
  $mail->Username = 'sanni.ope.0@gmail.com'; // Set your email address
  $mail->Password = 'amgxhwvkhrqmfjjy'; // Set your email password
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;

  // Recipients
  $mail->setFrom('sanni.ope.0@gmail.com', 'InsightBridge Analytics'); // Set your From email and name
  $mail->addAddress($email); // Add the subscriber's email and name

  // Email content
  $mail->isHTML(false); // Set to true if your email content is HTML
  $mail->Subject = 'Confirmation Email';
  $mail->Body = 'Thank you for subscribing!';

  $mail->send();
  echo "Confirmation email sent successfully.";
} catch (Exception $e) {
  echo "Failed to send the confirmation email. Error: " . $mail->ErrorInfo;
}

echo "<meta http-equiv='refresh' content='0; url=./index.html?fromRedirect=true#subscribe'>";
exit;
?>
