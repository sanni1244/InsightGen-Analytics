<?php
require '../vendor/autoload.php';
require '../admin/connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    if (empty($email)) {
        http_response_code(400);
        die("Email is required.");
    } else {
        // Validate the email address
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'mail.insightb-analytics.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'subscribe@insightb-analytics.com';
        $mail->Password = 'Cq**5-F^8H3f';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        try {
            if (!$mail->validateAddress($email)) {
                throw new Exception("Invalid email address.");
            }

            $query = "SELECT * FROM subscribe WHERE subscribers = '$email'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                http_response_code(409);
                echo "Email already subscribed.";
            } else {
                $query = "INSERT INTO subscribe (subscribers) VALUES ('$email')";
                $conn->query($query);

                if ($conn->affected_rows > 0) {
                    $mail->setFrom('subscribe@insightb-analytics.com', 'InsightBridge Analytics');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Subscriber';
                    $mail->Body = 'Thank you for subscribing!';

                    if ($mail->send()) {
                        http_response_code(200);
                        echo "Thank you for subscribing!";
                    } else {
                        http_response_code(500);
                        echo "Failed to send the email.";
                    }
                } else {
                    http_response_code(500);
                    echo "Failed to subscribe.";
                }
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
$conn->close();

?>
