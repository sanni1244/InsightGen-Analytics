<?php

  $blogId = $_POST['blogId'];
  $likes = intval($_POST['newData']);

  $jsonString = file_get_contents('../json/blogs.json');
  $blogs = json_decode($jsonString, true);
  
  // Update the likes count
  $blogs[$blogId]['likes'] = $likes;

  // Save the updated data back to the JSON file
  $jsonString = json_encode($blogs, JSON_PRETTY_PRINT);
  file_put_contents('../json/blogs.json', $jsonString);
echo "Data saved successfully!";



?>
