/*
  Screen.js is used to pre-select the user's screen size on story details
  so that the Intersctive Story can be displayed to fit their screen
*/

$(document).ready(function() 
{
	// get all screen size options in form 
	var screens = $('#screen_size option');
	var screenSize = '';
	// loop through and find largest size that fits current screen
	for(i=0;i<screens.length;i++)
	{
		s = screens[i].value.split('x');
		// is the screen size reported from JS less than or equal to the current screen option?  
		if((screen.width >= s[0])&&(screen.height >= s[1]))
		{
			width = s[0];
			height = s[1];
		}				
	}
	screenSize = width + 'x' + height
	// loop again and set matching screen option as selected on form
	for(i=0;i<screens.length;i++)
	{
		if (screenSize == screens[i].value)
		{
			screens[i].selected = 'selected';
		}
	}	
});