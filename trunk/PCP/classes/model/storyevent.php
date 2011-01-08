<?php defined('SYSPATH') or die('No direct script access.');

class Model_StoryEvent extends Model_Event 
{	
	protected $story_id = 0;
	
	public function __construct($args=array())
	{
		parent::__construct();			
		$this->init($args);		
	}
	
	function init($args=array())
	{	
		parent::init($args);	
		if ((isset($args['story_id']))&&(is_numeric($args['story_id'])))
		{
			$this->story_id = $args['story_id'];
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
							,se.story_id
					FROM events e
					INNER JOIN stories_events se
					ON e.id = ce.event_id
					WHERE e.id = :id';
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
		$results = new pcpresult();
		if ($this->id == 0)
		{
			parent::save();
		
			//INSERT new record
			$q = '	INSERT INTO stories_events
						(story_id,event_id)
					VALUES (:story_id,:id)';
						
			$q_results = DB::query(Database::INSERT,$q,TRUE)
								->param(':story_id',$this->story_id)
								->param(':id',$this->id)
								->execute();			
			if ($q_results[1] > 0)
			{
				$this->id = $q_results[0];
				$results->success = 1;
			}
			else
			{
				throw new Kohana_Exception('Error Inserting Record in file: :file',
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
		if ($this->id > 0)
		{					
			$results = parent::delete();
		}
		return $results;
	}
}

?>
