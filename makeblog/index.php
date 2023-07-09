<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create Blog</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="shortcut icon" href="../img/fav.png" type="image/x-icon">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <style>
     body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
    }
    .container {
      padding: 2rem;
      max-width: 600px;
      margin: 0 auto;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .editors {
      border-radius: 6px;
      margin-bottom: 1rem;
      height: 15rem;
      border: 3px solid #ddd;
      padding: 10px;
    }
    label {
      text-align: left;
      display: block;
      margin-bottom: 3px;
      font-weight: bold;
      margin: 16px 0 0 0;
    }

    input:not([type='checkbox']) {
      width: 100%;
      margin-bottom: 1rem;
      padding: 8px;
      border: 3px solid #ddd;
      border-radius: 5px;
      box-sizing: border-box;
    }

    .saveit {
      margin-top: 2rem;
      background-color: blueviolet;
      font-weight: 600;
      padding: 8px;
      border-radius: 10px;
      width: 8rem;
      margin-bottom: 4rem;
      display: block;
    }

    h2 {
      color: #333;
    }

    .submitit {
      background-color: #28a745;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }

    textarea {
      resize: vertical;
      max-height: 130px;
      min-height: 40px;
    }

    .visibility-container {
      margin-top: 1rem;
    }

    .visibility-label {
      display: inline-block;
      margin-right: 0.5rem;
      font-weight: bold;
    }

    .visibility-button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 8px 16px;
      border-radius: 5px;
      cursor: pointer;
    }

    .form-switch {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 3rem;
    }

    .editmod {
      position: absolute;
      right: 100px;
      top: 20px;
    }

    .editmod a {
      color: rgb(241, 162, 162);
      text-decoration: none;
    }

    .editmod a:hover {
      color: red;
    } 
    .btn a{
      text-decoration: none;
    }
  </style>
</head>

<body>
  <?php
  session_start();
  if (empty($_SESSION['success'])) {
    header("location:admin.php");
  }
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");


  ?>
  <div class="container">
    <div class="editmod"><a href="../admin/test2.php">Edit a blog instead</a></div>

    <h2>
      <center>Create Blog</center>
    </h2>
    <form id="blogForm">
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" required>
      </div>
      <div class="form-group">
        <div id="paragraphsContainer">
          <div class="paragraph-group"></div>
        </div>
      </div>
      <label for="content">Content</label>
      <div id="editor" class="editors" contenteditable="true"></div>
      <div class="format-buttons">
        <button onclick="format('bold')">Bold</button>
        <button onclick="format('italic')">Italic</button>
        <button onclick="format('underline')">Underline</button>
        <button onclick="increaseFontSize()">+</button>
        <button onclick="decreaseFontSize()">-</button>
      </div>
      <div class="form-group">
        <label for="image">Image URL</label>
        <input type="text" id="image" name="image" required>
      </div>
      <div class="form-group">
        <label for="image2">Second Image URL</label>
        <input type="text" id="image2" name="image2">
      </div>
      <div class="form-group">
        <label for="author">Author</label>
        <input type="text" id="author" name="author" required>
      </div>
      <div class="visibility-container form-check form-switch">
        <span class="form-check-label visibility-label" for="toggleSwitch">Hide blog from public</span>
        <input class="form-check-input fas" type="checkbox" id="toggleSwitch" onclick="toggleVisibility()">
      </div>
      <button type="submit" onclick="saveData()" class="btn-submit submitit">Submit</button>
      <button type="submit" class="btn" onclick="logout()"><a href="../blog/index.html">Log Out</a></button>

    </form>
  </div>
</body>

</html>
  <script>
    var visibilityButton = document.getElementById("visibilityButton");
    var visibilityIcon = document.getElementById("visibilityIcon");
    var visibility = true;

    function toggleVisibility() {
      visibility = !visibility;
      visibilityIcon.className = visibility ? "fas fa-eye" : "fas fa-eye-slash";
      visibilityButton.textContent = visibility ? "Visible" : "Hidden";
    }

    function format(command) {
      var editor = document.getElementById("editor");
      var selection = window.getSelection();
      var range = selection.getRangeAt(0);

      switch (command) {
        case 'bold':
          document.execCommand('bold', false, null);
          break;
        case 'italic':
          document.execCommand('italic', false, null);
          break;
        case 'underline':
          document.execCommand('underline', false, null);
          break;
      }
      range.collapse(false);
      selection.removeAllRanges();
      selection.addRange(range);
    }

    function increaseFontSize() {
      var editor = document.getElementById("editor");
      var currentFontSize = parseInt(window.getComputedStyle(editor, null).getPropertyValue('font-size'));
      var newFontSize = currentFontSize + 1;
      editor.style.fontSize = newFontSize + 'px';
    }

    function decreaseFontSize() {
      var editor = document.getElementById("editor");
      var currentFontSize = parseInt(window.getComputedStyle(editor, null).getPropertyValue('font-size'));
      var newFontSize = currentFontSize - 1;
      editor.style.fontSize = newFontSize + 'px';
    }

    function saveData() {
      var editor = document.getElementById("editor");
      var content = editor.innerHTML;
      event.preventDefault();

      var title = document.getElementById("title").value;
      var author = document.getElementById("author").value;
      var image = document.getElementById("image").value;
      var image2 = document.getElementById("image2").value;
      var visibilityOption = visibility ? "Visible" : "Hidden";

      var timestamp = new Date().toLocaleString();
      var nolikes = 0;
      var blogData = {
        title: title,
        author: author,
        content: content,
        image: image,
        image2: image2,
        visibility: visibilityOption,
        timestamp: timestamp,
        likes: nolikes
      };

      var jsonData = JSON.stringify(blogData);

      var xhr = new XMLHttpRequest();
      xhr.open("POST", "store_blog.php", true);
      xhr.setRequestHeader("Content-type", "application/json");
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          alert("Blog added successfully!");
          location.reload();
        }
      };

      xhr.send(jsonData);
    }
 
  function logout() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log(xhr.responseText);
        window.location.href = "../addblog/index.php";
      }
    };
    xhr.open("GET", "../admin/logout.php");
    xhr.send();


    window.onload = function () {
    var longUrl = "https://insightb-analytics.com/makeblog/index.php";
    var shortenedUrl = "https://insightb-analytics.com/makeblog/";

    // Update the URL in the browser's address bar
    window.history.replaceState({}, document.title, shortenedUrl);

  }
  }
</script>

