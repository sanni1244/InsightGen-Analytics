<?php
session_start();
if (empty($_SESSION['success'])) {
  header("location:../admin/index.php");
}
$conn = mysqli_connect('localhost', 'insigh28_table_user', '+w=+%#m?H__5', 'insigh28_iba_admins');

$query = "SELECT subscribers FROM subscribe";
$result = mysqli_query($conn, $query);

$emails = [];
while ($row = mysqli_fetch_assoc($result)) {
  $emails[] = $row['subscribers'];
}
mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($emails);
?>
