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
class event_message implements iPCPevent
{	
	public function execute($args=array(),&$story_data=array())
	{
		$event_data = explode(';',$args['event_value']);
		$data = array();
		$data['message'] = $event_data[0];
		if (isset($event_data[1]))
		{
			$data['wait_time'] = $event_data[1];
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
		return Array(EVENT_TYPE_NULL,EVENT_TYPE_STORY,EVENT_TYPE_LOCATION,EVENT_TYPE_SCENE,EVENT_TYPE_GRID,EVENT_TYPE_ITEMSTATE);

	}
}
?>
