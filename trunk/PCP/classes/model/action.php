<?php defined('SYSPATH') or die('No direct script access.');

class Model_Action extends Model 
{
	protected $id = 0;		
	protected $scene_id = 0;
	protected $container_id = 0;	
	protected $event = '';
	protected $event_label = '';
	protected $event_value = '';
	protected $cells = array();
	
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
		if ((isset($args['container_id']))&&(is_numeric($args['container_id'])))
		{
			$this->container_id = $args['container_id'];
		}
		if (isset($args['event']))
		{
			$this->event = $args['event'];
		}
		if (isset($args['event_label']))
		{
			$this->event_label = $args['event_label'];
		}
		if (isset($args['event_value']))
		{
			$this->event_value = $args['event_value'];
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
			$q = '	SELECT 	id
							,scene_id
							,container_id
							,event
							,event_label
							,event_value
					FROM scene_actions sa
					WHERE id = :id';
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
			//INSERT new record
			$q = '	INSERT INTO scene_actions
						(scene_id
						,container_id
						,event
						,event_label
						,event_value)
					VALUES (
						:scene_id
						,:container_id
						,:event
						,:event_label
						,:event_value
						)';
						
			$results = DB::query(Database::INSERT,$q,TRUE)
								->param(':scene_id',$this->scene_id)
								->param(':container_id',$this->container_id)
								->param(':event',$this->event)
								->param(':event_label',$this->event_label)
								->param(':event_value',$this->event_value)
								->execute();			
			if ($results[1] > 0)
			{
				$this->id = $results[0];
				
				foreach ($this->cells as $cell)
				{
					$results = Cells::getCell()->init(array('id'=>$cell,'action_id'=>$this->id))->save();
				}
				$results['id'] = $this->id ;
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
				$q = '	UPDATE scene_actions
						SET event = :event,
							event_label = :event_label,
							event_value = :event_value
						WHERE id = :id';
				$results['success'] = DB::query(Database::UPDATE,$q,TRUE)
								->param(':event',$this->event)
								->param(':event_value',$this->event_value)
								->param(':event_label',$this->event_label)
								->param(':id',$this->id)
								->execute();
				
				//delete any existing cells on this action
				$q = '	DELETE FROM scene_action_cells
						WHERE action_id = :id';
				$results['success'] = DB::query(Database::DELETE,$q,TRUE)
								->param(':id',$this->id)
								->execute();
				//save cells
				foreach ($this->cells as $cell)
				{
					Cells::getCell()->init(array('id'=>$cell,'action_id'=>$this->id))->save();
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
			$q = '	DELETE FROM scene_action_cells
					WHERE action_id = :id';
			$results['success'] = DB::query(Database::UPDATE,$q,TRUE)
							->param(':id',$this->id)
							->execute();
							
			$q = '	DELETE FROM scene_actions
						WHERE id = :id';
			$results =	DB::query(Database::DELETE,$q,TRUE)
								->param(':id',$this->id)
								->execute();						
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
