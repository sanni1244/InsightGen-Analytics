<?php
$jsonFile = "../json/blogs.json";

if (isset($_POST['updatedData'])) {
  $updatedData = $_POST['updatedData'];

  // Save the updated data to the JSON file
  file_put_contents($jsonFile, $updatedData);

  // Return a success response
  http_response_code(200);
} else {
  // Return an error response
  http_response_code(400);
}
?>
