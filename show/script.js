$(document).ready(function () {
  // Retrieve the blog ID from the link
  var urlParams = new URLSearchParams(window.location.search);
  var blogId = urlParams.get('id');
  blogId = 0;

  $.getJSON('../json/blogs.json', function (data) {
    // Get the blog object based on the blog ID
    var blog = data[blogId];

    // Display the blog content
    $('#blogTitle').text(blog.title);
    $('#blogAuthor').text(blog.author);
    $('#blogContent').html(blog.content);
    $('#blogImage').attr('src', blog.image);
    $('#blogImage2').attr('src', blog.image2);
    $('#likeCount').text(blog.likes);

    // Check if the blog is liked and update the like button accordingly
    var liked = localStorage.getItem('liked_' + blogId);
    if (liked === 'true') {
      $('#likeButton').html('<i class="fas fa-thumbs-down"></i> Dislike');
      $('#likeButton').attr('data-liked', 'true');
    } else {
      $('#likeButton').html('<i class="fas fa-thumbs-up"></i> Like');
      $('#likeButton').attr('data-liked', 'false');
    }
  });

  // Handle like button click
  $('#likeButton').click(function () {
    var liked = $('#likeButton').attr('data-liked');

    // Get the current like count from the DOM
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

    // Update the JSON data and save it
    $.getJSON('../json/blogs.json', function (data) {
      data[blogId].likes = likeCount;
      saveDataToJSON(data);
    });

    // Store the liked state in localStorage
    localStorage.setItem('liked_' + blogId, liked === 'true' ? 'false' : 'true');
  });

  function saveDataToJSON(data) {
    // Send the updated JSON data to the server
    $.ajax({
      type: 'POST',
      url: 'save_likes.php',
      data: { blogs: JSON.stringify(data) },
      success: function () {
        console.log("Data saved");
      }
    });
  }
});


window.onload = function () {
  window.history.replaceState({}, document.title);
}