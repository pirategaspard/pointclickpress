<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * Contains functions for frontend theme
 * */

class Model_PCP_Themes extends Model
{
	static function setTheme($args=array())
	{		
		$m = Kohana::modules();
		if(isset($args['theme']))
		{
			// add this story's theme to Kohana's module paths			
			$m['theme'] = APPPATH.THEMES_PATH.DIRECTORY_SEPARATOR.$args['theme'].DIRECTORY_SEPARATOR;			
		}
		$m['default_theme'] = APPPATH.THEMES_PATH.'/default';
		Kohana::modules($m);
	}
	
	static function getData()
	{
		$session = Session::instance();	
		$data = array();
		if ($session->get('theme'))
		{
			$data['theme'] = $session->get('theme')->theme;
		}
		else if ($session->get('story'))
		{
			$data['theme'] = $session->get('story')->theme;
		}
		return $data;
	}
}