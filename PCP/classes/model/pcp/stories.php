<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * Contains functions for getting story and stories
 * */

class Model_Pcp_Stories
{	
	static function getStory($args=array())
	{
		// get a single story object and populate it based on the arguments
		$story = new Model_Story($args);
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
		$q = '	SELECT s.*
				FROM stories s';
		if (isset($args['user_id'])) 
		{ 
			$q .= ' INNER JOIN users u 
						ON 1 = 1
						AND ((s.creator_user_id = u.id
						AND u.id = :user_id)
						OR (s.creator_user_id = 0))'; // creator id of zero is so we can share the demo with everyone.
		}  
		$q	.=	' WHERE 1 = 1 ';
				
		if (isset($args['story'])) $q .= ' AND s.id = :story'; //if we have a story id
		if (isset($args['status'])) $q .= ' AND s.status = :status';		
		
		$q .= ' ORDER BY s.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['user_id']))	 $q->param(':user_id',$args['user_id']);
		if (isset($args['story']))	 $q->param(':story',$args['story']->id);
		if (isset($args['status']))	 $q->param(':status',$args['status']);
								
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
