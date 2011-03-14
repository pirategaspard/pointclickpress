<?php 
/*
	Creates a simple user message. 
	Requires message.js
	Demonstrates a PCP event implementing the iPCPevent interface
	
	How to use:
	event value:  message ; wait time	
	example: Hello World! ; 10000
 */

define('MESSAGE','MESSAGE'); // our event name
class action_message extends Model_Base_PCPAction implements Interfaces_iPCPevent
{	
	public function execute($args=array(),&$story_data=array())
	{
		$action_data = explode(';',$args['action_value']);
		$data = array();
		$data['message'] = $action_data[0];
		if (isset($action_data[1]))
		{
			$data['wait_time'] = $action_data[1];
		}			
		// return message response
		$response = new pcpresponse(MESSAGE,$data); 
		return $response->asArray();
	}
	
	public function getClass()
	{
		return get_class($this);
	}
	
	public function getLabel()
	{
		return 'User Message';
	}
	
	public function getDescription()
	{
		return 'Displays a Message to the User';
	}
	
	public function getAllowedTypes()
	{
		return Array(ACTION_TYPE_NULL,ACTION_TYPE_STORY,ACTION_TYPE_LOCATION,ACTION_TYPE_SCENE,ACTION_TYPE_GRID,ACTION_TYPE_ITEMSTATE);

	}
}
?>
