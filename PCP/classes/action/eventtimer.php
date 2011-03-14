<?php 
/*
 */
define('EVENTTIMER','EVENTTIMER'); // our event name
class action_actiontimer extends Model_Base_PCPAction implements Interfaces_iPCPevent
{
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = 'Event Timer';
		$this->description = 'Execute a timed click on a cell. Can be used to execute timed events';
	}
	public function execute($args=array(),&$story_data=array())
	{
		$timer_data = explode(';',$args['action_value']);
		$data = array();
		$data['wait_time'] = $timer_data[0];
		$data['cell_to_click'] = $timer_data[1];
		// return message response
		$response = new pcpresponse(EVENTTIMER,$data); 
		return $response->asArray();
	}
}
?>

