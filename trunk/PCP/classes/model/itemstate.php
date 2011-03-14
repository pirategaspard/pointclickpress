<?php defined('SYSPATH') or die('No direct script access.');
class Model_ItemState extends Model 
{
	protected $id = 0;
	protected $title = '';
	protected $value = DEFAULT_ITEMSTATE_VALUE;
	protected $itemdef_id = 0;
	protected $image_id = 0;
	protected $filename = '';	
	protected $isdefaultstate = 0;
	protected $events = array();		
	
	public function __construct($args=array())
	{
		parent::__construct( );		
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
			$this->events = Model_Admin_ActionsAdmin::getItemstateActions($args);
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
		$results = new pcpresult();
		if ($this->id == 0)
		{
			// remove any other default states
			if($this->isdefaultstate)
			{
				$q = '	UPDATE items_states
						SET isdefaultstate = 0
						WHERE itemdef_id = :itemdef_id';
				$results->success = DB::query(Database::UPDATE,$q,TRUE)
								->param(':itemdef_id',$this->itemdef_id)
								->execute();
			}
			
			//INSERT new record
			$q = '	INSERT INTO items_states
						(value
						,itemdef_id
						,image_id
						,isdefaultstate)
					VALUES (
						:value
						,:itemdef_id
						,:image_id
						,:isdefaultstate)';						
			$q_results = DB::query(Database::INSERT,$q,TRUE)								
								->param(':value',$this->value)
								->param(':itemdef_id',$this->itemdef_id)
								->param(':image_id',$this->image_id)
								->param(':isdefaultstate',$this->isdefaultstate)
								->execute();									
			if ($q_results[1] > 0)
			{
				$this->id = $q_results[0];
				$results->success = 1;
			}
			else
			{
				throw new Kohana_Exception('Error Inserting Record in file: :file',
					array(':file' => Kohana::debug_path(__FILE__)));
			}
		}
		elseif ($this->id > 0)
		{
			//UPDATE record
			try
			{
				$q = '	UPDATE items_states
						SET value = :value
							,itemdef_id = :itemdef_id
							,image_id = :image_id
							,isdefaultstate = :isdefaultstate
						WHERE id = :id';
				$results->success = DB::query(Database::UPDATE,$q,TRUE)
								->param(':value',$this->value)
								->param(':itemdef_id',$this->itemdef_id)
								->param(':image_id',$this->image_id)
								->param(':isdefaultstate',$this->isdefaultstate)
								->param(':id',$this->id)
								->execute();																	
			}
			catch( Database_Exception $e )
			{
				var_dump($e); die();
				throw new Kohana_Exception('Error Updating Record in file: :file - ',
					array(':file' => Kohana::debug_path(__FILE__)));
			}
		}
		$results->data = array('id'=>$this->id);
		return $results;
	}
	
	function delete()
	{
		$results = new pcpresult();
		if ($this->id > 0)
		{
				
			$q = '	DELETE FROM items_states
						WHERE id = :id';
			$results->success =	DB::query(Database::DELETE,$q,TRUE)
								->param(':id',$this->id)
								->execute();						
		}
		$results->data = array('id'=>$this->id);
		return $results;
	}
	
	function getPath($screen_size=DEFAULT_SCREEN_SIZE)
	{
		return $this->image_id.'/'.$screen_size.'/'.$this->filename;
	}
}

?>
