<?php defined('SYSPATH') or die('No direct script access.');

class Model_GriditemEvent extends Model_Base_Event 
{	
	protected $griditem_id = 0;
	
	public function __construct($args=array())
	{
		parent::__construct();					
		$this->init($args);		
	}
	
	function init($args=array())
	{		
		parent::init($args);
		if ((isset($args['griditem_id']))&&(is_numeric($args['griditem_id'])))
		{
			$this->griditem_id = $args['griditem_id'];
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
							,ce.griditem_id
					FROM events e
					INNER JOIN grids_items_events ce
					ON e.id = ce.event_id
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
			$q = '	INSERT INTO grids_items_events
						(griditem_id,event_id)
					VALUES (:griditem_id,:id)';						
			$q_results = DB::query(Database::INSERT,$q,TRUE)
								->param(':griditem_id',$this->griditem_id)
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
		elseif ($this->id > 0)
		{
			$results = parent::save();														
		}
		$results->data = array('id'=>$this->id);
		return $results;
	}
	
	function delete()
	{
		$results = new pcpresult();
		$results->data = array('id'=>$this->id);
		if ($this->id > 0)
		{
			$q = '	DELETE FROM grids_items_events
						WHERE event_id = :id';
			$results->success =	DB::query(Database::DELETE,$q,TRUE)
									->param(':id',$this->id)
									->execute();									
			parent::delete();
		}		
		return $results;
	}
}

?>
