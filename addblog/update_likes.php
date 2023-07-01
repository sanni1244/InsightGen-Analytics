<?php
// Read the JSON file
$jsonFile = "../json/blogs.json";
$jsonData = file_get_contents($jsonFile);
$blogs = json_decode($jsonData, true);

// Get the blogId and new likes count from the POST data
$blogId = $_POST["blogId"];
$newLikes = $_POST["likes"];

// Update the likes count for the specified blog
$blogs[$blogId]["likes"] = $newLikes;

// Save the updated JSON data back to the file
file_put_contents($jsonFile, json_encode($blogs));

// Return a success response
http_response_code(200);
?>
