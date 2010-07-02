<?php defined('SYSPATH') or die('No direct script access.');

class Model_SceneEvent extends Model_Event 
{	
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
							,se.scene_id
					FROM events e
					INNER JOIN scenes_events se
					ON event_id = id
					WHERE e.id = :id';
			$results = DB::query(Database::SELECT,$q,TRUE)->param(':id',$this->id)->execute()->as_array();											
							
			if (count($results) > 0 )
			{				
				$this->init($results[0]);
				$this->cells = Cells::getCells(array('action'=>$this));
					
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
			$q = '	INSERT INTO scenes_events
						(scene_id,event_id)
					VALUES (:scene_id,:id)';
						
			$results = DB::query(Database::INSERT,$q,TRUE)
								->param(':scene_id',$this->scene_id)
								->param(':id',$this->id)
								->execute();			
			if ($results[1] > 0)
			{
				foreach ($this->cells as $cell)
				{
					$results = Cells::getCell()->init(array('id'=>$cell,'event_id'=>$this->id))->save();
				}
				$results['id'] = $this->id ;
				$results['success'] = 1;
			}
			else
			{
				echo('somethings wrong '.__FILE__.' 84');
				var_dump($results);
			}
		}
		elseif ($this->id > 0)
		{
			//UPDATE record
			try
			{
				parent::save();
				//delete any existing cells on this action
				$q = '	DELETE FROM scenes_events
						WHERE event_id = :id';
				$results['success'] = DB::query(Database::DELETE,$q,TRUE)
								->param(':id',$this->id)
								->execute();
				//save cells
				foreach ($this->cells as $cell)
				{
					Cells::getCell()->init(array('id'=>$cell,'event_id'=>$this->id))->save();
				}					
																		
			}
			catch( Database_Exception $e )
			{
			 echo('somethings wrong '.__FILE__.' 109');
			  echo $e->getMessage(); die();
			}
		}
		return $results;
	}
	
	function delete()
	{
		if ($this->id > 0)
		{
							
			$q = '	DELETE FROM scenes_events
						WHERE event_id = :id';
			$results =	DB::query(Database::DELETE,$q,TRUE)
								->param(':id',$this->id)
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
