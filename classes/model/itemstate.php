<?php defined('SYSPATH') or die('No direct script access.');
class Model_ItemState extends Model 
{
	protected $id = 0;
	protected $title = '';
	protected $value = DEFAULT_ITEMSTATE_VALUE;
	protected $itemdef_id = 0;
	protected $image_id = 0;
	protected $filename = '';
	protected $description = '';	
	protected $isdefaultstate = 0;
	protected $actions = array();		
	
	public function __construct($args=array())
	{
		$this->init($args);		
	}
	
	function init($args=array())
	{
		if (!isset($args['include_actions'])) $args['include_actions']=false;
		
		if ((isset($args['id']))&&(is_numeric($args['id'])))
		{
			$this->id = $args['id'];
		}
		if (isset($args['value']))
		{
			$this->value = Formatting::createSlug($args['value']);
		}
		if (isset($args['title']))
		{
			$this->title = $args['title'];
		}
		if (isset($args['description']))
		{
			$this->description = $args['description'];
		}
		if (isset($args['itemdef_id']))
		{
			$this->itemdef_id = $args['itemdef_id'];
		}	
		if (isset($args['image_id']))
		{
			$this->image_id = $args['image_id'];
		}
		if (isset($args['filename']))
		{
			$this->filename = $args['filename'];
		}
		if (isset($args['isdefaultstate']))
		{
			$this->isdefaultstate = $args['isdefaultstate'];
		}
		if ($args['include_actions'])
		{			
			$args['itemstate_id'] = $this->id;
			$this->actions = Model_Admin_ActionsAdmin::getItemstateActions($args);
		}		
		return $this;
	}
	
	function load($args=array())
	{		
		if ($this->id > 0)
		{
			$q = '	SELECT 	its.id
							,its.value
							,its.itemdef_id
							,its.isdefaultstate
							,its.description
							,i.id as image_id
							,i.filename	
							,id.title					
					FROM items_states its
					INNER JOIN itemdefs id
					ON its.itemdef_id = id.id
					LEFT OUTER JOIN images i
					ON its.image_id = i.id
					WHERE its.id = :id';
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
				// remove any other default states
				if($this->isdefaultstate)
				{
					$q = '	UPDATE items_states its
							INNER JOIN itemdefs i
								ON its.itemdef_id = i.id
							INNER JOIN stories s 
								ON i.story_id = s.id
								AND s.creator_user_id = :creator_user_id
							SET isdefaultstate = 0
							WHERE itemdef_id = :itemdef_id';
					$records_updated = DB::query(Database::UPDATE,$q,TRUE)
									->param(':itemdef_id',$this->itemdef_id)
									->param(':creator_user_id',Auth::instance()->get_user()->id)
									->execute();
				}
				
				//INSERT new record
				$q = '	INSERT INTO items_states
							(value
							,itemdef_id
							,image_id
							,description
							,isdefaultstate)
						SELECT DISTINCT
								:value as value
								,:itemdef_id as itemdef_id
								,:image_id as image_id
								,:description
								,:isdefaultstate as isdefaultstate
						FROM items_states
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
									->param(':value',$this->value)
									->param(':itemdef_id',$this->itemdef_id)
									->param(':image_id',$this->image_id)
									->param(':description',$this->description)
									->param(':isdefaultstate',$this->isdefaultstate)
									->param(':creator_user_id',Auth::instance()->get_user()->id)
									->execute();									
				if ($q_results[1] > 0)
				{
					$this->id = $q_results[0];
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Itemstate Saved";
				}
			}
			elseif ($this->id > 0)
			{
				//UPDATE record			
				$q = '	UPDATE items_states its
						INNER JOIN itemdefs i
							ON its.itemdef_id = i.id
						INNER JOIN stories s 
							ON i.story_id = s.id
							AND s.creator_user_id = :creator_user_id
						SET its.value = :value
							,its.itemdef_id = :itemdef_id
							,its.image_id = :image_id
							,its.description = :description
							,its.isdefaultstate = :isdefaultstate
						WHERE its.id = :id';
				$records_updated = DB::query(Database::UPDATE,$q,TRUE)
								->param(':value',$this->value)
								->param(':itemdef_id',$this->itemdef_id)
								->param(':image_id',$this->image_id)
								->param(':description',$this->description)
								->param(':isdefaultstate',$this->isdefaultstate)
								->param(':id',$this->id)
								->param(':creator_user_id',Auth::instance()->get_user()->id)
								->execute();
				if ($records_updated > 0)
				{
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Itemstate Saved";
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
					
				$actions = Model_PCP_Actions::getItemStateActions(array('itemstate_id'=>$this->id));
				foreach($actions as $action)
				{
					$action->delete();
				}
				
				$q = '	DELETE its 
						FROM items_states its
						INNER JOIN itemdefs i
							ON its.itemdef_id = i.id
						INNER JOIN stories s 
							ON i.story_id = s.id
							AND s.creator_user_id = :creator_user_id 
						WHERE its.id = :id';
				$records_updated =	DB::query(Database::DELETE,$q,TRUE)
									->param(':id',$this->id)
									->param(':creator_user_id',Auth::instance()->get_user()->id)
									->execute();
				if ($records_updated > 0)
				{
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Itemstate Deleted";
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
	
	function getPath($screen_size=DEFAULT_SCREEN_SIZE)
	{
		return $this->image_id.'/'.$screen_size.'/'.$this->filename;
	}
}

?>
