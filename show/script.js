window.onload = function () {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var jsonData = JSON.parse(xhr.responseText);
      document.getElementById("about-iba").innerText = jsonData.aboutiba;
      document.getElementById("facebook").href = jsonData.facebook;
      document.getElementById("instagram").href = jsonData.instagram;
      document.getElementById("twitter").href = jsonData.twitter;
      document.getElementById("linkedin").href = jsonData.linkedin;
      document.getElementById("telephone1").href = jsonData.telephone1;
      document.getElementById("telephone1").innerText = jsonData.telephonetext1;
      document.getElementById("telephone2").href = jsonData.telephone2;
      document.getElementById("telephone2").innerText = jsonData.telephonetext2;
      document.getElementById("telephone3").href = jsonData.telephone3;
      document.getElementById("telephone3").innerText = jsonData.telephonetext3;
      document.getElementById("telephone4").href = jsonData.telephone4;
      document.getElementById("telephone4").innerText = jsonData.telephonetext4;
      document.getElementById("mail").href = jsonData.mail;
      document.getElementById("mail").innerText = jsonData.mailtext;
      document.getElementById("address1").innerText = jsonData.address1;
      document.getElementById("address2").innerText = jsonData.address2;
    }
  };
  xhr.open("GET", "../json/content.json", true);
  xhr.send();
};

$(document).ready(function () {
  var urlParams = new URLSearchParams(window.location.search);
  var blogId = urlParams.get('id');
  if (blogId !== null) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../json/blogs.json", true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var blogs = JSON.parse(xhr.responseText);
        displayBlogDetails(blogs[blogId]);
      }
    };
    xhr.send();
  } else {
    window.location.href = "../blog/index.html";
  }

  function displayBlogDetails(blog) {
    $.getJSON('../json/blogs.json', function (data) {
      var blogItem = data[blogId];
      if (typeof blogItem !== 'undefined' && typeof blogItem.title !== 'undefined' && blogItem.visibility.toLowerCase() !== 'hidden' && blogItem.visibility.toLowerCase() !== 'hide') {
        $('#blogTitle').text(blogItem.title);
        $('#blogAuthor').text("Writer: ",blogItem.author);
        $('#timeStamp').text(blogItem.timestamp);
        $('#blogContent').html(blogItem.content);
        $('#blogImage').attr('src', blogItem.image);
        $('#blogImage2').attr('src', blogItem.image2);
        $('#likeCount').text(blogItem.likes);
        var liked = localStorage.getItem('liked_' + blogId);
        if (liked === 'true') {
          $('#likeButton').html('<i class="fas fa-thumbs-down"></i> Dislike');
          $('#likeButton').attr('data-liked', 'true');
        } else {
          $('#likeButton').html('<i class="fas fa-thumbs-up"></i> Like');
          $('#likeButton').attr('data-liked', 'false');
        }
      } else {
        window.location.href = "../blog/index.html";
      }
    });

    $('#likeButton').click(function () {
      var liked = $('#likeButton').attr('data-liked');
      var likeCount = parseInt($('#likeCount').text());
      if (liked === 'false') {
        likeCount += 1;
        $('#likeCount').text(likeCount);
        $('#likeButton').html('<i class="fas fa-thumbs-down"></i> Dislike');
        $('#likeButton').attr('data-liked', 'true');
      } else {
        likeCount -= 1;
        $('#likeCount').text(likeCount);
        $('#likeButton').html('<i class="fas fa-thumbs-up"></i> Like');
        $('#likeButton').attr('data-liked', 'false');
      }
      $.getJSON('../json/blogs.json', function (data) {
        data[blogId].likes = likeCount;
        saveDataToJSON(data);
      });
      localStorage.setItem('liked_' + blogId, liked === 'true' ? 'false' : 'true');
    });

    function saveDataToJSON(data) {
      $.ajax({
        type: 'POST',
        url: 'save_likes.php',
        data: { blogs: JSON.stringify(data) },
        success: function () {
          console.log("Data saved");
        }
      });
    }

    document.title = blog.title;
    window.onload = function () {
      window.history.replaceState({}, document.title);
    };
  }

  function displayBlog(blog, z) {
    if (
      typeof blog.title !== 'undefined' &&
      blog.visibility !== "hidden" &&
      blog.visibility !== "hide" &&
      blog.visibility !== "Hide" &&
      blog.visibility !== "Hidden"
    ) {
      var blogContainer = document.getElementById("recommendations");

      var titleElement = document.createElement("h2");
      titleElement.textContent = blog.title;

      var anchor = document.createElement("a");
      anchor.href = "./index.html?id=" + z;
      anchor.appendChild(titleElement);
      blogContainer.appendChild(anchor);
    }
  }

  fetch("../json/blogs.json")
    .then((response) => response.json())
    .then((data) => {
      var blogTitle = '';
      if (typeof data[blogId] !== 'undefined' && typeof data[blogId].title !== 'undefined') {
        blogTitle = data[blogId].title;
      }
      var visibleBlogs = data.filter(
        (blog) =>
          typeof blog.title !== 'undefined' &&
          blog.title.toLowerCase() !== blogTitle.toLowerCase() &&
          blog.visibility !== "hidden" &&
          blog.visibility !== "hide" &&
          blog.visibility !== "Hide" &&
          blog.visibility !== "Hidden"
      );

      var a, b, c;

      if (visibleBlogs.length > 0) {
        a = data.findIndex((blog) => blog.title === visibleBlogs[0].title);
        if (visibleBlogs.length > 1) {
          b = data.findIndex((blog) => blog.title === visibleBlogs[1].title);
          if (visibleBlogs.length > 2) {
            c = data.findIndex((blog) => blog.title === visibleBlogs[2].title);
          }
        }
      }

      displayBlog(visibleBlogs[0], a);
      displayBlog(visibleBlogs[1], b);
      displayBlog(visibleBlogs[2], c);
    });
});



