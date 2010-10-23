<?php defined('SYSPATH') or die('No direct script access.');

class Model_Scene extends Model 
{
	protected $story_id = 0;
	protected $location_id = 0;
	protected $id = 0;	
	protected $title = "";
	protected $description = "";
	protected $image_id = 0;
	protected $filename = "";
	protected $value = DEFAULT_VALUE;	
	protected $events = array();
	protected $grid_events = array();
	protected $items = array();
	
	public function __construct($args=array())
	{
		parent::__construct();		
		$this->init($args);		
	}
	
	function init($args=array())
	{
		if ((isset($args['story_id']))&&(is_numeric($args['story_id'])))
		{
			$this->story_id = $args['story_id'];
		}
		if ((isset($args['location_id']))&&(is_numeric($args['location_id'])))
		{
			$this->location_id = $args['location_id'];
		}
		if ((isset($args['id']))&&(is_numeric($args['id'])))
		{
			$this->id = $args['id'];
		}
		if (isset($args['title']))
		{
			$this->title = $args['title'];
		}
		if (isset($args['description']))
		{
			$this->description = $args['description'];
		}
		if (isset($args['image_id']))
		{			
			$this->image_id = $args['image_id'];							
		}
		if (isset($args['filename']))
		{			
			$this->filename = $args['filename'];							
		}
		if (isset($args['value']))
		{
			$this->value = Formatting::createSlug($args['value']);
		} 
		if (isset($args['init_vars']))
		{
			$this->init_vars = $args['init_vars'];
		} 
		if (isset($args['include_events']))
		{			
			$args['scene'] = $this;
			$this->events = EventsAdmin::getSceneEvents($args);
			$this->grid_events = EventsAdmin::getGridEvents($args);	
		}
		if (isset($args['include_items']))
		{			
			$args['scene'] = $this;
			if (isset($args['simple_items']))
			{
				$this->items = Model_Items::getGridItems($args);
			}
			else
			{
				$this->items = ItemAdmin::getGridItems($args);
			}	
		}
		return $this;
	}
	
	function load($args=array())
	{
		
		if ($this->id > 0)
		{
			$q = '	SELECT 	s.id
							,s.story_id
							,s.location_id
							,s.title
							,s.description
							,s.image_id
							,i.filename
							,s.value
					FROM scenes s
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
			try
			{
				//INSERT new record
				$q = '	INSERT INTO scenes
							(story_id
							,location_id
							,title
							,description
							,image_id
							,value)
						VALUES (
							:story_id
							,:location_id
							,:title
							,:description
							,:image_id
							,:value
							)';
							
				$q_results = DB::query(Database::INSERT,$q,TRUE)
									->param(':story_id',$this->story_id)
									->param(':location_id',$this->location_id)
									->param(':title',$this->title)
									->param(':description',$this->description)
									->param(':image_id',$this->image_id)
									->param(':value',$this->value)
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
			catch( Database_Exception $e )
			{
				throw new Kohana_Exception('Error Updating Record in file: :file',
					array(':file' => Kohana::debug_path(__FILE__)));
			}
		}
		elseif ($this->id > 0)
		{
			//UPDATE record
			try
			{
				$q = '	UPDATE scenes
						SET title = :title
							,description = :description
							,image_id = :image_id
							,value = :value
						WHERE id = :id';
				$results->success = DB::query(Database::UPDATE,$q,TRUE)
										->param(':title',$this->title)
										->param(':description',$this->description)
										->param(':image_id',$this->image_id)
										->param(':value',$this->value)
										->param(':id',$this->id)
										->execute();														
			}
			catch( Database_Exception $e )
			{
				throw new Kohana_Exception('Error Updating Record in file: :file',
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
			// delete children 1st
			$this->init(array('include_events'=>true))->load();						
			foreach($this->events as $event)
			{
				$event->delete();
			}
			foreach($this->grid_events as $grid_event)
			{
				$grid_event->delete();
			}
			
			$q = '	DELETE FROM scenes
						WHERE id = :id';
			$results->success =	DB::query(Database::DELETE,$q,TRUE)
											->param(':id',$this->id)
											->execute();							
		}		
		return $results;
	}
	
	function getPath($w=NULL,$h=NULL,$screen_size=NULL)
	{
		if((($w == NULL) || ($h == NULL)) && ($screen_size == NULL))
		{
			$screen_size = DEFAULT_STORY_WIDTH.'x'.DEFAULT_STORY_HEIGHT;
		}		
		elseif (($w)&&($h))
		{
			$screen_size = $w.'x'.$h;
		}
		$regex = DIRECTORY_SEPARATOR;
		return Kohana::$base_url.MEDIA_PATH.'/'.trim($this->story_id).'/'.$this->image_id.'/'.$screen_size.'/'.$this->filename;

	}
	
	/*
		This function allows the Admin to set the title 
		of an empty scene to be the same as the location it is in
	*/
	function setTitle($string)
	{			
		$this->title = $string;
	}

}

?>
