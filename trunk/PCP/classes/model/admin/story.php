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
			$result = DB::query(Database::SELECT,$q,TRUE)->param(':id',$this->id)
															->param(':creator_user_id',$this->creator_user_id)
															->execute()
															->as_array();				
			if (count($result) > 0 )
			{
				$this->init($result[0]);				
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
		$result = new pcpresult(PCPRESULT_STATUS_INFO,"Nothing was changed");	
		try
		{
			if ($this->id == 0)
			{
				//INSERT new record
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
							,:theme_name
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
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Story Saved";
				}
			}
			elseif ($this->id > 0)
			{
			//UPDATE record			
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
				$records_updated = DB::query(Database::UPDATE,$q,TRUE)
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
				if ($records_updated > 0)
				{
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Story Saved";
				}			
			}
		}
		catch( Database_Exception $e )
		{
			$result->success = PCPRESULT_STATUS_FAILURE;
			$result->message = 'Error Saving Record';
			Kohana::$log->add(Log::ERROR, $e->getMessage().' in file'.__FILE__);				
		}
		$result->data = array('id'=>$this->id);
		return $result;
	}
	
	function delete()
	{	
		$result = new pcpresult(PCPRESULT_STATUS_INFO,"Nothing was changed");
		$result->data = array('id'=>$this->id);
		try
		{
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
				// TODO: delete items
				
				
				$q = '	DELETE FROM stories
							WHERE id = :id 
							AND creator_user_id = :creator_user_id';
				$records_updated =	DB::query(Database::DELETE,$q,TRUE)
									->param(':id',$this->id)
									->param(':creator_user_id',$this->creator_user_id)
									->execute();						
				if ($records_updated > 0)
				{
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Story Deleted";
				}
			}			
		}
		catch( Database_Exception $e )
		{
			$result->success = PCPRESULT_STATUS_FAILURE;
			$result->message = 'Error Deleting Record';
			Kohana::$log->add(Log::ERROR, $e->getMessage().' in file'.__FILE__);				
		}		
		return $result;
	}

	function setCreatorUserId($id)
	{
		$this->creator_user_id = $id; 
	}
}

?>
