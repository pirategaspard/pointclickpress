<?php 

/* 
	SUPPORTED_SCREENS is a comma seperated list of 
	screen dimensions such as '640x480,800x600,'
	must be lowest to highest 
*/
$supported_screens = '480x320,640x480,800x600'; //,1024x768

/* 
	JPG image quality
*/
$image_quality = 50;

/* 
	Size of generated thumbnails
*/
$thumbnail_size = '100x100';

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
	Define constants
 */
define('UPLOAD_PATH', $upload_dir);
define('MEDIA_PATH', $media_dir);
define('IMAGE_QUALITY', $image_quality);
define('SUPPORTED_SCREENS', $supported_screens);
define('THUMBNAIL_IMAGE_SIZE', $thumbnail_size);
define('DEFAULT_PAGE_TITLE', "PointClickPress - ");
?>
