<?php
session_start();

session_unset(); 
session_destroy(); 

echo "Logged out successfully!";
echo "<meta>";
?>

<meta http-equiv="refresh" content="1; url=../index.html">