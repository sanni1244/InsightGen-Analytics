<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);
  $selectedEmails = $data['emails'] ?? [];
  $subject = $data['subject'] ?? '';
  $message = $data['message'] ?? '';

  if (empty($selectedEmails)) {
    http_response_code(400);
    exit('No email addresses selected.');
  }

  if (empty($subject)) {
    http_response_code(400);
    exit('Subject is empty.');
  }

  if (empty($message)) {
    http_response_code(400);
    exit('Message is empty.');
  }

  require '../vendor/autoload.php';

  $mail = new PHPMailer(true);

    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host = 'mail.insightb-analytics.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'subscribe@insightb-analytics.com';
    $mail->Password = 'Cq**5-F^8H3f';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('subscribe@insightb-analytics.com', 'InsightBridge Analytics');
    foreach ($selectedEmails as $email) {
      $mail->addAddress($email);
    }
    $mail->Subject = $subject;
    $mail->isHTML(true);
    $mail->Body = $message;


    try {
    $mail->send();
    http_response_code(200);
    exit('Emails sent successfully.');
  } catch (Exception $e) {
    http_response_code(500);
    exit('Failed to send emails.');
  }
}
?>
