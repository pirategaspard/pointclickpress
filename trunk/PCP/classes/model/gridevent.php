<?php defined('SYSPATH') or die('No direct script access.');

class Model_GridEvent extends Model_Event 
{	
	protected $grid_event_id = 0;
	protected $scene_id = 0;	
	protected $cells = array();
	
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
		if (isset($args['cells']))
		{
			$this->cells = $args['cells'];
		}
		return $this;
	}
	
	function load($args=array())
	{		
		if ($this->id > 0)
		{
			$q = '	SELECT 	e.id
							,e.event
							,e.event_label
							,e.event_value
							,g.scene_id
							,g.grid_event_id
					FROM grids_events g
					INNER JOIN events e
						ON e.id = g.event_id
					WHERE g.event_id = :event_id';
			$results = DB::query(Database::SELECT,$q,TRUE)->param(':event_id',$this->id)->execute()->as_array();											
			
			if (count($results) > 0 )
			{				
				$this->init($results[0]);
				$this->cells = Cells::getCells(array('event'=>$this));
			}
		}
		return $this;
	}
	
	
	function save()
	{	
		$results['id'] = $this->id;	
		$results['success'] = 0;
		
		if ($this->id == 0)
		{
			parent::save();
		
			//INSERT new record
			$q = '	INSERT INTO grids_events
						(scene_id,event_id)
					VALUES (:scene_id,:event_id)';
						
			$results = DB::query(Database::INSERT,$q,TRUE)
								->param(':scene_id',$this->scene_id)
								->param(':event_id',$this->id)
								->execute();			
			if ($results[1] > 0)
			{
				$this->grid_event_id = $results[0];
				foreach ($this->cells as $cell)
				{
					$results = Cells::getCell()->init(array('cell'=>$cell,'grid_event_id'=>$this->grid_event_id))->save();
				}
				$results['id'] = $this->id ;
				$results['grid_event_id'] = $this->grid_event_id;
				$results['success'] = 1;
			}
			else
			{
				echo('somethings wrong action.php 111');
				var_dump($results);
			}
		}
		elseif ($this->id > 0)
		{
			//UPDATE record
			try
			{
				parent::save();
				//delete any existing cells on this event
				$q = '	DELETE FROM cells
						WHERE grid_event_id = :grid_event_id';
				$results['success'] = DB::query(Database::DELETE,$q,TRUE)
								->param(':grid_event_id',$this->grid_event_id)
								->execute();
				//save cells
				foreach ($this->cells as $cell)
				{
					Cells::getCell()->init(array('id'=>$cell,'grid_event_id'=>$this->grid_event_id))->save();
				}					
																		
			}
			catch( Database_Exception $e )
			{
			 echo('somethings wrong action.php 149');
			  echo $e->getMessage(); die();
			}
		}
		return $results;
	}
	
	function delete()
	{
		if ($this->id > 0)
		{
			
			//delete any cells on this action
			$q = '	DELETE FROM cells
					WHERE grid_event_id = :grid_event_id';
			$results['success'] = DB::query(Database::UPDATE,$q,TRUE)
							->param(':grid_event_id',$this->grid_event_id)
							->execute();
							
			$q = '	DELETE FROM grids_events
						WHERE event_id = :event_id';
			$results =	DB::query(Database::DELETE,$q,TRUE)
								->param(':event_id',$this->id)
								->execute();						
								
			parent::delete();
		}
		return 1;
	}
	
	function getCellIds()
	{
		$cell_ids = '';
		foreach ($this->cells as $cell)
		{
			$cell_ids .= $cell->id.',';
		}
		return $cell_ids;
	}

	function __get($prop)
	{			
		return $this->$prop;
	}

}

?>
