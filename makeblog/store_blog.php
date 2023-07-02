<?php
$blogData = json_decode(file_get_contents('php://input'), true);

$blogs = [];
if (file_exists('../json/blogs.json')) {
    $blogs = json_decode(file_get_contents('../json/blogs.json'), true);
}
array_unshift($blogs, $blogData); // Add the new blog data to the beginning of the array

file_put_contents('../json/blogs.json', json_encode($blogs));

http_response_code(200);
?>