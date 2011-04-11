<?php 
/*
 */
define('EVENTTIMER','EVENTTIMER'); // our event name
class action_eventtimer extends Model_Base_PCPActionDef
{
	protected $label = 'Event Timer';
	protected $description = 'Execute a timed click on a cell. Can be used to execute timed events';	

	public function performAction($args=array(),$hook_name='')
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

