<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <title>Login Page</title>
</head>
<?php
  session_start();
  if($_SESSION['success'] !== 1){
    header("location: ./index.php");
  }
?>
<body>
  <div class="container">
    <a href="../edit/editflow.php">Edit Main Page</a>
      
      <a href="../makeblog/index.php">Create/Edit blogs</a>
      <button type="submit" class="btn logout"><a href="../index.html">Go back</a></button>
  </div>
  <div class="usererror">
    <?php echo @$error ?>
  </div>
</body>
</html>
<style>
  .container {
  margin-top: 100px;
  max-width: 400px;
  border: 1px solid #ddd;
  padding: 20px;
  border-radius: 5px;
  background-color: #fff;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
  text-align: center;
  transition: transform 0.3s;
}

.container:hover {
  transform: scale(1.02);
}

h2 {
  margin-bottom: 20px;
  color: #333;
}

a {
  display: block;
  margin-bottom: 10px;
  color: #007bff;
  text-decoration: none;
  font-size: 14px;
  transition: color 0.3s;
}

a:hover {
  color: #0056b3;
}

.btn-logout {
  background-color: #fff;
  color: #007bff;
  border: 1px solid #007bff;
  border-radius: 20px;
  padding: 6px 16px;
  font-size: 14px;
  transition: background-color 0.3s, color 0.3s;
}

.btn-logout:hover {
  background-color: #007bff;
  color: #fff;
}

.user-error {
  color: red;
  text-align: center;
  margin-top: 20px;
}

</style>