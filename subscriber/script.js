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
          emailList.appendChild(row);
        });
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
