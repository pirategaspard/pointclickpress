<?php 
/*
	Evaluate action class for PointClickPress
	Execute arbitrary PHP code. 
 */

class action_eval extends Model_Base_PCPActionDef
{	
	protected $label = "Eval";
	protected $description = "Execute arbitrary PHP code. Use with caution." ;	
	
	public function performAction($args=array(),$hook_name='')
	{									
		$result = eval($args['action_value']);	
		if ((isset($result))&&(is_array($result))&&($result[0] instanceof pcpresponse))
		{
			$response = $result;
		}
		
		//var_dump(StoryData::getStorydata()); die();
				
		// you can return your own response above otherwise default is NOP
		if(!isset($response))
		{
			$response = new pcpresponse(NOP,array()); 
			return $response->asArray();
		}
		return $response;
	}
}
?>
