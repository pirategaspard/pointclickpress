<?php defined('SYSPATH') or die('No direct script access.');
class Model_ItemState extends Model 
{
	protected $id = 0;
	protected $value = DEFAULT_ITEMSTATE_VALUE;
	protected $item_id = 0;
	protected $image_id = 0;
	protected $filename = '';	
	protected $path = '';
	protected $events = array();		
	
	public function __construct($args=array())
	{
		parent::__construct();		
		$this->init($args);		
	}
	
	function init($args=array())
	{
		if (!isset($args['include_events'])) $args['include_events']=false;
		
		if ((isset($args['id']))&&(is_numeric($args['id'])))
		{
			$this->id = $args['id'];
		}
		if (isset($args['value']))
		{
			$this->value = Formatting::createSlug($args['value']);
		}
		if (isset($args['item_id']))
		{
			$this->item_id = $args['item_id'];
		}		
		if (isset($args['image_id']))
		{
			$this->image_id = $args['image_id'];
		}
		if (isset($args['filename']))
		{
			$this->filename = $args['filename'];
		}
		if ($args['include_events'])
		{			
			$args['itemstate_id'] = $this->id;
			$this->events = EventsAdmin::getItemstateEvents($args);
		}		
		return $this;
	}
	
	function load($args=array())
	{		
		if ($this->id > 0)
		{
			$q = '	SELECT 	its.id
							,its.value
							,its.item_id
							,i.id as image_id
							,i.filename						
					FROM items_states its
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
			//INSERT new record
			$q = '	INSERT INTO items_states
						(value
						,item_id
						,image_id)
					VALUES (
						:value
						,:item_id
						,:image_id)';						
			$q_results = DB::query(Database::INSERT,$q,TRUE)								
								->param(':value',$this->value)
								->param(':item_id',$this->item_id)
								->param(':image_id',$this->image_id)
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
							,item_id = :item_id
							,image_id = :image_id
						WHERE id = :id';
				$results->success = DB::query(Database::UPDATE,$q,TRUE)
								->param(':value',$this->value)
								->param(':item_id',$this->item_id)
								->param(':image_id',$this->image_id)
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
	
	function setPath($string='')
	{
		$this->path = $string;
	}
}

?>
