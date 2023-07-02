<!DOCTYPE html>
<html lang="en">
  <title>Edit your blog</title>
<link rel="shortcut icon" href="../img/fav.png" type="image/x-icon">
<?php
  session_start();
  if (empty($_SESSION['success'])) {
    header("location:../admin/index.php");
  }
?>

<head>
  <title>Edit JSON File</title>
  <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <style>
    .container {
      max-width: 500px;
      margin: 50px auto;
    }

    .input-group {
      margin-bottom: 20px;
    }

    .input-group label {
      display: block;
      margin-bottom: 5px;
    }

    .input-group input,
    .input-group textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .save-btn {
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .delete-btn {
      padding: 10px 20px;
      background-color: #dc3545;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .selectblogbar {
      width: 100%;
      height: 2rem;
    }

    .btn a {
      text-decoration: none;
    }

    .cling {
      /* margin-top: 1rem; */
      font-size: 0.8rem;
      padding: 10px;
    }

    h2 {
      font-family: 'Arial Narrow Bold', sans-serif;
      font-weight: 600;
      font-size: 1.3rem;
      margin-top: 2rem;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Select Blog</h2>

    <select class="selectblogbar" id="selectObject">
      <option value="" disabled selected>Choose the Blog to edit</option>
    </select>

    <h2>Edit Blog Properties</h2>

    <div id="editContainer"></div>

    <button class="save-btn cling">Save Changes</button>
    <button class="delete-btn cling">Delete permanently</button>
    <button type="submit" class="btn" onclick="logout()"><a href="../blog/index.html">Log Out</a></button>

  </div>

  <script>
    $(document).ready(function () {
      var jsonFile = "../json/blogs.json";

      $.getJSON(jsonFile, function (data) {
        jsonData = data;
        var selectObject = $("#selectObject");
        jsonData.forEach(function (item) {
          selectObject.append($('<option>', {
            value: item.title,
            text: item.title
          }));
        });
      });

      // Event listener for selecting an object
      $("#selectObject").on("change", function () {
        var selectedTitle = $(this).val();
        var selectedObject = jsonData.find(obj => obj.title === selectedTitle);
        displayEditFields(selectedObject);
      });

      // Function to display edit fields
      function displayEditFields(selectedObject) {
        var editContainer = $("#editContainer");
        editContainer.empty();

        $.each(selectedObject, function (key, value) {
          var inputGroup = $("<div>").addClass("input-group");
          var label = $("<label>").text(key.charAt(0).toUpperCase() + key.slice(1));
          var input;

          if (key === "content") {
            var textarea = $("<textarea>").attr("name", key).text(value);
            input = $("<div>").append(textarea);
            CKEDITOR.replace(textarea[0]);
          } else {
            input = $("<input>").attr("name", key).attr("type", "text").val(value);
          }

          inputGroup.append(label, input);
          editContainer.append(inputGroup);
        });
      }

      $(".save-btn").on("click", function () {
        var selectedTitle = $("#selectObject").val();
        var selectedObject = jsonData.find(obj => obj.title === selectedTitle);

        $("#editContainer input, #editContainer textarea").each(function () {
          var key = $(this).attr("name");
          var value = (key === "content") ? CKEDITOR.instances[key].getData() : $(this).val();
          selectedObject[key] = value;
        });

        var updatedJsonData = JSON.stringify(jsonData, null, 2);

        $.ajax({
          url: "./save_changes.php",
          type: "POST",
          data: {
            updatedData: updatedJsonData
          },
          success: function () {
            alert("Changes saved successfully!");
            location.reload();
          },
          error: function () {
            alert("Error occurred while saving changes.");
          }
        });
      });

      $(".delete-btn").on("click", function () {
        var selectedTitle = $("#selectObject").val();
        var selectedIndex = jsonData.findIndex(obj => obj.title === selectedTitle);

        if (selectedIndex > -1) {
          jsonData.splice(selectedIndex, 1);

          var updatedJsonData = JSON.stringify(jsonData, null, 2);

          $.ajax({
            url: "./save_changes.php",
            type: "POST",
            data: {
              updatedData: updatedJsonData
            },
            success: function () {
              alert("Blog has been deleted successfully!");
              location.reload();
            },
            error: function () {
              alert("Error occurred while deleting object.");
            }
          });
        }
      });
    });
    function logout() {
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          console.log(xhr.responseText);
          window.location.href = "./index.php";
        }
      };
      xhr.open("GET", "./logout.php");
      xhr.send();
    }
  </script>

</body>

</html>