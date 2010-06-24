<?php defined('SYSPATH') or die('No direct script access.');

class Model_Cell extends Model 
{
	protected $id = 0;		
	protected $action_id = 0;
	
	public function __construct($args=array())
	{
		parent::__construct();		
		$this->init($args);		
	}
	
	function init($args=array())
	{
		if ((isset($args['id']))&&(is_numeric($args['id'])))
		{
			$this->id = $args['id'];
		}		
		if ((isset($args['action_id']))&&(is_numeric($args['action_id'])))
		{
			$this->action_id = $args['action_id'];
		}
		if ((isset($args['scene_id']))&&(is_numeric($args['scene_id'])))
		{
			$this->scene_id = $args['scene_id'];
		}
		if ((isset($args['container_id']))&&(is_numeric($args['container_id'])))
		{
			$this->container_id = $args['container_id'];
		}
		if (isset($args['event']))
		{
			$this->event = $args['event'];
		}
		if (isset($args['event_value']))
		{
			$this->event_value = $args['event_value'];
		}
		return $this;
	}
	
	function load($args=array())
	{
		
		if ($this->id > 0)
		{
			$q = '	SELECT 	scl.id,
							scl.action_id,
							sa.scene_id,
							sa.container_id,
							sa.event,
							sa.event_value
				FROM scene_action_cells scl
				INNER JOIN scene_actions sa
					ON sa.id = scl.action_id
					WHERE scl.id = :id';
			$results = DB::query(Database::SELECT,$q,TRUE)->param(':id',$this->id)->execute()->as_array();											
							
			if (count($results) > 0 )
			{				
				$this->init($results[0]);	
			}
		}
		return $this;
	}
	
	
	function save()
	{	
		$results['id'] = $this->id;	
		$results['success'] = 0;
		
		//INSERT new record
		$q = '	INSERT INTO scene_action_cells
					(id,action_id)
				VALUES (:id,:action_id)';
					
		$results = DB::query(Database::INSERT,$q,TRUE)
							->param(':id',$this->id)
							->param(':action_id',$this->action_id)
							->execute();			
		if ($results[1] > 0)
		{
			$results['id'] = $results[0];
			$results['success'] = 1;
		}
		else
		{
			echo('somethings wrong cell.php 90');
			var_dump($results);
		}
		return $results;
	}
	
	function delete()
	{
		if ($this->id > 0)
		{
			$q = '	DELETE FROM scene_action_cells
						WHERE id = :id';
			$results =	DB::query(Database::DELETE,$q,TRUE)
								->param(':id',$this->id)
								->execute();						
		}
		return 1;
	}

	function __get($prop)
	{			
		return $this->$prop;
	}

}

?>
