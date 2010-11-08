<?php 
/*
	Refreshes the scene.
	Requires refresh.js 
	This is the base event for many other events. 
	In general Events should strive to only manipulate story_data. 
	This event cheats a bit. -dg
 */

define('REFRESH','REFRESH'); // our event name
class event_refresh extends pcpevent implements iPCPevent
{	
	
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = 'Scene Refresh';
		$this->description = 'Refreshes the scene' ;	
	}

	public function execute($args=array(),&$story_data=array())
	{
		$results = array();
	
		// init response data
		$data = array();
		$data['filename'] = '';
		$data['title'] = '';
		$data['description'] = '';
		// do hook
		plugins::executeHook('pre_scene');		
		// get session
		$session = Session::instance();
		// set story data 
		$session->set('story_data',$story_data);						
		// get story
		$story = $session->get('story',NULL);
		//get location 
		$location = PCP::getlocation($story_data['location_id']);
		// put any location init events into session
		$results = array_merge($results,PCP::doEvents($location->events));
		// get scene
		$scene = PCP::getScene(array('location_id'=>$story_data['location_id'],'story'=>$story,'simple_items'=>true));
		// if we have valid data continue
		if (($scene)&&($location)&&($story))
		{
			// put any scene init events into session
			$results = array_merge($results,PCP::doEvents($scene->events));													
			// populate response data 					
			$data['filename'] = $scene->getPath($story->screen_size);
			$data['preload_filename'] = $scene->getPath(THUMBNAIL_IMAGE_SIZE);
			$data['items'] = $scene->items;
			$data['title'] = DEFAULT_PAGE_TITLE.$story->title.' : '.$scene->title;
			$data['description'] = $scene->description;
		}
		// set data back into session
		$session->set('scene',$scene);
		$session->set('location',$location);
		// do hook
		plugins::executeHook('post_scene');					
		// return REFRESH response
		$response = new pcpresponse(REFRESH,$data);
		$results = array_merge($results,$response->asArray());
		return $results;
	}
	
	public function getClass()
	{
		return get_class($this);
	}
}
?>
