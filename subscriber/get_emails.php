<?php
require '../admin/connection.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$query = "SELECT subscribers FROM subscribe";
$result = $conn->query($query);

$emails = [];
while ($row = $result->fetch_assoc()) {
    $emails[] = $row['subscribers'];
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($emails);
?>
