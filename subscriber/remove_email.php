<?php
require '../admin/connection.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);
$email = $data['email'];

$query = "DELETE FROM subscribe WHERE subscribers = '$email'";
$result = $conn->query($query);

if ($result) {
    http_response_code(200);
    echo "Email removed successfully!";
} else {
    http_response_code(500);
    echo "Failed to remove email. Please try again.";
}

$conn->close();
?>
