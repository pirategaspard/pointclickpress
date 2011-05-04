<?php defined('SYSPATH') or die('No direct script access.');

/*
 * Story object 
 * */

class Model_PCP_Story extends Model 
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
	protected $theme_name = DEFAULT_THEME_NAME;
	protected $creator_user_id = 0;
	protected $actions = array();
	protected $locations = array();
	
	public function __construct($args=array())
	{
		$this->init($args);		
	}
	
	function init($args=array())
	{
		if (!isset($args['include_actions'])) $args['include_actions']=false;
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
		if (isset($args['theme_name']))
		{			
			$this->theme_name = $args['theme_name'];							
		}
		if (isset($args['creator_user_id']))
		{			
			$this->creator_user_id = $args['creator_user_id'];							
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
		
		if ($args['include_actions'])
		{			
			$args['story_id'] = $this->id;
			$this->actions = Model_PCP_Actions::getStoryActions($args);
		}
		if ($args['include_locations'])
		{			
			$args['story_id'] = $this->id;
			$this->locations = Model_PCP_Locations::getLocations($args);
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
							,s.theme_name
							,s.creator_user_id
							,s.created_date
					FROM stories s
					LEFT OUTER JOIN images i
						ON s.image_id = i.id
					WHERE s.id = :id';
			$results = DB::query(Database::SELECT,$q,TRUE)->param(':id',$this->id)
															->execute()
															->as_array();				
			if (count($results) > 0 )
			{
				$this->init($results[0]);				
			}
		}
		return $this;
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
	
	function getActions()
	{
		return Model_PCP_Actions::getStoryActions(array('story_id'=>$this->id));
	}
	
	function setCreatorUserId($id)
	{
		$this->creator_user_id = $id; 
	}
}

?>
