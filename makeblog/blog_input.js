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

function insertParagraph() {
    var editor = document.getElementById("editor");
    editor.innerHTML += '<br>';
}

function saveData() {
    var editor = document.getElementById("editor");
    var content = editor.innerHTML;

    var data = {
        content: content
    };

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "store_blog.php", true);
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert("Data saved successfully!");
        }
    };
    xhr.send(JSON.stringify(data));
}
document.getElementById("btnAddParagraph").addEventListener("click", function(event) {
event.preventDefault();

var paragraphsContainer = document.getElementById("paragraphsContainer");

var paragraphGroup = document.createElement("div");
paragraphGroup.className = "paragraph-group";

var label = document.createElement("label");
label.textContent = "New paragraph";

var textarea = document.createElement("textarea");
textarea.className = "content";
textarea.name = "content[]";
textarea.required = true;

var removeButton = document.createElement("button");
removeButton.className = "btn btn-remove-paragraph";
removeButton.textContent = "Remove";

removeButton.addEventListener("click", function() {
paragraphGroup.remove();
});

paragraphGroup.appendChild(label);
paragraphGroup.appendChild(textarea);
paragraphGroup.appendChild(removeButton);

paragraphsContainer.appendChild(paragraphGroup);
});

document.getElementById("blogForm").addEventListener("submit", function(event) {
event.preventDefault();

var title = document.getElementById("title").value;
var author = document.getElementById("author").value;
var contentInputs = document.getElementsByClassName("content");
var image = document.getElementById("image").value;
var image2 = document.getElementById("image2").value;

var timestamp = new Date().toLocaleString();

var content = [];

for (var i = 0; i < contentInputs.length; i++) {
var paragraph = contentInputs[i].value.trim();
if (paragraph !== "") {
content.push(paragraph);
}
}

var blogData = {
title: title,
author: author,
content: content,
image: image,
image2: image2,
timestamp: timestamp
};

var jsonData = JSON.stringify(blogData);

var xhr = new XMLHttpRequest();
xhr.open("POST", "store_blog.php", true);
xhr.setRequestHeader("Content-type", "application/json");
xhr.onreadystatechange = function() {
if (xhr.readyState === 4 && xhr.status === 200) {
alert("Blog added successfully!");
location.reload();
}
};
xhr.send(jsonData);
});
