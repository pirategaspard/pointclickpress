<?php
/*
	Base Class for PointClickPress actions
 */

define('NOP', 'NOP'); // No Operation action response
class Model_Base_PCPActionDef extends Model_Base_PCPAdminItem implements Interface_iPCPActionDef
{
	// default is all action types allowed
	protected $allowed_action_types = Array(ACTION_TYPE_NULL,ACTION_TYPE_STORY,ACTION_TYPE_LOCATION,ACTION_TYPE_SCENE,ACTION_TYPE_GRID,ACTION_TYPE_ITEMDEF,ACTION_TYPE_ITEMSTATE,ACTION_TYPE_GRIDITEM);
	// comma seperated list of event names
	protected $events = Array(); 
	
	public function getAllowedActionTypes()
	{
		return $this->allowed_action_types;
	}
	
	public function getEvents()
	{
		return $this->events;
	}
	
	public function performAction($args=array(),&$story_data=array(),$hook_name='')
	{
		// return message response
		$response = new pcpresponse(NOP,array()); 
		return $response->asArray();
	}
	
	// call action as event listener 
	public function execute($hook_name='')
	{
		$session = Session::instance();
		$storydata = $session->get('storydata',array());
		$this->performAction(array(),$storydata,$hook_name);
	}
}

?>
