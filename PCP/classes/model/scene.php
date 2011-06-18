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
	protected $value = DEFAULT_SCENE_VALUE;	
	protected $actions = array();
	protected $grid_actions = array();
	protected $items = array();
	
	public function __construct($args=array())
	{	
		$this->init($args);		
	}
	
	function init($args=array())
	{
		if (!isset($args['include_actions'])) $args['include_actions']=false;
		if (!isset($args['include_items'])) $args['include_items']=false;
		
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
		if ($args['include_actions'])
		{			
			$args['scene_id'] = $this->id;
			$this->actions = Model_Admin_ActionsAdmin::getSceneActions($args);
			$this->grid_actions = Model_Admin_ActionsAdmin::getGridActions($args);	
		}
		if (isset($args['include_items']))
		{				
			$args['scene_id'] = $this->id;		
			$this->items = Model_Admin_GridItemAdmin::getGridItems($args);
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
						SELECT DISTINCT
							:story_id AS story_id
							,:location_id AS location_id
							,:title AS title
							,:description AS description
							,:image_id AS image_id
							,:value AS value														
						FROM stories
						WHERE EXISTS 
								(
									SELECT s.id 
									FROM stories s 
									WHERE s.id = :story_id 
									AND s.creator_user_id = :creator_user_id
								)';
							
				$q_results = DB::query(Database::INSERT,$q,TRUE)
									->param(':story_id',$this->story_id)
									->param(':location_id',$this->location_id)
									->param(':title',$this->title)
									->param(':description',$this->description)
									->param(':image_id',$this->image_id)
									->param(':value',$this->value)
									->param(':creator_user_id',Auth::instance()->get_user()->id)
									->execute();			
				if ($q_results[1] > 0)
				{
					$this->id = $q_results[0];
					$results->success = 1;
				}
				else
				{
					Kohana::$log->add(Log::ERROR, 'Error Updating Record in file'.__FILE__);
					throw new Kohana_Exception('Error Updating Record in file: :file '.$e->getMessage(),
					array(':file' => __FILE__));
				}
			}
			catch( Database_Exception $e )
			{
				Kohana::$log->add(Log::ERROR, 'Error Updating Record in file'.__FILE__);
				throw new Kohana_Exception('Error Updating Record in file: :file '.$e->getMessage(),
					array(':file' => __FILE__));
			}
		}
		elseif ($this->id > 0)
		{
			//UPDATE record
			try
			{
				$q = '	UPDATE scenes sc
						INNER JOIN stories s 
							ON sc.story_id = s.id
							AND s.creator_user_id = :creator_user_id
						SET sc.title = :title
							,sc.description = :description
							,sc.image_id = :image_id
							,sc.value = :value
						WHERE sc.id = :id';
				$results->success = DB::query(Database::UPDATE,$q,TRUE)
										->param(':title',$this->title)
										->param(':description',$this->description)
										->param(':image_id',$this->image_id)
										->param(':value',$this->value)
										->param(':id',$this->id)
										->param(':creator_user_id',Auth::instance()->get_user()->id)
										->execute();														
			}
			catch( Database_Exception $e )
			{
				Kohana::$log->add(Log::ERROR, 'Error Updating Record in file'.__FILE__);
				throw new Kohana_Exception('Error Updating Record in file: :file',
					array(':file' => __FILE__));
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
			$this->init(array('include_actions'=>true))->load();						
			foreach($this->actions as $action)
			{
				$action->delete();
			}
			foreach($this->grid_actions as $grid_action)
			{
				$grid_action->delete();
			}
			
			$q = '	DELETE sc 
					FROM scenes sc
					INNER JOIN stories s 
						ON sc.story_id = s.id
						AND s.creator_user_id = :creator_user_id 
					WHERE sc.id = :id';
			$results->success =	DB::query(Database::DELETE,$q,TRUE)
											->param(':id',$this->id)
											->param(':creator_user_id',Auth::instance()->get_user()->id)
											->execute();							
		}		
		return $results;
	}
	
	function getPath($screen_size=NULL,$w=NULL,$h=NULL)
	{
		if((($w == NULL) || ($h == NULL)) && ($screen_size == NULL))
		{
			$screen_size = DEFAULT_SCREEN_SIZE;
		}		
		elseif (($w)&&($h))
		{
			$screen_size = $w.'x'.$h;
		}
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
	
	function getActions()
	{
		return Model_PCP_Actions::getSceneActions(array('scene_id'=>$this->id));
	}

}

?>
