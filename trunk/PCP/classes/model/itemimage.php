<?php defined('SYSPATH') or die('No direct script access.');
class Model_ItemImage extends Model 
{
	protected $id = 0;
	protected $story_id = 0;
	protected $value = DEFAULT_VALUE;
	protected $item_id = 0;
	protected $image_id = 0;
	protected $filename = '';			
	
	public function __construct($args=array())
	{
		parent::__construct();		
		$this->init($args);		
	}
	
	function init($args=array())
	{
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
		return $this;
	}
	
	function load($args=array())
	{		
		if ($this->id > 0)
		{
			$q = '	SELECT 	ii.id
							,ii.value
							,ii.item_id
							,ii.image_id
							,i.filename
							,i.story_id							
					FROM items_images ii
					LEFT OUTER JOIN images i
					ON ii.image_id = i.id
					WHERE ii.id = :id';
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
			$q = '	INSERT INTO items_images
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
				$q = '	UPDATE items_images
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
				
			$q = '	DELETE FROM items_images
						WHERE id = :id';
			$results->success =	DB::query(Database::DELETE,$q,TRUE)
								->param(':id',$this->id)
								->execute();						
		}
		$results->data = array('id'=>$this->id);
		return $results;
	}
}

?>
