<?php defined('SYSPATH') or die('No direct script access.');

class Images
{	
	static function getImage($args=array())
	{
		// get a single story object and populate it based on the arguments
		$story = new Model_Image($args);
		$story->load($args);
		return $story;		
	}

	static function getImages($args=array())
	{				
		// get all the Images in the db
		$q = '	SELECT i.*
				FROM Images i
				INNER JOIN stories s
				ON i.story_id = s.id
				WHERE 1 = 1 ';
				
		if (isset($args['image'])) $q .= 'AND i.id = :image_id'; 
		if (isset($args['story_id'])) $q .= 'AND s.id = :story_id'; 
		
		$q .= ' ORDER BY i.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['image']))	 $q->param(':image_id',$args['image']->id);
		if (isset($args['story_id']))	 $q->param(':story_id',$args['story_id']);
								
		$tempArray = $q->execute()->as_array();		
		
		$Images = array();
		foreach($tempArray as $a)
		{
			$Images[$a['id']] = Images::getImage()->init($a);
		}
		return $Images;		
	}
	
	static function upload($args=array())
	{
		// Create the Upload and Media directories if they do not exist
		dir::prep_directory(UPLOAD_PATH);
		dir::prep_directory(MEDIA_PATH);
		
		// Do we have a story id?
		if (isset($_FILES)&&(isset($_POST['story_id']))&&($_POST['story_id'] > 0))
		{
			//set up image validation
			$valid = Validate::factory($_FILES)->rules('filename',array(
														'upload::valid'=>NULL, 
														'upload::not_empty'=>array(), 
														'upload::type'=>array(array('gif','jpg','jpeg','png')), 
														'upload::size'=>array('2M')));
			//is our image file valid?
			if ($valid->Check())
			{		
				//save filename to db & get image_id
				$results = images::getImage(array('story_id'=>$_POST['story_id'],'filename'=>$_FILES['filename']['name']))->save();
				
				//did we save to the db ok?
				if ($results['success'])
				{
					//get image Id from results
					$image_id = $results['id'];
					
					// make a folders named story_id with a folder image_id inside it
					// final path will be: /media/story_id/image_id/WxH/filename
					$media_path = APPPATH.MEDIA_PATH.DIRECTORY_SEPARATOR.$_POST['story_id'].DIRECTORY_SEPARATOR;
					dir::prep_directory($media_path);
					$media_path = $media_path.$image_id.DIRECTORY_SEPARATOR;
					dir::prep_directory($media_path);
					
					// upload original file from form 
					$temp_file = upload::save($_FILES['filename'],$_FILES['filename']['name'],APPPATH.UPLOAD_PATH.DIRECTORY_SEPARATOR);
					
					$filename = $_FILES['filename']['name'];  				
					
					//create directory for default image
					dir::prep_directory($media_path.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR);
					//create default image and save it			
					$success = Image::factory($temp_file)
												->resize(800, 600, Image::WIDTH)
												->save($media_path.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.$filename);		
					
					// did we resize & save the file to the upload dir ok?
					if ($success)
					{																
						//get array of Supported screens and add in the thumbnail size 
						$SCREENS = Screens::getScreens();
						$temp = explode('x',THUMBNAIL_IMAGE_SIZE);
						$SCREENS[] = array('w'=>$temp[0],'h'=>$temp[1]); 						
								
						// for each supported screen create image and save 	
						foreach($SCREENS as $screen)
						{
							//create directory to put image
							dir::prep_directory($media_path.DIRECTORY_SEPARATOR.$screen['w'].'x'.$screen['h'].DIRECTORY_SEPARATOR);
							
							$success = Image::factory($temp_file)
							->resize($screen['w'], $screen['h'], Image::WIDTH)
							->save($media_path.DIRECTORY_SEPARATOR.$screen['w'].'x'.$screen['h'].DIRECTORY_SEPARATOR.$filename,IMAGE_QUALITY);
						}
					}
					
					$results = array('success'=>$success,'filename'=>$filename,'path'=>UPLOAD_PATH.DIRECTORY_SEPARATOR,'image_id'=>$image_id);
				}
				else
				{			
					$results = array('success'=>false, 'message'=>'File was not saved to db');
				}
			}
			else
			{			
				$results = array_merge(array('success'=>false),$valid->errors());
			}
		}
		else
		{			
			$results = array('success'=>false, 'message'=>'No files and/or no story ID');
		}
		return $results;
	}
	
}
