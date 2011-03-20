<?php 
/*
 */
define('actionTIMER','actionTIMER'); // our action name
class action_actiontimer extends Model_Base_PCPAction implements Interfaces_iPCPaction
{
	public function __construct()
	{
		// init this action
		parent::__construct();
		$this->label = 'action Timer';
		$this->description = 'Execute a timed click on a cell. Can be used to execute timed actions';
	}
	public function execute($args=array(),&$story_data=array())
	{
		$timer_data = explode(';',$args['action_value']);
		$data = array();
		$data['wait_time'] = $timer_data[0];
		$data['cell_to_click'] = $timer_data[1];
		// return message response
		$response = new pcpresponse(actionTIMER,$data); 
		return $response->asArray();
	}
}
?>

