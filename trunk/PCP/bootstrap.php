<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}
/**
 * Set the default time zone.
 *
 * @see  http://docs.kohanaphp.com/about.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('America/Chicago');

/**
 * Set the default locale.
 *
 * @see  http://docs.kohanaphp.com/about.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://docs.kohanaphp.com/about.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
 
//__DIR__ support for PHP < 5.3
if (!defined('__DIR__')) { 
  class __FILE_CLASS__ { 
    function  __toString() { 
      $X = debug_backtrace(); 
      return dirname($X[1]['file']); 
    } 
  } 
  define('__DIR__', new __FILE_CLASS__); 
} 
//automatically create the base_url
$app_path = '/'.substr(strrchr(__DIR__,DIRECTORY_SEPARATOR),1).'/';
Kohana::init(array('base_url' => $app_path,'index_file' => '','profile'=>false));

/*
	Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/*
	Attach a file reader to config. Multiple readers are supported.
*/
Kohana::$config->attach(new Kohana_Config_File);

/*
	Enable modules. Modules are referenced by a relative or absolute path.
*/
Kohana::modules(array(
	'user'       => MODPATH.'authadmincustom',       // front and back end user admin
	'auth'       => MODPATH.'auth',       // Basic authentication
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	'database'   => MODPATH.'database',   // Database access
	'image'      => MODPATH.'image',      // Image manipulation
	'cache'      => MODPATH.'cache',      // Cache	
	'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	'pagination' => MODPATH.'pagination', // Paging of results
	//'email' => MODPATH.'email', // email
	));

// update cache driver
Cache::$default = CACHE_DRIVER;

// default session
Session::$default = 'PCP';

// cookie salt
Cookie::$salt = 'PCP';

// Route for User Area
Route::set('user', 'user(/<action>(/<id>))')
  ->defaults(array(    
    'controller' => 'user',
  ));
/*
// Route for Admin User Area
Route::set('adminuser', 'admin/user(/<action>(/<id>))')
  ->defaults(array(    
    'controller' => 'admin/user',
    'action'     => 'index',
  ));

  // Route for Admin User Area
Route::set('admin_user', 'admin_user(/<action>(/<id>))')
  ->defaults(array(    
    'controller' => 'admin/user',
    'action'     => 'index',
  ));
*/

// Route for PCP Admin Area
Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
  ->defaults(array(    
	'directory'  => 'admin',
    'controller' => 'story',
    'action'     => 'list',
  ));

// Route for Public Facing site
Route::set('default', '(<action>)')
	->defaults(array(
		'controller' => 'PCP',
		'action'     => 'index',
	));
