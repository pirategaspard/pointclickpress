<?php 
/*
	Refreshes items in the scene without reloading the scene
	Requires refreshitems.js 
 */

define('REFRESH_ITEMS','REFRESH_ITEMS'); // our action name
class action_refreshitems extends Model_Base_PCPAction
{	
	
	public function __construct()
	{
		// init this action
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
		// get story
		$story = $session->get('story',NULL);
		// get item locations	
		$item_locations = Model_PCP_Items::getSceneGridItemInfo($story_data['scene_id'],$story_data['item_locations']);										
		// populate response data 					
		$data['items'] = $this->getItems($item_locations,$story_data,$story);				
		// return REFRESH response
		$response = new pcpresponse(REFRESH_ITEMS,$data);
		$results = array_merge($results,$response->asArray());
		return $results;
	}
	
	private function getItems($item_locations=array(),$story_data=array(),$story=null)
	{
		$items = array();
		$itemstates = Items::getGriditemsCurrentItemStates($item_locations,$story_data);
		
		foreach ($itemstates as $cell_id=>$itemstate)
		{
			$items[$cell_id] = array(	'id'=>key($itemstate),
										'path'=>$story->getMediaPath().current($itemstate)->getPath($story->screen_size));
		}
		return $items;
	}
	
	public function getClass()
	{
		return get_class($this);
	}
}
?>
