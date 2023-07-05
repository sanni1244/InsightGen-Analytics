<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Email Sender</title>
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
      <br>
      <div>
        <label for="messageInput">Message:</label>
        <textarea id="messageInput"></textarea>
      </div>
    </div>
    <br>
    <div class="button-section">
      <button id="sendButton">Send</button>
    </div>
    <br>
    <div class="email-section">
      <h2>Email Addresses</h2>
      <label>
        <input type="checkbox" id="selectAllEmailsButton">
        Select All
      </label>
      <table id="emailList">
      </table>
    </div>
  </div>

  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });

    window.addEventListener('DOMContentLoaded', () => {
      const emailList = document.getElementById('emailList');
      const selectAllEmailsButton = document.getElementById('selectAllEmailsButton');
      const sendButton = document.getElementById('sendButton');
      const subjectInput = document.getElementById('subjectInput');
      const messageInput = tinymce.get('messageInput');

      function getEmailAddresses() {
        fetch('get_emails.php')
          .then(response => response.json())
          .then(emails => {
            emailList.innerHTML = '';

            emails.forEach(email => {
              const row = document.createElement('tr');
              const checkboxCell = document.createElement('td');
              const checkbox = document.createElement('input');
              checkbox.type = 'checkbox';
              checkbox.name = 'emails[]';
              checkbox.value = email;
              checkboxCell.appendChild(checkbox);
              row.appendChild(checkboxCell);
              const emailCell = document.createElement('td');
              emailCell.textContent = email;
              row.appendChild(emailCell);
              const removeCell = document.createElement('td');
              const removeButton = document.createElement('button');
              removeButton.textContent = 'Remove';
              removeButton.addEventListener('click', () => {
                removeEmail(email);
              });
              removeCell.appendChild(removeButton);
              row.appendChild(removeCell);
              emailList.appendChild(row);
            });
          });
      }

      function removeEmail(email) {
        fetch('remove_email.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            email: email
          })
        })
          .then(response => {
            if (response.ok) {
              getEmailAddresses();
              alert('Email removed successfully!');
            } else {
              alert('Failed to remove email. Please try again.');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while removing the email.');
          });
      }

      getEmailAddresses();

      selectAllEmailsButton.addEventListener('click', () => {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="emails[]"]');
        checkboxes.forEach(checkbox => {
          checkbox.checked = selectAllEmailsButton.checked;
        });
      });

      sendButton.addEventListener('click', () => {
        const selectedEmails = Array.from(document.querySelectorAll('input[type="checkbox"][name="emails[]"]:checked'))
          .map(checkbox => checkbox.value);
        const subject = subjectInput.value;
        const message = messageInput.getContent();

        if (selectedEmails.length === 0) {
          alert('Please select at least one email address.');
          return;
        }

        if (subject.trim() === '') {
          alert('Please enter a subject.');
          return;
        }

        if (message.trim() === '') {
          alert('Please enter a message.');
          return;
        }

        fetch('send_emails.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            emails: selectedEmails,
            subject: subject,
            message: message
          })
        })
          .then(response => {
            if (response.ok) {
              alert('Emails sent successfully!');
              document.querySelectorAll('input[type="checkbox"][name="emails[]"]:checked').forEach(checkbox => {
                checkbox.checked = false;
              });
              subjectInput.value = '';
              messageInput.setContent('');
            } else {
              alert('Failed to send emails. Please try again.');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while sending emails.');
          });
      });
    });
  </script>

</body>
</html>
