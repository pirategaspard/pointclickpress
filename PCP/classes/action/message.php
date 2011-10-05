<?php 
/*
	Creates a simple user message. 
	Requires message.js
	Demonstrates a PCP action implementing the iPCPaction interface
	
	How to use:
	action value:  message ; wait time	
	example: Hello World! ; 10000
 */

define('MESSAGE','MESSAGE'); // our action name
class action_message extends Model_Base_PCPActionDef
{	
	protected $label = 'User Message';
	protected $description = 'Displays a Message to the User';
	protected $allowed_action_types = Array(ACTION_TYPE_NULL,ACTION_TYPE_STORY,ACTION_TYPE_LOCATION,ACTION_TYPE_SCENE,ACTION_TYPE_GRID,ACTION_TYPE_GRIDITEM);
	
	public function performAction($args=array(),$hook_name='')
	{
		$action_data = $this->tokenize($args['action_value']);
		$data = array();
		$data['message'] = $action_data[0];
		if (count($action_data) > 1 && is_numeric($action_data[1]))
		{
			$data['wait_time'] = $action_data[1];
		}			
		// return message response
		$response = new pcpresponse(MESSAGE,$data); 
		return $response->asArray();
	}
}
?>
