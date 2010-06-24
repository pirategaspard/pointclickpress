/*
  Screen.js is used to report the user's screen size to the server
  so that the Intersctive Story can be displayed to fit their screen
*/
$(document).ready(function() { 
	$.post('screenSize', {w: screen.width ,h: screen.height});
});
