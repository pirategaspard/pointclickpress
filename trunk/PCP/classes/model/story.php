<?php defined('SYSPATH') or die('No direct script access.');

class Model_Story extends Model 
{
	protected $id = 0;
	protected $title = '';
	protected $author = '';
	protected $description = '';
	protected $grid_x = '';
	protected $grid_y = '';
	protected $first_location_id = null;
	protected $image_id = 0;
	protected $filename = '';
	protected $status = 'd';
	protected $events = array();
	protected $locations = array();
	
	public function __construct($args=array())
	{
		parent::__construct();		
		$this->init($args);		
	}
	
	function init($args=array())
	{
		if (!isset($args['include_events'])) $args['include_events']=false;
		if (!isset($args['include_locations'])) $args['include_locations']=false;
		
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
		if (isset($args['first_location_id']) && ($args['first_location_id'] > 0))
		{
			$this->first_location_id = $args['first_location_id'];
		}
		if (isset($args['image_id']))
		{			
			$this->image_id = $args['image_id'];							
		}
		if (isset($args['filename']))
		{			
			$this->filename = $args['filename'];							
		}
		if (isset($args['status']))
		{			
			$this->status = $args['status'];							
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
		if ($args['include_locations'])
		{			
			$args['story'] = $this;
			$this->locations = PCPAdmin::getlocations($args);
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
							,s.first_location_id
							,s.image_id
							,s.status
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
		$results = new pcpresult();	
		if ($this->id == 0)
		{
			//INSERT new record
			try
			{
				$q = '	INSERT INTO stories
							(title
							,author
							,description
							,first_location_id
							,image_id
							,status
							,grid_x
							,grid_y)
						VALUES (
							:title
							,:author
							,:description
							,:first_location_id
							,:image_id
							,:status						
							,:grid_x
							,:grid_y
							)';
							
				$q_results = DB::query(Database::INSERT,$q,TRUE)
									->param(':title',$this->title)
									->param(':author',$this->author)
									->param(':description',$this->description)
									->param(':first_location_id',$this->first_location_id)
									->param(':image_id',$this->image_id)
									->param(':status',$this->status)
									->param(':grid_x',$this->grid_x)
									->param(':grid_y',$this->grid_y)
									->execute();			
				if ($q_results[1] > 0)
				{
					$this->id = $q_results[0];
					$results->success = 1;
				}
			}
			catch( Database_Exception $e )
			{
				throw new Kohana_Exception('Error Inserting Record in file: :file '.$e->getMessage(),
					array(':file' => Kohana::debug_path(__FILE__)));
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
							,first_location_id = :first_location_id
							,image_id = :image_id
							,status = :status
							,grid_x = :grid_x
							,grid_y = :grid_y
						WHERE id = :id';
				$results->success = DB::query(Database::UPDATE,$q,TRUE)
										->param(':title',$this->title)
										->param(':author',$this->author)
										->param(':description',$this->description)	
										->param(':first_location_id',$this->first_location_id)
										->param(':image_id',$this->image_id)
										->param(':status',$this->status)
										->param(':grid_x',$this->grid_x)
										->param(':grid_y',$this->grid_y)
										->param(':id',$this->id)
										->execute();														
			}
			catch( Database_Exception $e )
			{
				throw new Kohana_Exception('Error Updating Record in file: :file '.$e->getMessage(),
					array(':file' => Kohana::debug_path(__FILE__)));
			}
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
			//delete children first
			$this->init(array('include_locations'=>true,'include_scenes'=>true,'include_events'=>true))->load();
			foreach($this->locations as $location)
			{
				$location->delete();
			}
			foreach($this->events as $event)
			{
				$event->delete();
			}
			
			$q = '	DELETE FROM stories
						WHERE id = :id';
			$results->success =	DB::query(Database::DELETE,$q,TRUE)
								->param(':id',$this->id)
								->execute();						
		}		
		return $results;
	}
	
	function getScenes()
	{
		$available_scenes = array();
		foreach($this->locations as $location)
		{
			foreach($location->scenes as $scene)
			{
				$available_scenes[] = $scene;
			}
		}
		return $available_scenes;
	}
	
	function getFirstlocationId()
	{
		return $this->first_location_id;
	}
		
	function grid()
	{
		return $this->grid_x.'x'.$this->grid_y;
	}	
}

?>
