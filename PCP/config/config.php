<?php 


/* 
	What is the name of the temporary storage space for uploaded files? 
*/
$upload_dir = 'uploads';


/* 
	What is the name of the storage space for media that supports  
	created Interactive Stories?
*/
$media_dir = 'media';

/* 
	SUPPORTED_SCREENS is a comma seperated list of 
	screen dimensions such as '640x480,800x600,'
	must be lowest to highest 
*/
$supported_screens = '480x320,640x480,800x600'; //,1024x768


/* 
	Define as global values
 */
define('UPLOAD_PATH', $upload_dir.DIRECTORY_SEPARATOR);
define('MEDIA_PATH', $media_dir.DIRECTORY_SEPARATOR);
define('IMAGE_QUALITY', 90);
define('SUPPORTED_SCREENS', $supported_screens);

?>
