<?php defined('SYSPATH') or die('No direct script access.');

class Model_Story extends Model 
{
	protected $id = 0;
	protected $title = "";
	protected $author = "";
	protected $description = "";
	protected $grid_x = "";
	protected $grid_y = "";
	protected $first_scene_container_id = null;
	protected $image_id = null;
	protected $filename = "";
	protected $events = array();
	protected $containers = array();
	
	public function __construct($args=array())
	{
		parent::__construct();		
		$this->init($args);		
	}
	
	function init($args=array())
	{
		if (!isset($args['include_events'])) $args['include_events']=false;
		if (!isset($args['include_containers'])) $args['include_containers']=false;
		
		if ((isset($args['id']))&&(is_numeric($args['id'])))
		{
			$this->id = $args['id'];
		}
		if (isset($args['title']))
		{			
			$this->title = $args['title'];					
		}
		if (isset($args['author']))
		{
			$this->author = $args['author'];
		}
		if (isset($args['description']))
		{
			$this->description = $args['description'];
		}
		if (isset($args['first_scene_container_id']) && ($args['first_scene_container_id'] > 0))
		{
			$this->first_scene_container_id = $args['first_scene_container_id'];
		}
		if (isset($args['image_id']))
		{			
			$this->image_id = $args['image_id'];							
		}
		if (isset($args['filename']))
		{			
			$this->filename = $args['filename'];							
		}
		if (isset($args['grid_x']))
		{
			$this->grid_x = $args['grid_x'];
		}
		if (isset($args['grid_y']))
		{
			$this->grid_y = $args['grid_y'];
		}
		if (isset($args['grid']))
		{
			$grid = explode('x',$args['grid']);			
			$this->grid_x = $grid[0];
			$this->grid_y = $grid[1];
		}
		if ($args['include_events'])
		{			
			$args['story'] = $this;
			$this->events = EventsAdmin::getStoryEvents($args);
		}
		if ($args['include_containers'])
		{			
			$args['story'] = $this;
			$this->containers = Containers::getContainers($args);
		}
		return $this;
	}
	
	function load($args=array())
	{		
		if ($this->id > 0)
		{
			
			$q = '	SELECT 	s.id
							,s.title
							,s.author
							,s.description
							,s.first_scene_container_id
							,s.image_id
							,i.filename
							,s.grid_x
							,s.grid_y
					FROM stories s
					LEFT OUTER JOIN images i
						ON s.image_id = i.id
					WHERE s.id = :id';
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
			$q = '	INSERT INTO stories
						(title
						,author
						,description
						,first_scene_container_id
						,image_id
						,grid_x
						,grid_y)
					VALUES (
						:title
						,:author
						,:description
						,:first_scene_container_id
						,:image_id						
						,:grid_x
						,:grid_y
						)';
						
			$results = DB::query(Database::INSERT,$q,TRUE)
								->param(':title',$this->title)
								->param(':author',$this->author)
								->param(':description',$this->description)
								->param(':first_scene_container_id',$this->first_scene_container_id)
								->param(':image_id',$this->image_id)
								->param(':grid_x',$this->grid_x)
								->param(':grid_y',$this->grid_y)
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
				
				
				$q = '	UPDATE stories
						SET title = :title							
							,author = :author
							,description = :description
							,first_scene_container_id = :first_scene_container_id
							,image_id = :image_id
							,grid_x = :grid_x
							,grid_y = :grid_y
						WHERE id = :id';
				$results['success'] = DB::query(Database::UPDATE,$q,TRUE)
										->param(':title',$this->title)
										->param(':author',$this->author)
										->param(':description',$this->description)	
										->param(':first_scene_container_id',$this->first_scene_container_id)
										->param(':image_id',$this->image_id)
										->param(':grid_x',$this->grid_x)
										->param(':grid_y',$this->grid_y)
										->param(':id',$this->id)
										->execute();														
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
		if ($this->id > 0)
		{
			//delete children 1st
			$this->load();
			foreach($this->containers as $container)
			{
				$container->delete();
			}
			
			$q = '	DELETE FROM stories
						WHERE id = :id';
			$results =	DB::query(Database::DELETE,$q,TRUE)
								->param(':id',$this->id)
								->execute();						
		}
		return 1;
	}
	
	function getScenes()
	{
		$available_scenes = array();
		foreach($this->containers as $container)
		{
			foreach($container->scenes as $scene)
			{
				$available_scenes[] = $scene;
			}
		}
		return $available_scenes;
	}
	
	function getFirstContainerId()
	{
		return $this->first_scene_container_id;
	}
		
	function grid()
	{
		return $this->grid_x.'x'.$this->grid_y;
	}	

	function __get($prop)
	{	
		return $this->$prop;
	}
}

?>
