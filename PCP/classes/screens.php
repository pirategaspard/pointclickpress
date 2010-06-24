<?php defined('SYSPATH') or die('No direct script access.');

class Screens
{
	static function getScreens()
	{	
		/* 
			SUPPORTED_SCREENS is a comma seperated list of 
			screen dimensions such as '800x600,640x480' 
		*/
		$supported_screens = explode(',',SUPPORTED_SCREENS);		
		foreach ($supported_screens as $supported_screen)
		{
			$temp = explode('x',$supported_screen);
			$screens[] = array('w'=>$temp[0],'h'=>$temp[1]);
		}		
		return $screens;
	}
}
