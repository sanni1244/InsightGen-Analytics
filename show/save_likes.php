<?php
// Retrieve the JSON data from the request
$jsonData = $_POST['blogs'];

// Specify the file path to save the JSON data
$filePath = '../json/blogs.json';

// Save the JSON data to the file
file_put_contents($filePath, $jsonData);

// Respond with a success message
echo json_encode(['status' => 'success']);
?>
