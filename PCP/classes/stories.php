<?php defined('SYSPATH') or die('No direct script access.');

class Stories
{	
	static function getStory($args=array())
	{
		// get a single story object and populate it based on the arguments
		$story = new Model_story($args);
		$story->load($args);
		return $story;		
	}
	
	static function getStoryInfo($args=array())
	{
		// get a single storyinfo object and populate it based on the arguments
		$storyinfo = new Model_StoryInfo($args);
		$storyinfo->load($args);
		return $storyinfo;		
	}
	
	static function getStories($args=array())
	{				
		// get all the stories in the db
		$q = '	SELECT s.*
				FROM stories s
				WHERE 1 = 1 ';
				
		if (isset($args['story'])) $q .= 'AND s.id = :story'; //if we have a story id
		
		$q .= ' ORDER BY s.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['story']))	 $q->param(':story',$args['story']->id);
								
		$tempArray = $q->execute()->as_array();		
		
		$stories = array();
		foreach($tempArray as $a)
		{
			if(isset($args['include_containers'])) $a['include_containers'] = $args['include_containers'];
			if(isset($args['include_scenes'])) $a['include_scenes'] = $args['include_scenes'];
			if(isset($args['include_events'])) $a['include_events'] = $args['include_events'];
			
			$stories[$a['id']] = stories::getStory()->init($a);
		}
		return $stories;		
	}
}
