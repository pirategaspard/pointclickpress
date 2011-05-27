<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * Contains functions for getting story and stories
 * */

class Model_Pcp_Stories
{	
	static function getStory($args=array())
	{
		// get a single story object and populate it based on the arguments
		$story = new Model_PCP_Story($args);
		$story->load($args);
		return $story;		
	}
	
	static function getStoryInfo($args=array())
	{
		// get a single storyinfo object and populate it based on the arguments
		$storyinfo = new Model_PCP_StoryInfo($args);
		$storyinfo->load($args);
		return $storyinfo;		
	}
	
	static function getStories($args=array())
	{				
		// get all the stories in the db
		$q = '	SELECT s.id
						,s.title
						,s.author
						,s.description
						,s.first_location_id
						,s.image_id
						,s.status
						,i.filename
						,s.grid_x
						,s.grid_y
						,s.theme_name
						,s.creator_user_id
						,s.created_date
				FROM stories s
				LEFT OUTER JOIN images i
						ON s.image_id = i.id
				WHERE s.status = "p" ';
				
		if (isset($args['story'])) $q .= ' AND s.id = :story'; //if we have a story id		
		
		$q .= ' ORDER BY s.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['story']))	 $q->param(':story',$args['story']->id);
								
		$tempArray = $q->execute()->as_array();		
		
		$stories = array();
		foreach($tempArray as $a)
		{
			if(isset($args['include_locations'])) $a['include_locations'] = $args['include_locations'];
			if(isset($args['include_scenes'])) $a['include_scenes'] = $args['include_scenes'];
			if(isset($args['include_actions'])) $a['include_actions'] = $args['include_actions'];
			
			$stories[$a['id']] = self::getStory()->init($a);
		}
		return $stories;		
	}
}
