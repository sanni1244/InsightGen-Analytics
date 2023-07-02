<?php
$jsonFile = "../json/blogs.json";

if (isset($_POST['updatedData'])) {
  $updatedData = $_POST['updatedData'];

  // Rearrange the data array based on timestamp
  $jsonData = json_decode($updatedData, true);

  usort($jsonData, function($a, $b) {
    $timestampA = DateTime::createFromFormat('d/m/Y, H:i:s', $a['timestamp'])->getTimestamp();
    $timestampB = DateTime::createFromFormat('d/m/Y, H:i:s', $b['timestamp'])->getTimestamp();

    return $timestampB - $timestampA;
  });

  // Save the rearranged data to the JSON file
  file_put_contents($jsonFile, json_encode($jsonData, JSON_PRETTY_PRINT));

  // Return a success response
  http_response_code(200);
} else {
  // Return an error response
  http_response_code(400);
}
?>
