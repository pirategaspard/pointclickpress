<?php defined('SYSPATH') or die('No direct script access.');

/*
 * Story object 
 * */

class Model_Admin_Story extends Model_PCP_Story 
{
	
	function load($args=array())
	{		
		if ($this->id > 0)
		{
			$q = '	SELECT 	s.id
							,s.title
							,u.username AS author
							,s.description
							,s.first_location_id
							,s.image_id
							,s.status
							,i.filename
							,s.grid_x
							,s.grid_y
							,s.theme_name
							,s.creator_user_id
							,s.created_date
					FROM stories s
					LEFT OUTER JOIN images i
						ON s.image_id = i.id
					INNER JOIN users u 
						ON s.creator_user_id = u.id
						AND u.id = :creator_user_id
					WHERE s.id = :id';
			$results = DB::query(Database::SELECT,$q,TRUE)->param(':id',$this->id)
															->param(':creator_user_id',$this->creator_user_id)
															->execute()
															->as_array();				
			if (count($results) > 0 )
			{
				$this->init($results[0]);				
			}
			else
			{
				$this->init(array('id'=>0,'creator_user_id'=>0,'author'=>$this->author));
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
				$q = '	INSERT INTO stories
							(title
							,author
							,description
							,first_location_id
							,image_id
							,status
							,grid_x
							,grid_y
							,theme_name
							,creator_user_id)
						VALUES (
							:title
							,:author
							,:description
							,:first_location_id
							,:image_id
							,:status						
							,:grid_x
							,:grid_y
							,:theme
							,:creator_user_id
							)';
							
				$q_results = DB::query(Database::INSERT,$q,TRUE)
									->param(':title',$this->title)
									->param(':author',$this->author)
									->param(':description',$this->description)
									->param(':first_location_id',$this->first_location_id)
									->param(':image_id',$this->image_id)
									->param(':status',$this->status)
									->param(':grid_x',$this->grid_x)
									->param(':grid_y',$this->grid_y)
									->param(':theme_name',$this->theme_name)
									->param(':creator_user_id',$this->creator_user_id)
									->execute();			
				if ($q_results[1] > 0)
				{
					$this->id = $q_results[0];
					$results->success = 1;
				}
			}
			catch( Database_Exception $e )
			{
				throw new Kohana_Exception('Error Inserting Record in file: :file '.$e->getMessage(),
					array(':file' => __FILE__));
			}
		}
		elseif ($this->id > 0)
		{
			//UPDATE record
			try
			{
				$q = '	UPDATE stories
						SET title = :title							
							,author = :author
							,description = :description
							,first_location_id = :first_location_id
							,image_id = :image_id
							,status = :status
							,grid_x = :grid_x
							,grid_y = :grid_y
							,theme_name = :theme_name
						WHERE id = :id
							AND creator_user_id = :creator_user_id';
				$results->success = DB::query(Database::UPDATE,$q,TRUE)
										->param(':title',$this->title)
										->param(':author',$this->author)
										->param(':description',$this->description)	
										->param(':first_location_id',$this->first_location_id)
										->param(':image_id',$this->image_id)
										->param(':status',$this->status)
										->param(':grid_x',$this->grid_x)
										->param(':grid_y',$this->grid_y)
										->param(':theme_name',$this->theme_name)
										->param(':id',$this->id)
										->param(':creator_user_id',$this->creator_user_id)
										->execute();														
			}
			catch( Database_Exception $e )
			{
				throw new Kohana_Exception('Error Updating Record in file: :file '.$e->getMessage(),
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
			//delete children first
			$this->init(array('include_locations'=>true,'include_scenes'=>true,'include_actions'=>true))->load();
			foreach($this->locations as $location)
			{
				$location->delete();
			}
			foreach($this->actions as $action)
			{
				$action->delete();
			}
			
			$q = '	DELETE FROM stories
						WHERE id = :id 
						AND creator_user_id = :creator_user_id';
			$results->success =	DB::query(Database::DELETE,$q,TRUE)
								->param(':id',$this->id)
								->param(':creator_user_id',$this->creator_user_id)
								->execute();						
		}		
		return $results;
	}

	function setCreatorUserId($id)
	{
		$this->creator_user_id = $id; 
	}
}

?>
