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
}
else{
  window.location.href = "../blog/index.html";
}

function displayBlogDetails(blog) {
  if(blog == null){
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

  var likeicon = document.createElement("div");
  likeicon.innerHTML = '<i class="far fa-thumbs-up"></i>';

  var likeval = document.createElement("span");

  likeval.innerText = "Likes: " + parseInt(blog.likes);
  
  
  
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

  thelikes.appendChild(likeicon);

  thelikes.appendChild(likeval);

  likeicon.addEventListener("click", function () {
    if (document.cookie.indexOf("functionRun=true") >= 0 && document.cookie.indexOf(window.location.href) >= 0) {
      alert("You have already given feedback on this page.");
      likeicon.innerHTML = '<i class="fas fa-thumbs-up"></i>';
    } 
    else {
      // Check if the user has previously liked the blogId
      var likedBlogs = JSON.parse(localStorage.getItem("likedBlogs")) || [];
      if (likedBlogs.includes(blogId)) {
        alert("You have already liked this blog.");
      } else {
        likedBlogs.push(blogId);
        localStorage.setItem("likedBlogs", JSON.stringify(likedBlogs));
        blog.likes = parseInt(blog.likes) + 1;
        likeval.innerText = "Likes: " + parseInt(blog.likes);
        likeicon.innerHTML = '<i class="fas fa-thumbs-up"></i>';
        thelikes.appendChild(likeval);        
        saveDataToJSON(blogId, blog.likes);
      }
    }
  });
  function saveDataToJSON(blogId, newData) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log("Liked");
      }
    };

    var params = "blogId=" + encodeURIComponent(blogId) + "&newData=" + encodeURIComponent(JSON.stringify(newData));
    xhr.open("POST", "./sav.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(params);
    console.log(blogId, newData);
  }

  function displayBlog(blogg, z) {
    if (
      blogg.visibility.toLowerCase() !== "hidden" && 
      blogg.visibility.toLowerCase() !== "hide"
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
        blog.visibility.toLowerCase() !== "hidden" && 
        blog.visibility.toLowerCase() !== "hide"
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
