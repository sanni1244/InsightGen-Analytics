<?php
require '../admin/connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);
$emails = $data['emails'];
$subject = $data['subject'];
$message = $data['message'];

$successCount = 0;

foreach ($emails as $email) {
    // Replace this with your email sending code
    // Example using PHPMailer
    require '../vendor/autoload.php';


    $mail = new PHPMailer(true);
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = '';
    $mail->SMTPAuth = true;
    $mail->Username = 'subscribe@insightGen@gmail.com';
    $mail->Password = '';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    try {
        $mail->setFrom('subscribe@insightGen-analytics.com', 'InsightGen Analytics');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        if ($mail->send()) {
            $successCount++;
        }
    } catch (Exception $e) {
        // Handle sending error
    }
}

$response = array(
    'success' => $successCount,
    'total' => count($emails)
);

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
