<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Email Sender</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="style.css">


  <script src="https://cdn.tiny.cloud/1/wm1ifuosjfnw8gkar6k53147ujne8pexrnxek34qajyqroud/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <?php
session_start();
if (empty($_SESSION['success'])) {
  header("location:../admin/index.php");
}
?>
  </head>
<body>
   <div class="container">
   <a href="../admin/logout.php" class="logout-button">Log Out</a>

    <h1>Email Sender</h1>

    

    <div class="message-section">
      <h2>Compose Email</h2>
      <div>
        <label for="subjectInput">Subject:</label>
        <input type="text" id="subjectInput" placeholder="Enter the subject">
      </div>
      <div>
        <label for="messageInput">Message:</label>
        <textarea id="messageInput"></textarea>
      </div>
    </div>
    
    <div class="email-section">
      <h2>Email Addresses</h2>
      <label>
        <input type="checkbox" id="selectAllEmailsButton">
        Select All
      </label>
      <table id="emailList">
      </table>
      
    </div>
    <div class="button-section">
      <button id="sendButton">Send</button>
    </div>
  </div>



  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
  </script>

  <script src="script.js"></script>
</body>
</html>

