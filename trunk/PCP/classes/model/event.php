<?php defined('SYSPATH') or die('No direct script access.');

class Model_Event extends Model 
{
	protected $id = 0;		
	protected $event = '';
	protected $event_label = '';
	protected $event_value = '';
	
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
		return $this;
	}
	
	function load($args=array())
	{
		
		if ($this->id > 0)
		{
			$q = '	SELECT 	id
							,event
							,event_label
							,event_value
					FROM events e
					WHERE id = :id';
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
		
		if ($this->id == 0)
		{
			//INSERT new record
			$q = '	INSERT INTO events
						(event
						,event_label
						,event_value)
					VALUES (
						:event
						,:event_label
						,:event_value
						)';
						
			$results = DB::query(Database::INSERT,$q,TRUE)
								->param(':event',$this->event)
								->param(':event_label',$this->event_label)
								->param(':event_value',$this->event_value)
								->execute();			
			if ($results[1] > 0)
			{
				$this->id = $results[0];
				$results['id'] = $this->id ;
				$results['success'] = 1;
			}
			else
			{
				echo('somethings wrong event.php 111');
				var_dump($results);
			}
		}
		elseif ($this->id > 0)
		{
			//UPDATE record
			try
			{
				$q = '	UPDATE events
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
																	
			}
			catch( Database_Exception $e )
			{
			 echo('somethings wrong event.php 116');
			  echo $e->getMessage(); die();
			}
		}
		return $results;
	}
	
	function delete()
	{
		if ($this->id > 0)
		{
				
			$q = '	DELETE FROM events
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
