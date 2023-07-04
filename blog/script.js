var xhr = new XMLHttpRequest();
xhr.open("GET", "../json/blogs.json", true);
xhr.onreadystatechange = function () {
  if (xhr.readyState === 4 && xhr.status === 200) {
    var blogs = JSON.parse(xhr.responseText);
    displayBlogs(blogs);
  }
};
xhr.send();

function displayBlogs(blogs) {
  var visibleBlogs = blogs
    .map(function (blog, index) {
      blog.id = index; 
      return blog;
    })
    .filter(function (blog) {
      return (
        !blog.visibility ||
        blog.visibility.toLowerCase() !== "hidden"
      );
    });

  visibleBlogs.sort(function (a, b) {
    var timestampA = new Date(convertTimestampFormat(a.timestamp)).getTime();
    var timestampB = new Date(convertTimestampFormat(b.timestamp)).getTime();
    return timestampB - timestampA;
  });

  var blogContainer = document.getElementById("blogContainer");
  var prevBtn = document.getElementById("prevBtn");
  var nextBtn = document.getElementById("nextBtn");

  var currentPage = 0;
  var blogsPerPage = 6;
  var totalPages = Math.ceil(visibleBlogs.length / blogsPerPage);

  function showBlogs(page) {
    blogContainer.innerHTML = "";

    var startIndex = page * blogsPerPage;
    var endIndex = Math.min(startIndex + blogsPerPage, visibleBlogs.length);

    for (var i = startIndex; i < endIndex; i++) {
      var blog = visibleBlogs[i];
      var blogElement = document.createElement("div");
      var blogImage = document.createElement("div");
      var blogDetails = document.createElement("div");

      blogElement.classList.add("blog", "col-md-6", "col-lg-4");

      blogImage.classList.add("blog-image");
      var imageElement = document.createElement("img");
      imageElement.src = blog.image;
      blogImage.appendChild(imageElement);

      blogDetails.classList.add("blog-details");
      var titleElement = document.createElement("h3");
      titleElement.classList.add("blog-title");
      titleElement.textContent = blog.title;
      blogDetails.appendChild(titleElement);

      var contentElement = document.createElement("div");
      contentElement.classList.add("blog-content");
      contentElement.innerHTML = getSummary(blog.content, 20);
      blogDetails.appendChild(contentElement);

      var readMoreLink = document.createElement("a");
      readMoreLink.classList.add("blog-readmore");
      readMoreLink.textContent = "Read More";
      readMoreLink.href = "../show/index.html?id=" + blog.id; // Use the assigned id
      blogDetails.appendChild(readMoreLink);

      blogElement.appendChild(blogImage);
      blogElement.appendChild(blogDetails);
      blogContainer.appendChild(blogElement);
    }

    function getSummary(content, numWords) {
        var words = String(content).split(" ");
        var summary = words.slice(0, numWords).join(" ");
        if (words.length > numWords) {
          summary += "...";
        }
        return summary;
      }    if (currentPage === 0) {      prevBtn.style.display = "none";
    } else {
      prevBtn.style.display = "inline-block";
    }

    if (currentPage === totalPages - 1) {
      nextBtn.style.display = "none";
    } else {
      nextBtn.style.display = "inline-block";
    }
  }

  showBlogs(currentPage);

  prevBtn.addEventListener("click", function () {
    if (currentPage > 0) {
      currentPage--;
      showBlogs(currentPage);
    }
  });

  nextBtn.addEventListener("click", function () {
    if (currentPage < totalPages - 1) {
      currentPage++;
      showBlogs(currentPage);
    }
  });
}

function convertTimestampFormat(timestamp) {
  var parts = timestamp.split(/[\s,]+/);
  var dateParts = parts[0].split("/");
  var timeParts = parts[1].split(":");
  var month = parseInt(dateParts[1]) - 1; 
  var formattedTimestamp = `${dateParts[1]}/${dateParts[0]}/${dateParts[2]}, ${timeParts[0]}:${timeParts[1]}:${timeParts[2]}`;
  return formattedTimestamp;
}

window.onload = function () {
  var shortenedUrl = "https://insightb-analytics.com/blog";

  window.history.replaceState({}, document.title, shortenedUrl);
};
