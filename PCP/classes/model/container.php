<?php defined('SYSPATH') or die('No direct script access.');

/*
	A scene container hold multiple versions of a scene.
	For instance a scene where the door to the house is closed
	and a scene where the door the house is open.
 */
class Model_Container extends Model 
{
	protected $story_id = 0;
	protected $id = 0;
	protected $title = '';
	protected $slug = '';
	protected $events = array();
	protected $scenes = array();
		
	//protected $values = array();	
	
	public function __construct($args=array())
	{
		parent::__construct();		
		$this->init($args);
		
	}
	
	function init($args=array())
	{
		if (!isset($args['include_events'])) $args['include_events']=false;
		if (!isset($args['include_scenes'])) $args['include_scenes']=false;
		
		if ((isset($args['story_id']))&&(is_numeric($args['story_id'])))
		{
			$this->story_id = $args['story_id'];
		}
		if ((isset($args['id']))&&(is_numeric($args['id'])))
		{
			$this->id = $args['id'];
		}
		if (isset($args['title']))
		{
			$this->title = $args['title'];
			$this->slug = Formatting::createSlug($args['title']);
		}
		if ($args['include_events'])
		{			
			$args['container'] = $this;
			$this->events = EventsAdmin::getContainerEvents($args);
		}
		if ($args['include_scenes'])
		{			
			$args['container'] = $this;
			$this->scenes = scenes::getScenes($args);
		}
		return $this;
	}
	
	function load($args=array('include_scenes'=>false))
	{		
		if ($this->id > 0)
		{
			$q = '	SELECT 	id
							,story_id
							,title
					FROM containers c
					WHERE id = :id';
			$results = DB::query(Database::SELECT,$q,TRUE)->param(':id',$this->id)->execute()->as_array();
			
			if (count($results) > 0 )
			{
				$this->init($results[0]);							
				
				/*
				// get all possible values for scenes in this container
				if (count($this->scenes) > 0)
				{
					$q = '	SELECT DISTINCT s.value
							FROM containers c
							INNER JOIN scenes s
							ON s.container_id = c.id
							WHERE c.id = :id
							AND s.value != ""';  // 
					$results = DB::query(Database::SELECT,$q,TRUE)->param(':id',$this->id)->execute()->as_array();
					foreach($results as $result)
					{
						$this->values[] = $result['value'];
					}
				}*/
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
				$q = '	INSERT INTO containers
						(story_id,title)
						VALUES (:story_id,:title)';
				$results = DB::query(Database::INSERT,$q,TRUE)
								->param(':story_id',$this->story_id)
								->param(':title',$this->title)
								->execute();						
			if ($results[1] > 0)
			{
				$results['id'] = $results[0];
				$results['success'] = 1;
			}
		}
		elseif ($this->id > 0)
		{
			//UPDATE record
			try
			{
				$q = '	UPDATE containers
						SET title = :title
						WHERE id = :id';
				$results['success'] = DB::query(Database::UPDATE,$q,TRUE)
										->param(':title',$this->title)
										->param(':id',$this->id)
										->execute();															
			}
			catch( Database_Exception $e )
			{
			  echo('somethings wrong container.php 114');
			  echo $e->getMessage(); die();
			}
		}
		return $results;
	}
	
	function delete()
	{	
		if ($this->id > 0)
		{
			//delete all scenes in container first
			$this->load();
			foreach($this->scenes as $scene)
			{
				$scene->delete();
			}
			
			$q = '	DELETE FROM containers
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
