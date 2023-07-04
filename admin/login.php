
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include("../admin/connection.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $hashedPassword = password_hash($row['password'], PASSWORD_DEFAULT);
    if (password_verify($password, $hashedPassword)) {
        $error = "Authentication successful!";
        $_SESSION['success'] = 1;
        echo "<meta http-equiv='refresh' content='1.5; url=../admin/decision.php'>";
    } else {
        $error =  "Invalid password!";
    }
  } else {
    $error =  "Invalid username!";
  }
  $stmt->close();
  $conn->close();
}
?>

