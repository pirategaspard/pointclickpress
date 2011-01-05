<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * Contains functions for getting story and stories
 * To Do: move and rename this to StoriesAdmin.php?
 * */

class Model_Stories
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
				
		if (isset($args['story'])) $q .= ' AND s.id = :story'; //if we have a story id
		if (isset($args['status'])) $q .= ' AND s.status = :status'; 
		
		$q .= ' ORDER BY s.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['story']))	 $q->param(':story',$args['story']->id);
		if (isset($args['status']))	 $q->param(':status',$args['status']);
								
		$tempArray = $q->execute()->as_array();		
		
		$stories = array();
		foreach($tempArray as $a)
		{
			if(isset($args['include_locations'])) $a['include_locations'] = $args['include_locations'];
			if(isset($args['include_scenes'])) $a['include_scenes'] = $args['include_scenes'];
			if(isset($args['include_events'])) $a['include_events'] = $args['include_events'];
			
			$stories[$a['id']] = Model_Stories::getStory()->init($a);
		}
		return $stories;		
	}
}
