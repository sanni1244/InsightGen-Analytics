<?php
$blogData = json_decode(file_get_contents('php://input'), true);

$blogs = [];
if (file_exists('../json/blogs.json')) {
    $blogs = json_decode(file_get_contents('../json/blogs.json'), true);
}

array_unshift($blogs, $blogData); 

usort($blogs, function($a, $b) {
    $timestampA = DateTime::createFromFormat('d/m/Y, H:i:s', $a['timestamp'])->getTimestamp();
    $timestampB = DateTime::createFromFormat('d/m/Y, H:i:s', $b['timestamp'])->getTimestamp();

    return $timestampB - $timestampA;
});

file_put_contents('../json/blogs.json', json_encode($blogs, JSON_PRETTY_PRINT));

http_response_code(200);
?>
