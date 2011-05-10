<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * Contains functions for frontend theme
 * */

class Model_PCP_Themes extends Model
{
	static function setTheme($args=array())
	{		
		$m = Kohana::modules();
		if(isset($args['theme_name']))
		{
			// add this story's theme to Kohana's module paths			
			$m['theme_name'] = APPPATH.THEMES_PATH.DIRECTORY_SEPARATOR.$args['theme_name'].DIRECTORY_SEPARATOR;			
		}
		$m['default_theme'] = APPPATH.THEMES_PATH.'/default';
		Kohana::modules($m);
	}
	
	static function getStyles($args=array())
	{
		$found_files = self::findFiles(THEMES_PATH.'/'.$args['theme_name'].'/css/','css');
		if (!isset($found_files['pcp.css']))
		{
			$found_files['pcp.css'] = self::find_file('css','pcp','css');			
		}	
		return $found_files;
	}
	
	static function getScripts($args=array())
	{				
		$found_files = self::findFiles(THEMES_PATH.'/'.$args['theme_name'].'/js/','js');
		if (!isset($found_files['pcp.js']))
		{
			$found_files['pcp.js'] = self::find_file('js','pcp','js');			
		}
		return $found_files;	
	}
	
	static private function findFiles($dir='',$type='')
	{		
		$found_files = array();
		$path = APPPATH.$dir;
		if(is_dir($path))
		{
			$files = scandir($path);
			foreach ($files as $file)
			{
				$pathinfo = pathinfo($path.$file);
				// if a file is php assume its a class 
				if ((isset($pathinfo['extension']))&&(($pathinfo['extension']) == $type))
				{
					$found_files[$file] = $dir.$file;		
				}
			}
		} 						
		return $found_files;
	}
	
	static private function find_file($dir='',$name='',$type='')
	{
		$file = Kohana::find_file($dir,$name,$type);
		if($file)
		{
			$file = str_replace('\\','/',str_replace(APPPATH,'',$file));
		}
		return $file;
	}
	
	static function getData()
	{
		$session = Session::instance();	
		$data = array();
		if ($session->get('theme_name'))
		{
			$data['theme_name'] = $session->get('theme_name');
		}
		else if ($session->get('story'))
		{
			$data['theme_name'] = $session->get('story')->theme_name;
		}
		else
		{
			$data['theme_name'] = 'default';
		}
		return $data;
	}
}