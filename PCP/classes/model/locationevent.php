<?php defined('SYSPATH') or die('No direct script access.');

class Model_locationEvent extends Model_Event 
{	
	protected $location_id = 0;
	protected $cells = array();
	
	public function __construct($args=array())
	{
		parent::__construct();					
		$this->init($args);		
	}
	
	function init($args=array())
	{		
		parent::init($args);
		if ((isset($args['location_id']))&&(is_numeric($args['location_id'])))
		{
			$this->location_id = $args['location_id'];
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
							,ce.location_id
					FROM events e
					INNER JOIN locations_events ce
					ON event_id = id
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
		$results = new ();
		if ($this->id == 0)
		{			
			parent::save();
			//INSERT new record
			$q = '	INSERT INTO locations_events
						(location_id,event_id)
					VALUES (:location_id,:id)';						
			$q_results = DB::query(Database::INSERT,$q,TRUE)
								->param(':location_id',$this->location_id)
								->param(':id',$this->id)
								->execute();			
			if ($q_results[1] > 0)
			{
				foreach ($this->cells as $cell)
				{
					Cells::getCell()->init(array('id'=>$cell,'event_id'=>$this->id))->save();
				}
				$this->id = $q_results[0];
				$results->success = 1;
			}
			else
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
		$results = new ();
		if ($this->id > 0)
		{
			$q = '	DELETE FROM locations_events
						WHERE event_id = :id';
			$results->success =	DB::query(Database::DELETE,$q,TRUE)
									->param(':id',$this->id)
									->execute();									
			parent::delete();
		}
		$results->data = array('id'=>$this->id);
		return $results;
	}
}

?>
