<?php defined('SYSPATH') or die('No direct script access.');

class Model_GridAction extends Model_Base_PCPAction 
{	
	protected $grid_action_id = 0;
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
		if ((isset($args['grid_action_id']))&&(is_numeric($args['grid_action_id'])))
		{
			$this->grid_action_id = $args['grid_action_id'];
		}
		if (isset($args['cells']))
		{
			$this->cells = $args['cells'];
		}
		return $this;
	}
	
	function load($args=array())
	{			
		if (($this->id > 0)&&($this->scene_id > 0))
		{
			$q = '	SELECT 	e.id
							,e.action
							,e.action_label
							,e.action_value
							,g.scene_id
							,g.grid_action_id
					FROM grids_actions g
					INNER JOIN actions e
						ON e.id = g.action_id
					WHERE g.action_id = :id
						AND g.scene_id = :scene_id';
			$q_results = DB::query(Database::SELECT,$q,TRUE)
								->param(':id',$this->id)
								->param(':scene_id',$this->scene_id)
								->execute()
								->as_array();													
			if (count($q_results) > 0 )
			{				
				$this->init($q_results[0]);
				$this->cells = Model_Admin_CellsAdmin::getCells(array('action'=>$this));
			}			
		}
		return $this;
	}
	
	
	function save()
	{				
		$result = new pcpresult(PCPRESULT_STATUS_INFO,"Nothing was changed");
		try
		{
			if ($this->id == 0)
			{
				parent::save();
				//INSERT new record
				$q = '	INSERT INTO grids_actions
							(scene_id,action_id)
						VALUES (:scene_id,:action_id)';
							
				$q_results = DB::query(Database::INSERT,$q,TRUE)
									->param(':scene_id',$this->scene_id)
									->param(':action_id',$this->id)				
									->execute();
														
				if ($q_results[1] > 0)
				{											
					$this->grid_action_id = $q_results[0];
					foreach ($this->cells as $cell)
					{
						Model_Admin_CellsAdmin::getCell()->init(array('id'=>$cell,'scene_id'=>$this->scene_id,'grid_action_id'=>$this->grid_action_id))->save();
					}
					$result->data = array('id'=>$this->id,'grid_action_id' => $this->grid_action_id);
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Grid Action Saved";
				}
			}
			elseif ($this->id > 0)
			{		
				//UPDATE record
				parent::save();
				//delete any existing cells on this action
				$q = '	DELETE FROM cells
						WHERE grid_action_id = :grid_action_id';
				$records_updated = DB::query(Database::DELETE,$q,TRUE)
										->param(':grid_action_id',$this->grid_action_id)
										->execute();
										
				if ($records_updated > 0)
				{
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Grid Action Saved";
				}
				//save cells
				foreach ($this->cells as $cell)
				{
					Model_Admin_CellsAdmin::getCell()->init(array('id'=>$cell,'scene_id'=>$this->scene_id,'grid_action_id'=>$this->grid_action_id))->save();
				}					
			}
		}
		catch( Database_Exception $e )
		{
			$result->success = PCPRESULT_STATUS_FAILURE;
			$result->message = 'Error Saving Record';
			Kohana::$log->add(Log::ERROR, $e->getmessage().' in file'.__FILE__);
		}
		return $result;
	}
	
	function delete()
	{
		$result = new pcpresult(PCPRESULT_STATUS_INFO,"Nothing was changed");
		$result->data = array('id'=>$this->id,'grid_action_id' => $this->grid_action_id);
		try
		{
			if ($this->grid_action_id > 0)
			{					
				//delete any cells on this action
				$q = '	DELETE c 
						FROM cells c
						INNER JOIN grids_actions ga
							ON c.grid_action_id = ga.grid_action_id
						INNER JOIN scenes sc
							ON ga.scene_id = sc.id
						INNER JOIN stories s 
							ON sc.story_id = s.id
							AND s.creator_user_id = :creator_user_id 
						WHERE c.grid_action_id = :grid_action_id';
				$records_updated = DB::query(Database::DELETE,$q,TRUE)
								->param(':grid_action_id',$this->grid_action_id)
								->param(':creator_user_id',Auth::instance()->get_user()->id)
								->execute();
								
				$q = '	DELETE ga 
						FROM grids_actions ga
						INNER JOIN scenes sc
							ON ga.scene_id = sc.id
						INNER JOIN stories s 
							ON sc.story_id = s.id
							AND s.creator_user_id = :creator_user_id 
						WHERE grid_action_id = :grid_action_id';
				$records_updated =	DB::query(Database::DELETE,$q,TRUE)
									->param(':grid_action_id',$this->grid_action_id)
									->param(':creator_user_id',Auth::instance()->get_user()->id)
									->execute();
				if ($records_updated)
				{
					parent::delete();
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Grid Action Deleted";
				}																	
			}
		}
		catch( Database_Exception $e )
		{
			$result->success = PCPRESULT_STATUS_FAILURE;
			$result->message = 'Error Deleting Record';
			Kohana::$log->add(Log::ERROR, $e->getmessage().' in file'.__FILE__);
		}		
		return $result;
	}
	
	function getCellIds()
	{
		$cell_ids = array();				
		foreach ($this->cells as $cell)
		{
			$cell_ids[] = $cell->id;
		}		
		return implode(',',$cell_ids);
	}
}

?>
