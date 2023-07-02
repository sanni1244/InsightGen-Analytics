<!DOCTYPE html>
<html>
<head>
  <title>Edit the home page</title>
  <link rel="shortcut icon" href="../img/fav.png" type="image/x-icon">
</head>
<body>
  <h1>Home Page Editor</h1>
  <div id="section-selector">
    <ul class="section-list">
    </ul>
  </div>
<a href="../admin/logout.php"><div class="logout">Log Out</div></a>
  <div id="section-editor">
    <h2>Section Editor</h2>
    <textarea id="section-content"></textarea>
    <button onclick="saveChanges()">Save Changes</button>
    <button onclick="refresh()">Go Back</button>

    <p id="save-message"></p>
  </div>
<?php 
  session_start();
  if($_SESSION['success'] !== 1){
    header("location: ../admin/index.php");
  }
?>
  <script>
    var selectedSection = null;
    var data = {};

    var sectionDisplayNames = {
  title: 'Company Name',
  motto: 'Company Motto',
  vision: 'Vision',
  serviceHeader: 'Service Section Header',
  serviceAbout: 'About our Services',
  service1: 'About Services Option 1',
  service1C: 'About Services 1 Content',
  service2: 'About Services Option 2',
  service2C: 'About Services 2 Content',
  service3: 'About Services Option 3',
  service3C: 'About Services 3 Content',
  service4: 'About Services Option 4',
  service4C: 'About Services 4 Content',
  service5: 'About Services Option 5',
  service5C: 'About Services 5 Content',

  heroImage: "Landing page image",
  serviceImg: "Image in the service section",
  about: "What we provide (Header)",
  firstabout: "What we provide (Option 1)",
  firstaboutContent: "What we provide (Option 1 text)",
  secondabout: "What we provide (Option 2)",
  secondaboutContent: "What we provide (Option 2 text)",
  thirdabout: "What we provide (Option 3)",
  thirdaboutContent: "What we provide (Option 3 text)",
  forthabout: "What we provide (Option 4)",
  forthaboutContent: "What we provide (Option 4 text)",
  fifthabout: "What we provide (Option 5)",
  fifthaboutContent: "What we provide (Option 5 text)",

  opportunity: "Why Choose Us (Header)",
  opportunity1: "Why Choose Us (Option 1)",
  opportunity1Content: "Why Choose Us (Option 1 text)",
  opportunity2: "Why Choose Us (Option 2)",
  opportunity2Content: "Why Choose Us (Option 2 text)",
  opportunity3: "Why Choose Us (Option 3)",
  opportunity3Content: "Why Choose Us (Option 3 text)",
  opportunity4: "Why Choose Us (Option 4)",
  opportunity4Content: "Why Choose Us (Option 4 text)",
  
  
  aboutiba: "About the company",
  address: "Offive address",
  telephone: "Phone-Text",
  telephonetext: "Phone Number",
  mail: "Mail-Text",
  mailtext: "Mail",
  facebook: "Facebook link",
  twitter: "Twitter link",
  linkedin: "Linkedin link",
  instagram: "Instagram link",
};

function refresh(){
    location.reload();
}
    // Fetch JSON data from external file
    fetch('../json/content.json')
      .then(response => response.json())
      .then(jsonData => {
        data = jsonData;
        populateSectionList();
      })
      .catch(error => console.error('Error fetching JSON:', error));

    function populateSectionList() {
      var sectionList = document.querySelector('.section-list');
      sectionList.innerHTML = '';

      for (var key in data) {
    var listItem = document.createElement('li');
    listItem.className = 'section-item';
    var displayText = sectionDisplayNames[key] || key; 
    listItem.textContent = displayText;
    listItem.setAttribute('data-section', key);
    listItem.addEventListener('click', selectSection);
    sectionList.appendChild(listItem);
  }
}

    function selectSection(event) {
      var section = event.target.getAttribute('data-section');
      selectedSection = section;
      document.getElementById('section-content').value = data[section];
      document.getElementById('section-editor').style.display = 'block';
      document.getElementById('section-selector').style.display = 'none';
    }

    function saveChanges() {
      var newContent = document.getElementById('section-content').value;
      data[selectedSection] = newContent;

      fetch('./save_changes.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
        .then(response => response.text())
        .then(message => {
          console.log(message);
          selectedSection = null;
          document.getElementById('section-content').value = '';
          document.getElementById('section-editor').style.display = 'none';
          document.getElementById('section-selector').style.display = 'block';
        })
        .catch(error => console.error('Error saving changes:', error));
    }
  </script>
</body>
</html>


<style>
  @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

body {
  font-family: 'Montserrat', sans-serif;
  margin: 20px;
  background-color: #f5f5f5;
  overflow-x: hidden;
}

h1 {
  margin-bottom: 20px;
  font-size: 28px;
  color: #333;
}

label {
  font-weight: bold;
  display: block;
  margin-bottom: 5px;
}

input[type="text"],
textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

.section-list {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: 10px;
  list-style-type: none;
  padding: 0;
}

.section-item {
  padding: 10px;
  cursor: pointer;
  font-size: 14px;
  color: #444;
  background-color: #fff;
  transition: transform 0.3s ease, background-color 0.3s ease;
}

.section-item:hover {
  transform: scale(1.05);
  background-color: #f2f2f2;
}

.active {
  background-color: #f2f2f2;
  font-weight: bold;
}

.save-button {
  margin-top: 20px;
  background-color: #4CAF50;
  color: #fff;
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.save-button:hover {
  background-color: #45a049;
}

#section-editor {
  display: none;
  animation: slideInUp 0.5s ease;
}

#section-editor h2 {
  font-size: 20px;
  margin-bottom: 10px;
  color: #333;
}

#section-content {
  height: 150px;
  font-size: 16px;
}

#save-message {
  margin-top: 10px;
  color: #4CAF50;
  font-size: 14px;
}

@keyframes slideInUp {
  0% {
    transform: translateY(50px);
    opacity: 0;
  }
  100% {
    transform: translateY(0);
    opacity: 1;
  }
}

@media screen and (max-width: 768px) {
  h1 {
    font-size: 24px;
  }

  .section-list {
    grid-template-columns: 1fr;
  }
}
.logout{
    background-color: #444;
    color: #ffffff;
    border: none;
    width: 150px;
    height: 40px;
    position: absolute;
    top: 10px; 
    right: 10px; 
    display: flex;
    align-items: center;
    justify-content: center;
}
.logout a{
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
}
</style>