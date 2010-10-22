<?php 

/*
	default page title:
*/
$default_page_title = 'PointClickPress - ';

/* 
	SUPPORTED_SCREENS is a comma seperated list of 
	screen dimensions such as '640x480,800x600,'
	must be lowest to highest 
*/
$supported_screens = '480x320,640x480,800x480,800x600,1024x768';

/* 
	JPG image quality
*/
$image_quality = 90;

/* 
	Size of generated thumbnails
*/
$thumbnail_size = '100x100';

/*
	supported grid sizes:
*/
$supported_grid_sizes = '10x10,20x20,40x40';

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
	default cache driver
*/
$cache_driver = 'file';

/* 
	Define constants
 */
define('UPLOAD_PATH', $upload_dir);
define('MEDIA_PATH', $media_dir);
define('IMAGE_QUALITY', $image_quality);
define('SUPPORTED_SCREENS', $supported_screens);
define('THUMBNAIL_IMAGE_SIZE', $thumbnail_size);
define('SUPPORTED_GRID_SIZES', $supported_grid_sizes);
define('DEFAULT_PAGE_TITLE', $default_page_title);

define('DEFAULT_STORY_WIDTH', 800);
define('DEFAULT_STORY_HEIGHT', 600);
define('SCENE_IMAGE_REDUCTION_PERCENT',10);
define('CACHE_DRIVER', $cache_driver);

?>
