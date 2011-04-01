<?php defined('SYSPATH') or die('No direct script access.');

class Model_SceneAction extends Model_Base_PCPAction 
{	
	protected $scene_id = 0;
	
	public function __construct($args=array())
	{
		parent::__construct();			
		$this->init($args);		
	}
	
	function init($args=array())
	{		
		parent::init($args);	
		if ((isset($args['scene_id']))&&(is_numeric($args['scene_id'])))
		{
			$this->scene_id = $args['scene_id'];
		}
		return $this;
	}
	
	function load($args=array())
	{
		
		if ($this->id > 0)
		{
			$q = '	SELECT 	e.id
							,e.action
							,e.action_label
							,e.action_value
							,se.scene_id
					FROM actions e
					INNER JOIN scenes_actions se
					ON e.id = ce.action_id
					WHERE e.id = :id';
			$q_results = DB::query(Database::SELECT,$q,TRUE)->param(':id',$this->id)->execute()->as_array();																		
			if (count($q_results) > 0 )
			{				
				$this->init($q_results[0]);	
			}
		}
		return $this;
	}
	
	
	function save()
	{	
		$results = new pcpresult();
		if ($this->id == 0)
		{
			parent::save();
			//INSERT new record
			try
			{
				$q = '	INSERT INTO scenes_actions
							(scene_id,action_id)
						VALUES (:scene_id,:id)';
							
				$q_results = DB::query(Database::INSERT,$q,TRUE)
									->param(':scene_id',$this->scene_id)
									->param(':id',$this->id)
									->execute();			
				if ($q_results[1] > 0)
				{
					$this->id = $q_results[0];
					$results->success = 1;
				}
				else
				{
					throw new Kohana_Exception('Error Updating Record in file: :file',
						array(':file' => Kohana::debug_path(__FILE__)));
				}
			}
			catch( Database_Exception $e )
			{
				throw new Kohana_Exception('Error Updating Record in file: :file',
					array(':file' => Kohana::debug_path(__FILE__)));
			}
		}
		elseif ($this->id > 0)
		{
			$results = parent::save();
		}
		$results->data = array('id'=>$this->id);
		return $results;
	}
	
	function delete()
	{
		if ($this->id > 0)
		{
							
			$q = '	DELETE FROM scenes_actions
						WHERE action_id = :id';
			$q_results =	DB::query(Database::DELETE,$q,TRUE)
								->param(':id',$this->id)
								->execute();						
								
			$results = parent::delete();
		}
		$results->data = array('id'=>$this->id);
		return 1;
	}
}

?>
