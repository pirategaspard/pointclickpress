<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * backend Story helper file.
 * Contains functions for managing stories in the PCP admin
 * */

class Model_Admin_StoriesAdmin extends Model_PCP_Stories
{	
	
	static function getStory($args=array())
	{
		// get a single story object and populate it based on the arguments
		$story = new Model_Admin_Story($args);
		$story->load($args);
		return $story;		
	}
	
	
	static function getStories($args=array())
	{				
		// get all the stories in the db
		$q = '	SELECT s.*
				FROM stories s 
		 		INNER JOIN users u 
						ON 1 = 1
						AND ((s.creator_user_id = u.id
						AND u.id = :user_id)
						OR (s.creator_user_id = 0))'; // creator id of zero is so we can share the demo with everyone.
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
	
	static function getData()
	{
		$session = Session::instance('admin');	
		$data['id'] = $data['story_id'] = $session->get('story_id',0);
		Model_Admin_PCPAdmin::clearArgs();
		if (isset($_REQUEST['story_id']))
		{
			$data['id'] = $data['story_id'] = $_REQUEST['story_id'];		
		}
		else if ($session->get('story_id'))
		{
			$data['id'] = $data['story_id'] = $session->get('story_id');
		}
		if (isset($_REQUEST['image_id']))
		{
			$data['image_id'] = $_REQUEST['image_id'];	
		}
		else if ($session->get('image_id'))
		{
			$data['image_id'] = $session->get('image_id');
		}
		$data['include_locations']= false;
		$data['include_scenes']=false;
		$data['user_id'] = $data['creator_user_id'] = model_admin_usersadmin::getUserId();
		return $data;
	}
}
