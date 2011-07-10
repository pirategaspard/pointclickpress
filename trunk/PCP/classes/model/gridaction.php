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
		$results = new pcpresult();	
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
				$results->data = array('id'=>$this->id,'grid_action_id' => $this->grid_action_id);
				$results->success = 1;
			}
			else
			{
				Kohana::$log->add(Log::ERROR, 'Error Inserting Record in file'.__FILE__);
				throw new Kohana_Exception('Error Inserting Record in file: :file',
					array(':file' => __FILE__));
			}
		}
		elseif ($this->id > 0)
		{		
			//UPDATE record
			try
			{
				parent::save();
				//delete any existing cells on this action
				$q = '	DELETE FROM cells
						WHERE grid_action_id = :grid_action_id';
				$results->success = DB::query(Database::DELETE,$q,TRUE)
										->param(':grid_action_id',$this->grid_action_id)
										->execute();
				//save cells
				foreach ($this->cells as $cell)
				{
					Model_Admin_CellsAdmin::getCell()->init(array('id'=>$cell,'scene_id'=>$this->scene_id,'grid_action_id'=>$this->grid_action_id))->save();
				}					
																		
			}
			catch( Database_Exception $e )
			{
			 	echo('somethings wrong in '.__FILE__.' on '.__LINE__);
			  	echo $e->getMessage(); die();
			}
		}
		return $results;
	}
	
	function delete()
	{
		$results = new pcpresult();
		$results->data = array('id'=>$this->id,'grid_action_id' => $this->grid_action_id);
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
			$results->success = DB::query(Database::DELETE,$q,TRUE)
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
			$results->success =	DB::query(Database::DELETE,$q,TRUE)
								->param(':grid_action_id',$this->grid_action_id)
								->param(':creator_user_id',Auth::instance()->get_user()->id)
								->execute();
			if ($results->success)
			{
				parent::delete();
			}																	
		}		
		return $results;
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
