var queryParams = new URLSearchParams(window.location.search);
var blogId = queryParams.get("id");

if (blogId !== null) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "../json/blogs.json", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var blogs = JSON.parse(xhr.responseText);
      displayBlogDetails(blogs[blogId]);
      // console.log(blogs[blogId])
    }
  };
  xhr.send();
} else {
  window.location.href = "../blog/index.html";
}

function displayBlogDetails(blog) {
  if (blog == null) {
    window.location.href = "../blog/index.html";
  }
  var blogDetails = document.getElementById("blogDetails");

  var titleElement = document.createElement("h3");
  titleElement.classList.add("blog-title");
  titleElement.textContent = blog.title;
  document.head.querySelector('title').textContent = blog.title;
  var imageElement = document.createElement("img");
  imageElement.classList.add("top-image");
  imageElement.src = blog.image;

  var imageElement2 = document.createElement("img");
  imageElement2.classList.add("top-image");
  imageElement2.src = blog.image2;

  var thelikes = document.createElement("div");
  var liked = localStorage.getItem('liked');
  if (liked === 'true') {
    $('#likeButton').html('<i class="fas fa-thumbs-down"></i> Dislike');
    $('#likeButton').attr('data-liked', 'true');
} else if (liked === 'false') {
    $('#likeButton').html('<i class="fas fa-thumbs-up"></i> Like');
    $('#likeButton').attr('data-liked', 'false');
}
$('#likeButton').click(function() {
  var liked = $(this).attr('data-liked');
  if (liked === 'false') {
    // Increment the like count
    var likeCount = parseInt($('#likeCount').text());
    $('#likeCount').text(likeCount + 1);
    $(this).html('<i class="fas fa-thumbs-down"></i> Dislike');
    $(this).attr('data-liked', 'true');


    $.getJSON('../json/blogs.json', function(data) {
      data.likes = likeCount + 1;
      $.ajax({
          type: 'POST',
          url: 'update_likes.php',
          data: { likes: data.likes },
          success: function() {
              // Store the like status in localStorage
              localStorage.setItem('liked', 'true');
          }
      });
  });


} else if (liked === 'true') {
  // Decrement the like count
  var likeCount = parseInt($('#likeCount').text());
  $('#likeCount').text(likeCount - 1);

  // Update the like button appearance and data attribute
  $(this).html('<i class="fas fa-thumbs-up"></i> Like');
  $(this).attr('data-liked', 'false');

  // Update the JSON file
  $.getJSON('../json/blogs.json', function(data) {
      data.likes = likeCount - 1;
      $.ajax({
          type: 'POST',
          url: 'update_likes.php',
          data: { likes: data.likes },
          success: function() {
              // Remove the like status from localStorage
              localStorage.removeItem('liked');
          }
      });
  });
}
});
  
  var authorElement = document.createElement("b");
  authorElement.classList.add("blog-author");
  authorElement.textContent = "By: " + blog.author;

  var timestampElement = document.createElement("i");
  timestampElement.classList.add("blog-timestamp");
  timestampElement.textContent = "Posted on: " + blog.timestamp;

  var contentElement = document.createElement("div");
  contentElement.classList.add("blog-content");

  var helloDiv = document.createElement("div");
  helloDiv.classList.add("space");
  helloDiv.appendChild(timestampElement);
  helloDiv.appendChild(authorElement);

  var paragraph = document.createElement("p");
  paragraph.innerHTML = blog.content;
  paragraph.classList.add("justright");
  contentElement.appendChild(paragraph);
  var imgTags = paragraph.getElementsByTagName("img");

  for (var i = 0; i < imgTags.length; i++) {
    var imgTag = imgTags[i];
    imgTag.classList.add("img-blog");
  }

  blogDetails.appendChild(titleElement);

  blogDetails.appendChild(helloDiv);

  blogDetails.appendChild(imageElement);

  blogDetails.appendChild(contentElement);

  blogDetails.appendChild(contentElement);

  // likeicon.addEventListener("click", function () {
  //   if (document.cookie.indexOf("functionRun=true") >= 0 && document.cookie.indexOf(window.location.href) >= 0) {
  //     alert("You have already given feedback on this page.");
  //   } else {
  //     // Check if the user has previously liked the blogId
  //     var likedBlogs = JSON.parse(localStorage.getItem("likedBlogs")) || [];
  //     if (likedBlogs.includes(blogId)) {
  //       alert("You have already liked this blog.");
  //     } else {
  //       likedBlogs.push(blogId);
  //       localStorage.setItem("likedBlogs", JSON.stringify(likedBlogs));

  //       blog.likes = parseInt(blog.likes) + 1;
  //       likeval.innerText = "Likes: " + parseInt(blog.likes);
  //       likeicon.innerHTML = '<i class="fas fa-thumbs-up"></i>';
  //       thelikes.appendChild(likeval);

  //       saveDataToJSON(blogId, blog.likes);
  //     }
  //   }
  // });

  // function saveDataToJSON(blogId, newData) {
  //   var xhr = new XMLHttpRequest();
  //   xhr.onreadystatechange = function () {
  //     if (xhr.readyState === 4 && xhr.status === 200) {
  //       console.log("Saved");
  //     }
  //   };
  
  //   var params = "blogId=" + encodeURIComponent(blogId) + "&newData=" + encodeURIComponent(JSON.stringify(newData));
  //   xhr.open("POST", "update_likes.php");
  //   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  //   xhr.send(params);
  // }
  

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

      blogDetails.appendChild(thelikes);
    }
  }

  if (blog.image2 !== "" && blog.image2 !== null) {
    blogDetails.appendChild(imageElement2);
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
      var blogData1 = visibleBlogs[0];
      var blogData2 = visibleBlogs[1];
      var blogData3 = visibleBlogs[2];
      a = 0;
      b = 1;
      c = 2;
      if (blogData1.title == blog.title) {
        var blogData1 = visibleBlogs[1];
        a = 1;
        var blogData2 = visibleBlogs[2];
        b = 2;
        var blogData3 = visibleBlogs[3];
        c = 3;
        displayBlog(blogData1, a);
        displayBlog(blogData2, b);
        displayBlog(blogData3, c);
      } else if (blogData2.title == blog.title) {
        var blogData1 = visibleBlogs[0];
        a = 0;
        var blogData2 = visibleBlogs[2];
        b = 2;
        var blogData3 = visibleBlogs[3];
        c = 3;
        displayBlog(blogData1, a);
        displayBlog(blogData2, b);
        displayBlog(blogData3, c);
      } else if (blogData3.title == blog.title) {
        var blogData1 = visibleBlogs[0];
        a = 0;
        var blogData2 = visibleBlogs[1];
        b = 1;
        c = 3;
        var blogData3 = visibleBlogs[3];
        displayBlog(blogData1, a);
        displayBlog(blogData2, b);
        displayBlog(blogData3, c);
      } else {
        displayBlog(blogData1, a);
        displayBlog(blogData2, b);
        displayBlog(blogData3, c);
      }
    });
}


  var liked = localStorage.getItem('liked');
  var savedBlogIds = JSON.parse(localStorage.getItem('blogIds')) || [];

  var liked = localStorage.getItem('liked');
  var savedBlogId = localStorage.getItem('blogId');

  if (liked === 'true' && savedBlogId === blogId) {
    $('#likeButton').html('<i class="fas fa-thumbs-down"></i> Dislike');
    $('#likeButton').attr('data-liked', 'true');
  } else {
    $('#likeButton').html('<i class="fas fa-thumbs-up"></i> Like');
    $('#likeButton').attr('data-liked', 'false');
  }

  $.getJSON('../json/blogs.json', function(data) {
    $('#likeCount').text(data.likes);

  });

  $('#likeButton').click(function() {
    // Store the scroll position when the button is clicked
    $(window).on('beforeunload', function() {
      localStorage.setItem('scrollPosition', $(window).scrollTop());
    });
    
    // Call the dotheadd function
    dotheadd();
  });

  function dotheadd() {
    console.log("Button was clicked");

    var liked = $('#likeButton').attr('data-liked');

    if (liked === 'false') {
      var likeCount = parseInt($('#likeCount').text());
      $('#likeCount').text(likeCount + 1);
      $('#likeButton').html('<i class="fas fa-thumbs-down"></i> Dislike');
      $('#likeButton').attr('data-liked', 'true');
      
      $.getJSON('../json/blogs.json', function(data) {
        data.likes = likeCount + 1;
        $.ajax({
          type: 'POST',
          url: '../addblog/sav.php',
          data: { blogId: blogId, likes: data.likes },
          success: function() {
            localStorage.setItem('liked', 'true');
            localStorage.setItem('blogId', blogId);
            saveDataToJSON(blogId, data.likes);
          }
        });
      });
    } else if (liked === 'true') {
      var likeCount = parseInt($('#likeCount').text());
      $('#likeCount').text(likeCount - 1);
      $('#likeButton').html('<i class="fas fa-thumbs-up"></i> Like');
      $('#likeButton').attr('data-liked', 'false');
      
      $.getJSON('../json/blogs.json', function(data) {
        data.likes = likeCount - 1;
        $.ajax({
          type: 'POST',
          url: '../addblog/sav.php',
          data: { blogId: blogId, likes: data.likes },
          success: function() {
            localStorage.removeItem('liked');
            localStorage.removeItem('blogId');
            saveDataToJSON(blogId, data.likes);
          }
        });
      });
    }
  }

function saveDataToJSON(blogId, newData) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      console.log("Saved");
    }
  };
  var params = "blogId=" + encodeURIComponent(blogId) + "&newData=" + encodeURIComponent(JSON.stringify(newData));
  xhr.open("POST", "./sav.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(params);
}
