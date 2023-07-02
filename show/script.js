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
    var blog = data[blogId];
    $('#blogTitle').text(blog.title);
    $('#blogAuthor').text(blog.author);
    $('#timeStamp').text(blog.timestamp);
    $('#blogContent').html(blog.content);
    $('#blogImage').attr('src', blog.image);
    $('#blogImage2').attr('src', blog.image2);
    $('#likeCount').text(blog.likes);
    var liked = localStorage.getItem('liked_' + blogId);
    if (liked === 'true') {
      $('#likeButton').html('<i class="fas fa-thumbs-down"></i> Dislike');
      $('#likeButton').attr('data-liked', 'true');
    } else {
      $('#likeButton').html('<i class="fas fa-thumbs-up"></i> Like');
      $('#likeButton').attr('data-liked', 'false');
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
function displayBlog(blogg, z) {
  if (
    blogg.visibility !== "hidden" &&
    blogg.visibility !== "hide" &&
    blogg.visibility !== "Hide" &&
    blogg.visibility !== "Hidden"
  ) {
    var blogContainer = document.getElementById("recommendations");

    var titleElement = document.createElement("h2");
    titleElement.textContent = blogg.title;

    var anchor = document.createElement("a");
    anchor.href = "./index.html?id=" + z;
    anchor.appendChild(titleElement);
    blogContainer.appendChild(anchor);
  }
}

fetch("../json/blogs.json")
  .then((response) => response.json())
  .then((data) => {
    var visibleBlogs = data.filter(
      (blog) =>
        blog.visibility !== "hidden" &&
        blog.visibility !== "hide" &&
        blog.visibility !== "Hide" &&
        blog.visibility !== "Hidden"
    );

    var a, b, c;

    if (visibleBlogs.length > 0) {
      a = data.indexOf(visibleBlogs[0]);
      if (visibleBlogs.length > 1) {
        b = data.indexOf(visibleBlogs[1]);
        if (visibleBlogs.length > 2) {
          c = data.indexOf(visibleBlogs[2]);
        }
      }
    }

    displayBlog(visibleBlogs[0], a);
    displayBlog(visibleBlogs[1], b);
    displayBlog(visibleBlogs[2], c);
  });

}
});