<?php
// Start or resume the session
session_start();

// Unset or destroy the session data
session_unset(); // Clears all session variables
session_destroy(); // Destroys the session

// Return a response message indicating successful logout
echo "Logged out successfully!";
echo "<meta>";
?>

<meta http-equiv="refresh" content="1; url=../index.html">