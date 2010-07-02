<?php defined('SYSPATH') or die('No direct script access.');

class Model_ContainerEvent extends Model_Event 
{	
	protected $container_id = 0;
	protected $cells = array();
	
	public function __construct($args=array())
	{
		parent::__construct();					
		$this->init($args);		
	}
	
	function init($args=array())
	{		
		parent::init($args);
		if ((isset($args['container_id']))&&(is_numeric($args['container_id'])))
		{
			$this->container_id = $args['container_id'];
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
							,se.container_id
					FROM events e
					INNER JOIN containers_events ce
					ON event_id = id
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
		$results['id'] = $this->id;	
		$results['success'] = 0;
		
		if ($this->id == 0)
		{			
			parent::save();
			//INSERT new record
			$q = '	INSERT INTO containers_events
						(container_id,event_id)
					VALUES (:container_id,:id)';
						
			$results = DB::query(Database::INSERT,$q,TRUE)
								->param(':container_id',$this->container_id)
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
				echo('somethings wrong action.php 111');
				var_dump($results);
			}
		}
		elseif ($this->id > 0)
		{
			parent::save();														
		}
		return $results;
	}
	
	function delete()
	{
		if ($this->id > 0)
		{
			
			$q = '	DELETE FROM containers_events
						WHERE event_id = :id';
			$results =	DB::query(Database::DELETE,$q,TRUE)
								->param(':id',$this->id)
								->execute();									
			parent::delete();
		}
		return 1;
	}

	function __get($prop)
	{			
		return $this->$prop;
	}

}

?>
