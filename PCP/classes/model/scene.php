<?php defined('SYSPATH') or die('No direct script access.');

class Model_Scene extends Model 
{
	protected $story_id = 0;
	protected $container_id = 0;
	protected $id = 0;	
	protected $title = "";
	protected $description = "";
	protected $image_id = 0;
	protected $filename = "";
	protected $value = NULL;	
	protected $events = array();
	protected $grid_events = array();
	
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
		if ((isset($args['container_id']))&&(is_numeric($args['container_id'])))
		{
			$this->container_id = $args['container_id'];
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
			$this->value = $args['value'];
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
		return $this;
	}
	
	function load($args=array())
	{
		
		if ($this->id > 0)
		{
			$q = '	SELECT 	s.id
							,s.story_id
							,s.container_id
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
		$results['id'] = $this->id;	
		$results['success'] = 0;
		
		if ($this->id == 0)
		{
			try
			{
				//INSERT new record
				$q = '	INSERT INTO scenes
							(story_id
							,container_id
							,title
							,description
							,image_id
							,value)
						VALUES (
							:story_id
							,:container_id
							,:title
							,:description
							,:image_id
							,:value
							)';
							
				$results = DB::query(Database::INSERT,$q,TRUE)
									->param(':story_id',$this->story_id)
									->param(':container_id',$this->container_id)
									->param(':title',$this->title)
									->param(':description',$this->description)
									->param(':image_id',$this->image_id)
									->param(':value',$this->value)
									->execute();			
				if ($results[1] > 0)
				{
					$results['id'] = $results[0];
					$results['success'] = 1;
				}
				else
				{
					echo('somethings wrong in '.__FILE__.' on '.__LINE__);
					var_dump($results);
				}
			}
			catch( Database_Exception $e )
			{
			  echo('somethings wrong in '.__FILE__.' on '.__LINE__);
			  echo $e->getMessage(); die();
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
				$results['success'] = DB::query(Database::UPDATE,$q,TRUE)
										->param(':title',$this->title)
										->param(':description',$this->description)
										->param(':image_id',$this->image_id)
										->param(':value',$this->value)
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
			// delete children 1st
			$this->load();
			foreach($this->events as $event)
			{
				$event->delete();
			}
			foreach($this->grid_events as $event)
			{
				$event->delete();
			}
			
			$q = '	DELETE FROM scenes
						WHERE id = :id';
			$results =	DB::query(Database::DELETE,$q,TRUE)
								->param(':id',$this->id)
								->execute();							
		}
		return 1;
	}
	
	function getPath($w=NULL,$h=NULL)
	{
		if(($w == NULL) || ($h == NULL))
		{
			$screen = 'default';
		}		
		else
		{
			$screen = $w.'x'.$h;
		}		
		$regex = DIRECTORY_SEPARATOR;
		//return Kohana::$base_url.MEDIA_PATH.$this->story_id.DIRECTORY_SEPARATOR.$this->container_id.DIRECTORY_SEPARATOR.$this->id.DIRECTORY_SEPARATOR.$screen.DIRECTORY_SEPARATOR.$this->filename;
		//return preg_replace("/$regex /",'/',Kohana::$base_url.MEDIA_PATH.'/'.trim($this->story_id).'/'.$this->container_id.'/'.$this->id.'/'.$screen.'/'.$this->filename);
		//return Kohana::$base_url.MEDIA_PATH.'/'.trim($this->story_id).'/'.$this->container_id.'/'.$this->id.'/'.$screen.'/'.$this->filename;
		return Kohana::$base_url.MEDIA_PATH.'/'.trim($this->story_id).'/'.$this->image_id.'/'.$screen.'/'.$this->filename;

	}
	
	/*
		This function allows the Admin to set the title 
		of an empty scene to be the same as the container it is in
	*/
	function setTitle($string)
	{			
		$this->title = $string;
	}

	function __get($prop)
	{			
		return $this->$prop;
	}

}

?>
