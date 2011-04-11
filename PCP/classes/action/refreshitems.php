<?php 
/*
	Refreshes items in the scene without reloading the scene
	Requires refreshitems.js 
 */

define('REFRESH_ITEMS','REFRESH_ITEMS'); // our action name
class action_refreshitems extends Model_Base_PCPActionDef
{	
	
	protected $label = 'Items Refresh';
	protected $description = 'Refreshes Items in the scene';	

	public function performAction($args=array(),$hook_name='')
	{
		$results = array();
	
		// init response data
		$data = array();
		$data['items'] = '';
		// get session
		$session = Session::instance();	
		// get story
		$story = $session->get('story',NULL);									
		// populate response data 					
		$data['items'] = $this->getItems(Storydata::get('scene_id'),$story);				
		// return REFRESH response
		$response = new pcpresponse(REFRESH_ITEMS,$data);
		$results = array_merge($results,$response->asArray());
		return $results;
	}
	
	private function getItems($scene_id=0,$story=null)
	{
		$items = array();
		$itemstates = Items::getSceneGriditems($scene_id);
		
		foreach ($itemstates as $cell_id=>$itemstate)
		{
			if (count($itemstate) > 0)
			{
				$items[$cell_id] = array(	'id'=>key($itemstate),
										'path'=>$story->getMediaPath().current($itemstate)->getPath($story->screen_size));
			}
		}
		return $items;
	}

}
?>
