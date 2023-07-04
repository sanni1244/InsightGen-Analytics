<?php
$jsonFile = "../json/blogs.json";

if (isset($_POST['updatedData'])) {
  $updatedData = $_POST['updatedData'];

  $jsonData = json_decode($updatedData, true);

  usort($jsonData, function($a, $b) {
    $timestampA = DateTime::createFromFormat('d/m/Y, H:i:s', $a['timestamp'])->getTimestamp();
    $timestampB = DateTime::createFromFormat('d/m/Y, H:i:s', $b['timestamp'])->getTimestamp();

    return $timestampB - $timestampA;
  });

  file_put_contents($jsonFile, json_encode($jsonData, JSON_PRETTY_PRINT));

  http_response_code(200);
} else {
  http_response_code(400);
}
?>
