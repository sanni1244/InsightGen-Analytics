<?php
$servername = "localhost";
$username = "insigh28_table_user";
// $username = "root";

$password = "+w=+%#m?H__5";
// $password = "";

$dbname = "insigh28_iba_admins";



$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>