<?php
// $jsonFile = "blogs.json";

// if (isset($_POST['selectedIndex']) && isset($_POST['updatedObject'])) {
//   $selectedIndex = $_POST['selectedIndex'];
//   $updatedObject = json_decode($_POST['updatedObject'], true);

//   // Load JSON data from file
//   $jsonData = file_get_contents($jsonFile);
//   $data = json_decode($jsonData, true);

//   // Update the selected object in the data array
//   $data[count($data) - $selectedIndex - 1] = $updatedObject;

//   // Save the updated data to the JSON file
//   file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));

//   // Return a success response
//   http_response_code(200);
// } else {
//   // Return an error response
//   http_response_code(400);
// }
?>


<?php
$jsonFile = "blogs.json";

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
