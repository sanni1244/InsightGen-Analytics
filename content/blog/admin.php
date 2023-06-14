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
<?php include('./login.php') ?>
<body>
  <div class="container">
    <h2>Login</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
      </div>
      <button type="submit" class="btn btn-login">Login</button>
      <button type="submit" class="btn logout"><a href="./blog_display.html">Go back</a></button>
    </form>
  </div>
  <div class="usererror">
    <?php echo @$error ?>
  </div>
</body>
</html>
<style>
  body {
    background-color: #f8f9fa;
  }
  .container {
    margin-top: 100px;
    max-width: 400px;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 5px;
    background-color: #fff;
  }
  .form-group {
    margin-bottom: 20px;
  }
  .form-group label {
    font-weight: bold;
  }
  .btn-login {
    background-color: #007bff;
    color: #fff;
    border-radius: 20px;
    padding: 10px 20px;
  }
  .usererror {
    color: red;
    text-align: center;
  }
</style>