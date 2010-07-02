<?php defined('SYSPATH') or die('No direct script access.');

class Model_Cell extends Model 
{
	protected $id = 0;		
	protected $scene_id = 0;
	protected $grid_event_id = 0;
	
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
		if ((isset($args['scene_id']))&&(is_numeric($args['scene_id'])))
		{
			$this->scene_id = $args['scene_id'];
		}
		if ((isset($args['grid_event_id']))&&(is_numeric($args['grid_event_id'])))
		{
			$this->grid_event_id = $args['grid_event_id'];
		}
		return $this;
	}
	
	function load($args=array())
	{
		
		if ($this->id > 0)
		{
			$q = '	SELECT 	e.event_id
							,e.event
							,e.event_value														
							,sce.scene_id
							,sce.grid_event_id							
				FROM cells sc
				INNER JOIN grids_events sce
					ON sce.grid_event_id = sc.grid_event_id
				INNER JOIN events e
					ON e.id = sce.event_id
				WHERE sc.id = :id';
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
		$q = '	INSERT INTO cells
					(scene_id,id,grid_event_id)
				VALUES (:scene_id,:id,:grid_event_id)';
					
		$results = DB::query(Database::INSERT,$q,TRUE)
							->param(':scene_id',$this->scene_id)
							->param(':id',$this->id)
							->param(':grid_event_id',$this->grid_event_id)
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
			$q = '	DELETE FROM cells
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
