<?php
  // Read the JSON file
  $jsonFile = '../json/content.json';
  $jsonData = file_get_contents($jsonFile);
  $data = json_decode($jsonData, true);

  $postedData = json_decode(file_get_contents('php://input'), true);

  $mergedData = array_merge($data, $postedData);

  $updatedJsonData = json_encode($mergedData, JSON_PRETTY_PRINT);

  file_put_contents($jsonFile, $updatedJsonData);

  echo 'Changes saved successfully.';
?>
