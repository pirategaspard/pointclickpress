<?php defined('SYSPATH') or die('No direct script access.');
class Model_Item extends Model 
{
	protected $id = 0;
	protected $title = '';
	protected $story_id = 0;
	protected $image_id = 0;
	protected $filename = '';
	protected $images = array();			
	
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
		if (isset($args['title']))
		{
			$this->title = $args['title'];
		}
		if (isset($args['story_id']))
		{
			$this->story_id = $args['story_id'];
		}		
		if (isset($args['image_id']))
		{
			$this->image_id = $args['image_id'];
		}
		if (isset($args['filename']))
		{
			$this->filename = $args['filename'];
		}
		if (isset($args['include_itemimages']))
		{
			$args['item'] = $this;
			$this->images = ImagesAdmin::getItemImages($args);
		}
		return $this;
	}
	
	function load($args=array())
	{		
		if ($this->id > 0)
		{
			$q = '	SELECT 	it.id
							,it.title
							,it.story_id
					FROM items it
					WHERE it.id = :id';
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
			$q = '	INSERT INTO items
						(title
						,story_id
						)
					VALUES (
						:title
						,:story_id
						)';						
			$q_results = DB::query(Database::INSERT,$q,TRUE)
								->param(':title',$this->title)
								->param(':story_id',$this->story_id)
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
				$q = '	UPDATE items
						SET title = :title,
						WHERE id = :id';
				$results->success = DB::query(Database::UPDATE,$q,TRUE)
								->param(':title',$this->title)
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
				
			$q = '	DELETE FROM items
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
