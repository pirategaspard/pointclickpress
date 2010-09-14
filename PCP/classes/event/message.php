<?php 
/*
	Creates a user message. 
	Demonstrates a PCP event implementing the iPCPevent interface
 */

define('USER_MESSAGE','USER_MESSAGE');
class event_message implements iPCPevent
{	
	public function execute($args=array(),&$story_data=array())
	{
		// put user message into story data
		$story_data[USER_MESSAGE] = $args['event_value'];
		$results = USER_MESSAGE;
		return $results;
	}
	
	public function getEvent()
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
