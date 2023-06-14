
<?php
$blogData = json_decode(file_get_contents('php://input'), true);

$blogs = [];
if (file_exists('blogs.json')) {
  $blogs = json_decode(file_get_contents('blogs.json'), true);
}

$blogs[] = $blogData;

file_put_contents('blogs.json', json_encode($blogs));

http_response_code(200);
?>



