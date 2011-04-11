<?php defined('SYSPATH') or die('No direct script access.');

class Model_PCP_Storydata
{	
	static function getStorydata()
	{
		$s = Session::Instance();
		return $s->get('story_data',array());
	}
	
	static function setStorydata($story_data=array())	
	{
		$s = Session::Instance();
		$s->set('story_data',$story_data);
		return $story_data;	
	}
	
	static function set($key='',$value='')
	{
		if (strlen($key)>0)
		{	
			$story_data = self::getStorydata();
			$story_data[$key] = $value;
			self::setStorydata($story_data);
		}
	}
	
	static function get($key='',$default='')	
	{
		$results = $default;
		if (strlen($key)>0)
		{
			$story_data = self::getStorydata();
			if (isset($story_data[$key]))
			{
				$results = $story_data[$key];
			}
		}
		return $results;
	}	
		
}
