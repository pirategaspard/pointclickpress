<?php defined('SYSPATH') or die('No direct script access.');

/*
	A scene location hold multiple versions of a scene.
	For instance a scene where the door to the house is closed
	and a scene where the door the house is open.
 */
class Model_Location extends Model 
{
	protected $story_id = 0;
	protected $id = 0;
	protected $title = '';
	protected $slug = '';
	protected $actions = array();
	protected $scenes = array();
		
	//protected $values = array();	
	
	public function __construct($args=array())
	{
		parent::__construct();		
		$this->init($args);
	}
	
	function init($args=array())
	{
		if (!isset($args['include_actions'])) $args['include_actions']=false;
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
		if ($args['include_actions'])
		{			
			$args['location_id'] = $this->id;
			$this->actions = Model_PCP_Actions::getLocationActions($args);
		}
		if ($args['include_scenes'])
		{			
			$args['location_id'] = $this->id;
			$this->scenes = Model_PCP_Scenes::getScenes(array('location_id'=>$this->id));
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
					FROM locations c
					WHERE id = :id';
			$q_results = DB::query(Database::SELECT,$q,TRUE)->param(':id',$this->id)->execute()->as_array();
			
			if (count($q_results) > 0 )
			{
				$this->init($q_results[0]);							
				
				/*
				// get all possible values for scenes in this location
				if (count($this->scenes) > 0)
				{
					$q = '	SELECT DISTINCT s.value
							FROM locations c
							INNER JOIN scenes s
							ON s.location_id = c.id
							WHERE c.id = :id
							AND s.value != ""';  // 
					$q_results = DB::query(Database::SELECT,$q,TRUE)->param(':id',$this->id)->execute()->as_array();
					foreach($q_results as $q_result)
					{
						$this->values[] = $q_result['value'];
					}
				}*/
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
				$q = '	INSERT INTO locations
						(story_id,title)
						VALUES (:story_id,:title)';
				$q_results = DB::query(Database::INSERT,$q,TRUE)
								->param(':story_id',$this->story_id)
								->param(':title',$this->title)
								->execute();						
				if ($q_results[1] > 0)
				{
					$this->id = $q_results[0];
					$results->success = 1;
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
				$q = '	UPDATE locations
						SET title = :title
						WHERE id = :id';
				$results->success = DB::query(Database::UPDATE,$q,TRUE)
										->param(':title',$this->title)
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
			//delete all children first
			$this->init(array('include_locations'=>true,'include_scenes'=>true,'include_actions'=>true))->load();
			foreach($this->scenes as $scene)
			{
				$scene->delete();
			}
			foreach($this->actions as $action)
			{
				$action->delete();
			}
			
			$q = '	DELETE FROM locations
						WHERE id = :id';
			$results->success =	DB::query(Database::DELETE,$q,TRUE)
									->param(':id',$this->id)
									->execute();								
		}		
		return $results;
	}
	
	function getActions()
	{
		return Model_PCP_Actions::getLocationActions(array('location_id'=>$this->id));
	}
}

?>
