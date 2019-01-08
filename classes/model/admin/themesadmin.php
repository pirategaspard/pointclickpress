<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * Contains functions for frontend scene data
 * */

class Model_Admin_ThemesAdmin extends Model_PCP_Themes 
{
	static function getThemes()
	{		
		$themes = array();
		$dir = THEMES_PATH;
		$files = scandir(APPPATH.$dir);
		foreach ($files as $file)
		{
			if(is_dir(APPPATH.$dir.DIRECTORY_SEPARATOR.$file) && (substr($file,0,1) != '.')&& (substr($file,0,1) != '~'))
			{
				$themes[$file] = APPPATH.$dir.DIRECTORY_SEPARATOR.$file.DIRECTORY_SEPARATOR;		
			}
		} 
		return $themes;
	}
	
	static function getThemePath($theme_name)
	{		
		return APPPATH.THEMES_PATH.DIRECTORY_SEPARATOR.$theme_name.DIRECTORY_SEPARATOR;		
	}
}