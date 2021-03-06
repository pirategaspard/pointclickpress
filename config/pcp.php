<?php 
/*
	default page title:
*/
$default_page_title = 'PointClickPress - ';

/* 
	
*/
$admin_email_address = 'Admin@pointclickpress.org';

/*
	default theme
*/
$default_theme_name = 'default';

/* 
	SUPPORTED_SCREENS is a comma seperated list of 
	screen dimensions such as '640x480,800x600,'
	must be lowest to highest 
*/
$supported_screens = '480x320,800x480'; // Default sizes

/* 
	JPG image quality
*/
$image_quality = 65;

/* 
	Size of generated thumbnails
*/
$thumbnail_size = '100x100'; // square
//$thumbnail_size = '240x160'; // wide

/* 
	Default screen size for admin
	(must be a size in the suppored_screens list)
*/
//$story_size = '640x480'; // standard
$default_screen_size = '800x480'; // wide

/*
	supported grid sizes:
*/
$supported_grid_sizes = '5x5,10x10,20x20';

/*
	default cache driver
*/
$cache_driver = 'file';

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
	What is the name of the themes directory
*/
$themes_dir = 'themes';

/* 
	Define configuration constants
 */
define('DEFAULT_PAGE_TITLE', $default_page_title);
define('DEFAULT_THEME_NAME', $default_theme_name);  
define('UPLOAD_PATH', $upload_dir);
define('MEDIA_PATH', $media_dir);
define('THEMES_PATH', $themes_dir);
define('IMAGE_QUALITY', $image_quality);
define('SUPPORTED_SCREENS', $supported_screens);
define('SUPPORTED_GRID_SIZES', $supported_grid_sizes);
define('SCENE_IMAGE_REDUCTION_PERCENT',1);
$defaults = explode('x',$default_screen_size);
define('DEFAULT_SCREEN_SIZE', $default_screen_size);
define('DEFAULT_SCREEN_WIDTH', $defaults[0]);
define('DEFAULT_SCREEN_HEIGHT', $defaults[1]);
$defaults = explode('x',$thumbnail_size);
define('THUMBNAIL_IMAGE_SIZE', $thumbnail_size);
define('THUMBNAIL_IMAGE_WIDTH', $defaults[0]);
define('THUMBNAIL_IMAGE_HEIGHT', $defaults[1]);
define('ADMIN_EMAIL_ADDRESS', $admin_email_address);

define('DEFAULT_VALUE', '');
define('DEFAULT_ITEMSTATE_VALUE', DEFAULT_VALUE);
define('DEFAULT_SCENE_VALUE', DEFAULT_VALUE);

define('CACHE_DRIVER', $cache_driver); 



// event constants
define('ACTION_TYPE_NULL', ''); 
define('ACTION_TYPE_ITEMDEF', 'itemdef'); 
define('ACTION_TYPE_ITEMSTATE', 'itemstate'); 
define('ACTION_TYPE_GRIDITEM', 'griditem'); 
define('ACTION_TYPE_GRID', 'grid'); 
define('ACTION_TYPE_SCENE', 'scene'); 
define('ACTION_TYPE_LOCATION', 'location'); 
define('ACTION_TYPE_STORY', 'story'); 

// item constants
define('ITEM_TYPE_NULL', ''); 
define('ITEM_TYPE_DEF', 'itemdef'); 
define('ITEM_TYPE_GRID', 'grid'); 
define('ITEM_TYPE_INSTANCE', 'scene'); 

require 'events.php';

?>
