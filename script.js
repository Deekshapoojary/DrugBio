// Set the time for displaying the cover image (in milliseconds)
const displayTime = 5000;

// Wait for the page to load
window.onload = function () {
  // Display the cover image
  document.getElementById('coverImage').style.display = 'block';

  // Wait for the image to load
  document.getElementById('coverImage').onload = function() {
    // Set a timeout to hide the cover image after the specified time
    setTimeout(function () {
      document.getElementById('coverImage').style.display = 'none';
      document.getElementById('content').style.display = 'none';

      // Redirect to the next page
      window.location.href = 'next_page.html'; // Replace 'next_page.html' with the actual URL of the next page
    }, displayTime);
  };
};