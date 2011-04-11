<?php 
/*
	Refreshes the scene.
	Requires refresh.js 
	This is the base action for many other actions. 
	In general actions should strive to only manipulate story_data. 
	This action cheats a bit. -dg
 */

define('REFRESH','REFRESH'); // our action name
class action_refresh extends Model_Base_PCPActionDef
{	
	protected $label = 'Scene Refresh';
	protected $description = 'Refreshes the scene';
	protected $allowed_action_types = array(ACTION_TYPE_GRID,ACTION_TYPE_GRIDITEM);	
	
	public function performAction($args=array(),$hook_name='')
	{
		$results = array();
	
		// init response data
		$data = array();
		$data['filename'] = '';
		$data['title'] = '';
		$data['description'] = '';
		// do event
		Events::announceEvent(PRE_SCENE);	
		// get session
		$session = Session::instance();
		// get story
		$story = $session->get('story',NULL);
		//get location 
		$location = Model_PCP_Locations::getLocation(array('id'=>Storydata::get('location_id')));
		// put any location init actions into session
		$results = array_merge($results,Actions::doActions($location->getActions()));
		
		//var_dump($story); die(); 
		// get scene
		$scene = Model_PCP_Scenes::getCurrentScene(array('location_id'=>Model_PCP_Locations::getCurrentlocationId()));
		

// var_dump($story_data['location_id']); die();

// if we have valid data continue
		if (($scene)&&($location)&&($story))
		{
			//put scene id into story_data
			Storydata::set('scene_id',$scene->id);
			// populate response data 					
			$data['filename'] = $scene->getPath($story->screen_size);
			$data['preload_filename'] = $scene->getPath(THUMBNAIL_IMAGE_SIZE);
			$data['items'] = $this->getItems($scene->id,$story);
			$data['title'] = DEFAULT_PAGE_TITLE.$story->title.' : '.$scene->title;
			$data['description'] = $scene->description;
			
			// put any scene init actions into session
			$results = array_merge($results,Actions::doActions($scene->getActions()));		
			// put any item actions into session
			$results = array_merge($results,Actions::doActions(Actions::getSceneItemActions($scene->id)));
		}
		// set data back into session
		$session->set('scene',$scene);
		$session->set('location',$location);
		// do event
		Events::announceEvent(POST_SCENE);					
		// return REFRESH response
		$response = new pcpresponse(REFRESH,$data);
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
