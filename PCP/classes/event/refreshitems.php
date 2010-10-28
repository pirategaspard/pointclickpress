<?php 
/*
	Refreshes items in the scene without reloading the scene
	Requires refreshitems.js 
 */

define('REFRESH_ITEMS','REFRESH_ITEMS'); // our event name
class event_refreshitems extends pcpevent implements iPCPevent
{	
	
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = 'Items Refresh';
		$this->description = 'Refreshes Items in the scene' ;	
	}

	public function execute($args=array(),&$story_data=array())
	{
		$results = array();
	
		// init response data
		$data = array();
		$data['items'] = '';		
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
		if ($scene)
		{
			// put any scene init events into session
			$results = array_merge($results,PCP::doEvents($scene->events));													
			// populate response data 					
			$data['items'] = $scene->items;
		}					
		// return REFRESH response
		$response = new pcpresponse(REFRESH_ITEMS,$data);
		$results = array_merge($results,$response->asArray());
		return $results;
	}
	
	public function getClass()
	{
		return get_class($this);
	}
}
?>
