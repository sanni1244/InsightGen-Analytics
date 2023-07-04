<?php
$jsonData = $_POST['blogs'];

$filePath = '../json/blogs.json';

file_put_contents($filePath, $jsonData);

echo json_encode(['status' => 'success']);
?>
