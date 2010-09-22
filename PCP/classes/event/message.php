<?php 
/*
	Creates a simple user message. 
	Requires message.js
	Demonstrates a PCP event implementing the iPCPevent interface
 */

define('MESSAGE','MESSAGE'); // our event name
class event_message implements iPCPevent
{	
	public function execute($args=array(),&$story_data=array())
	{
		$data = array();
		$data['message'] = $args['event_value'];	
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
}
?>
