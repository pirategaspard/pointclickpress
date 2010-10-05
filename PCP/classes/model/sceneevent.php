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
			$q_results = DB::query(Database::SELECT,$q,TRUE)->param(':id',$this->id)->execute()->as_array();											
							
			if (count($q_results) > 0 )
			{				
				$this->init($q_results[0]);
				$this->cells = Cells::getCells(array('scene'=>$this));
					
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
				$q = '	INSERT INTO scenes_events
							(scene_id,event_id)
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
						array(':file' => Kohana::debug_path($file)));
				}
			}
			catch( Database_Exception $e )
			{
				throw new Kohana_Exception('Error Updating Record in file: :file',
					array(':file' => Kohana::debug_path($file)));
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
							
			$q = '	DELETE FROM scenes_events
						WHERE event_id = :id';
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
