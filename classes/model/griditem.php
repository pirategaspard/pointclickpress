<?php defined('SYSPATH') or die('No direct script access.');
class Model_GridItem extends Model
{
	protected $id = 0;
	protected $title = '';	
	protected $slug = '';
	protected $itemdef_id = 0;
	protected $itemdef_title = '';
	protected $cell_id = NULL;	
	protected $scene_id = 0;
	protected $story_id = 0;
	
	public function __construct($args=array())
	{	
		$this->init($args);		
	}
	
	function init($args=array())
	{	
		if (isset($args['id']))
		{
			$this->id = $args['id'];
		}
		if (isset($args['title']))
		{
			$this->title = $args['title'];
			$this->slug = Formatting::createSlug($args['title']);
		}
		if (isset($args['itemdef_id']))
		{
			$this->itemdef_id = $args['itemdef_id'];
		}
		if (isset($args['itemdef_title']))
		{
			$this->itemdef_title = $args['itemdef_title'];
		}
		if (isset($args['cell_id']))
		{
			$this->cell_id = $args['cell_id'];
		}
		if (isset($args['scene_id']))
		{
			$this->scene_id = $args['scene_id'];
		}
		if (isset($args['story_id']))
		{
			$this->story_id = $args['story_id'];
		}
		return $this;
	}
	
	function load($args=array())
	{		
		//if (($this->id > 0)&&($this->scene_id > 0))
		if ($this->id > 0)
		{
			$q = '	SELECT 	gi.id
							,gi.title
							,gi.itemdef_id
							,gi.cell_id
							,gi.scene_id
							,sc.story_id
							,id.title as itemdef_title			
					FROM grids_items gi
					INNER JOIN scenes sc
					ON gi.scene_id = sc.id
					LEFT OUTER JOIN itemdefs id
					ON gi.itemdef_id = id.id
					WHERE gi.id = :id';
			$q_results = DB::query(Database::SELECT,$q,TRUE)->param(':id',$this->id)->execute()->as_array();											
							
			if (count($q_results) > 0 )
			{				
				$this->init($q_results[0]);	
			}
		}
		return $this;
	}	
	
	function save()
	{				
		$result = new pcpresult(PCPRESULT_STATUS_INFO,"Nothing was changed");
		try
		{
			if (($this->id == 0))
			{
				//INSERT new record
				$q = '	INSERT INTO grids_items
							(itemdef_id
							,scene_id
							,cell_id
							,title
							,slug
							)
						SELECT DISTINCT
							:itemdef_id
							,:scene_id
							,:cell_id
							,:title
							,:slug
						FROM stories
						WHERE EXISTS 
								(
									SELECT s.id 
									FROM itemdefs i
									INNER JOIN stories s 
										ON i.story_id = s.id
										AND s.creator_user_id = :creator_user_id
									WHERE i.id = :itemdef_id
								)';						
				$q_results = DB::query(Database::INSERT,$q,TRUE)
									->param(':itemdef_id',$this->itemdef_id)
									->param(':scene_id',$this->scene_id)
									->param(':cell_id',$this->cell_id)
									->param(':title',$this->title)
									->param(':slug',$this->slug)
									->param(':creator_user_id',Auth::instance()->get_user()->id)
									->execute();									
				if ($q_results[1] > 0)
				{
					$this->id = $q_results[0];
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Griditem Saved";
				}
			}
			elseif ($this->id > 0)
			{
				//UPDATE record
				$q = '	UPDATE grids_items g
						INNER JOIN itemdefs i
							ON g.itemdef_id = i.id
						INNER JOIN stories s 
							ON i.story_id = s.id
							AND s.creator_user_id = :creator_user_id
						SET g.itemdef_id = :itemdef_id
							,g.scene_id = :scene_id
							,g.cell_id = :cell_id
							,g.title = :title
							,g.slug = :slug
						WHERE g.id = :id';
				$records_updated = DB::query(Database::UPDATE,$q,TRUE)
								->param(':itemdef_id',$this->itemdef_id)
								->param(':scene_id',$this->scene_id)
								->param(':cell_id',$this->cell_id)
								->param(':title',$this->title)
								->param(':slug',$this->slug)
								->param(':id',$this->id)
								->param(':creator_user_id',Auth::instance()->get_user()->id)
								->execute();
				if ($records_updated > 0)
				{
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Griditem Saved";
				}																
			}				
		}
		catch( Database_Exception $e )
		{				
			$result->success = PCPRESULT_STATUS_FAILURE;
			$result->message = 'Error Saving Record';
			Kohana::$log->add(Log::ERROR, $e->getmessage().' in file'.__FILE__);
		}
		$result->data = array('id'=>$this->id);
		return $result;
	}
	
	function delete()
	{
		$result = new pcpresult(PCPRESULT_STATUS_INFO,"Nothing was changed");
		try
		{
			if ($this->id > 0)
			{
					
				// delete actions
				$actions = Model_PCP_Actions::getGridItemActions(array('griditem_id'=>$this->id));
				foreach($actions as $action)
				{
					$action->delete();
				}
				$q = '	DELETE g 
						FROM grids_items g
						INNER JOIN itemdefs i
							ON g.itemdef_id = i.id
						INNER JOIN stories s 
							ON i.story_id = s.id
							AND s.creator_user_id = :creator_user_id
						WHERE g.id = :id';
				$records_updated =	DB::query(Database::DELETE,$q,TRUE)
									->param(':id',$this->id)
									->param(':creator_user_id',Auth::instance()->get_user()->id)
									->execute();
				if ($records_updated > 0)
				{
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Griditem Deleted";
				}
			}
		}
		catch( Database_Exception $e )
		{
			$result->success = PCPRESULT_STATUS_FAILURE;
			$result->message = 'Error Deleting Record';
			Kohana::$log->add(Log::ERROR, $e->getmessage().' in file'.__FILE__);				
		}
		$result->data = array('id'=>$this->id);
		return $result;
	}
}

?>
