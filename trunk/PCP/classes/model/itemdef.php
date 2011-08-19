<?php defined('SYSPATH') or die('No direct script access.');
// Item definition
class Model_ItemDef extends Model 
{
	protected $id = 0;
	protected $title = '';
	protected $slug = '';
	protected $story_id = 0;
	protected $states = array();
	protected $actions = array();			
	
	public function __construct($args=array())
	{	
		$this->init($args);		
	}
	
	function init($args=array())
	{
		if (!isset($args['include_itemstates'])) $args['include_itemstates']=false;
		if (!isset($args['include_actions'])) $args['include_actions']=false;
		
		if ((isset($args['id']))&&(is_numeric($args['id'])))
		{
			$this->id = $args['id'];
		}
		if (isset($args['title']))
		{
			$this->title = $args['title'];
			$this->slug = Formatting::createSlug($args['title']);
		}
		if (isset($args['story_id']))
		{
			$this->story_id = $args['story_id'];
		}		
		if ($args['include_itemstates'])
		{
			$args['itemdef_id'] = $this->id;
			$this->states = Model_Admin_Itemstates::getItemstates($args);
		}
		if ($args['include_actions'])
		{
			$args['itemdef_id'] = $this->id;
			$this->actions = Model_Admin_ActionsAdmin::getItemDefActions($args);
		}
		return $this;
	}
	
	function load($args=array())
	{		
		if ($this->id > 0)
		{
			$q = '	SELECT 	id.id
							,id.title
							,id.story_id
					FROM itemdefs id
					WHERE id.id = :id';
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
			if ($this->id == 0)
			{
				//INSERT new record
				$q = '	INSERT INTO itemdefs
							(title
							,story_id
							)
						SELECT DISTINCT
							:title
							,:story_id
						FROM stories
						WHERE EXISTS 
								(
									SELECT s.id 
									FROM stories s 
									WHERE s.id = :story_id 
									AND s.creator_user_id = :creator_user_id
								)';						
				$q_results = DB::query(Database::INSERT,$q,TRUE)
									->param(':title',$this->title)
									->param(':story_id',$this->story_id)
									->param(':creator_user_id',Auth::instance()->get_user()->id)
									->execute();									
				if ($q_results[1] > 0)
				{
					$this->id = $q_results[0];
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Item Definition Saved";
				}
			}
			elseif ($this->id > 0)
			{
				//UPDATE record
				$q = '	UPDATE itemdefs i
						INNER JOIN stories s 
							ON i.story_id = s.id
							AND s.creator_user_id = :creator_user_id
						SET i.title = :title
						WHERE i.id = :id';
				$records_updated = DB::query(Database::UPDATE,$q,TRUE)
								->param(':title',$this->title)
								->param(':id',$this->id)
								->param(':creator_user_id',Auth::instance()->get_user()->id)
								->execute();
				if ($records_updated > 0)
				{
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Item Definition Saved";
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
			
				// delete any item states and grid items associated with this item def				
				// delete itemStates
				$itemStates = Model_PCP_Itemstates::getItemstates(array('itemdef_id'=>$this->id));
				foreach($itemStates as $itemState)
				{
					$itemState->delete();
				}
				// delete gridItems
				$gridItems = Model_Admin_GridItemAdmin::getGridItems(array('itemdef_id'=>$this->id));
				var_dump($gridItems); die();
				foreach($gridItems as $gridItem)
				{
					$gridItem->delete();
				}
				$actions = Model_PCP_Actions::getItemDefActions(array('itemdef_id'=>$this->id));
				foreach($actions as $action)
				{
					$action->delete();
				}
								
				// delete item definition
				$q = '	DELETE i
						FROM itemdefs i
						INNER JOIN stories s 
							ON i.story_id = s.id
							AND s.creator_user_id = :creator_user_id
						WHERE i.id = :id';
				$records_updated =	DB::query(Database::DELETE,$q,TRUE)
									->param(':id',$this->id)
									->param(':creator_user_id',Auth::instance()->get_user()->id)
									->execute();	
				if ($records_updated > 0)
				{
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Item Definition Deleted";
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
