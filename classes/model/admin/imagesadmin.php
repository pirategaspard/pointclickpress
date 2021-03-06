<?php defined('SYSPATH') or die('No direct script access.');
class Model_Admin_ImagesAdmin
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
				FROM images i
				INNER JOIN stories s
				ON i.story_id = s.id
				WHERE 1 = 1 ';
				
		if (isset($args['image'])) $q .= ' AND i.id = :image_id'; 
		if (isset($args['story_id'])) $q .= ' AND s.id = :story_id';
		if (isset($args['type_id'])) $q .= ' AND i.type_id = :type_id'; 
		
		$q .= ' ORDER BY i.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['image']))	 $q->param(':image_id',$args['image']->id);
		if (isset($args['story_id']))	 $q->param(':story_id',$args['story_id']);
		if (isset($args['type_id']))	 $q->param(':type_id',$args['type_id']);
								
		$tempArray = $q->execute()->as_array();		
		
		$Images = array();
		foreach($tempArray as $a)
		{
			$Images[$a['id']] = self::getImage()->init($a);
		}
		return $Images;		
	}
	
	static function upload($args=array())
	{		
		// increase timeout so we can resize images
		set_time_limit(240);
		ini_set('memory_limit', '256M');
		// Create the Upload and Media directories if they do not exist
		model_utils_dir::prep_directory(UPLOAD_PATH);
		model_utils_dir::prep_directory(MEDIA_PATH);
		
		try
		{
			// Do we have a story id?
			if (isset($_FILES)&&(isset($_POST['story_id']))&&($_POST['story_id'] > 0))
			{
				//set up image validation
				$valid = Validation::factory($_FILES)->rules('filename',array(
															array('upload::valid',NULL), 
															array('upload::not_empty',NULL),
															array('upload::size',array(':value','3M')), 
															array('upload::type',array(':value',array('gif','jpg','jpeg','png'))), 
															));				
				//is our image file valid?
				if ($valid->Check())
				{
					// get original file name 
					$filename = $_FILES['filename']['name'];
						 
					// remove original extension and create alternate file type. JPG always seems to be smallest 
					//$filename = substr($filename,0,strpos($filename,'.')).'.png'; 
						
					//save filename to db & get image_id
					$result = self::getImage(array('story_id'=>$_POST['story_id'],'filename'=>$filename,'type_id'=>$args['type_id']))->save();
					//did we save to the db ok?					
					if ($result->success)
					{
						//get image Id from results
						$image_id = $result->data['id'];
						
						// make a folders named story_id with a folder image_id inside it
						// final path will be: /media/story_id/image_id/WxH/filename
						$media_path = APPPATH.MEDIA_PATH.DIRECTORY_SEPARATOR.$_POST['story_id'].DIRECTORY_SEPARATOR;
						model_utils_dir::prep_directory($media_path);
						$media_path = $media_path.$image_id.DIRECTORY_SEPARATOR;
						model_utils_dir::prep_directory($media_path);
						
						// upload original file from form 
						$temp_file = upload::save($_FILES['filename'],$_FILES['filename']['name'],APPPATH.UPLOAD_PATH.DIRECTORY_SEPARATOR);																				
						
						// save default image 
						$dest = $media_path.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR;
						$success = self::saveImage($temp_file,DEFAULT_SCREEN_WIDTH,DEFAULT_SCREEN_HEIGHT,$media_path,$filename,0,$dest);
						// save thumbnail
						$success = self::saveImage($temp_file,THUMBNAIL_IMAGE_WIDTH,THUMBNAIL_IMAGE_HEIGHT,$media_path,$filename);
						  
																											
						// did we resize & save the file to the upload dir ok?
						if ($success)
						{
							// determine reduction percentage
							if ($args['type_id'] == 2)
							{
								// if this is a item image
								// reduce image by a percentage determined by the default image size
								// so that it maintains the same relative size
								$ThisImage = Image::factory($temp_file);
								$width_reduction_percentage = ($ThisImage->width / DEFAULT_SCREEN_WIDTH);
								$height_reduction_percentage = ($ThisImage->height / DEFAULT_SCREEN_HEIGHT);						
							}
							else
							{
								$reduction_percentage = SCENE_IMAGE_REDUCTION_PERCENT * 0.01; 
							}
																								
							//get array of Supported screens and add in the thumbnail size 
							$SCREENS = Model_PCP_Screens::getScreens();													
							// for each supported screen create image and save 	
							foreach($SCREENS as $screen)
							{
								if ($args['type_id'] == 2)
								{
									$success = self::saveitemstate($temp_file,$screen['w'],$screen['h'],$media_path,$filename,$width_reduction_percentage,$height_reduction_percentage);
								}
								else
								{
									$success = self::saveImage($temp_file,$screen['w'],$screen['h'],$media_path,$filename,$reduction_percentage);
								}								
							}
							unlink($temp_file); // delete original upload file when done							
							if ($success)
							{
								$result = new pcpresult(PCPRESULT_STATUS_SUCCESS,'Image Saved',array('filename'=>$filename,'path'=>UPLOAD_PATH.DIRECTORY_SEPARATOR,'image_id'=>$image_id));								
							}
							else
							{
								$result = new pcpresult(PCPRESULT_STATUS_FAILURE,'Image file was not saved to disk');
								Kohana::$log->add(Log::ERROR, 'Image file was not saved to disk');
							}
						}
						else
						{
							$result = new pcpresult(PCPRESULT_STATUS_FAILURE,'Image file was not saved to upload directory');
							Kohana::$log->add(Log::ERROR, 'Image file was not saved to upload directory');
						}											
					}
					else
					{			
						$result = new pcpresult(PCPRESULT_STATUS_FAILURE,'Image file was not saved to db');
						Kohana::$log->add(Log::ERROR, 'Image file was not saved to db');
					}
				}
				else
				{			
					$result = new pcpresult(PCPRESULT_STATUS_FAILURE,'Image did not pass validation',array('errors'=>$valid->errors()));
					Kohana::$log->add(Log::ERROR, 'Image did not pass validation');
				}
			}
			else
			{			
				$result = new pcpresult(PCPRESULT_STATUS_FAILURE,'No files and/or no story ID');
				Kohana::$log->add(Log::ERROR, 'No files and/or no story ID');
			}
		}
		catch (Exception $e)
		{			
			$result = new pcpresult(PCPRESULT_STATUS_FAILURE,'There was an error while saving the image');
			$error = Kohana_Exception::text($e);// Get the text of the exception
			Kohana::$log->add(Log::ERROR, $error);// Add this exception to the log
		}
		return $result;
	}			
	
	// For scene backgrounds
	static function saveImage($temp_file,$screen_width,$screen_height,$media_path,$filename,$reduction_percentage=0,$dest=NULL)
	{	
		if (!$dest)
		{	
			// create directory name from screen w and h
			$dest = $media_path.DIRECTORY_SEPARATOR.$screen_width.'x'.$screen_height.DIRECTORY_SEPARATOR;
		}
		//create directory to put image		
		model_utils_dir::prep_directory($dest);
		// get image obj
		$ThisImage = Image::factory($temp_file);							
		// reduce size by a small percentage to assure that image will fit on screen properly;														
		$width = $screen_width - ($screen_width * $reduction_percentage);
		$height = $screen_height - ($screen_height * $reduction_percentage);						
		//save file
		$success = $ThisImage->resize($width, $height,Image::NONE)->save($dest.$filename,IMAGE_QUALITY);
		return $success;
	}
		
	// For scene backgrounds
	static function saveitemstate($temp_file,$screen_width,$screen_height,$media_path,$filename,$width_reduction_percentage=1,$height_reduction_percentage=1,$dest=NULL)
	{		
		if (!$dest)
		{	
			// create directory name from screen w and h
			$dest = $media_path.DIRECTORY_SEPARATOR.$screen_width.'x'.$screen_height.DIRECTORY_SEPARATOR;
		}
		//create directory to put image		
		model_utils_dir::prep_directory($dest);
		// get image obj
		$ThisImage = Image::factory($temp_file);							
		// reduce image by a percentage determined by the default image size
		// so that it maintains the same relative size 										
		$width = ($screen_width * $width_reduction_percentage);
		$height = ($screen_height * $height_reduction_percentage);								
		//save file
		$success = $ThisImage->resize($width, $height,Image::NONE)->save($dest.$filename,IMAGE_QUALITY);
		return $success;
	}
	
	
	/*
	static function resize_png($src,$dst,$dstw,$dsth)
	{
	    list($width, $height, $type, $attr) = getimagesize($src);
	    $im = imagecreatefrompng($src);
	    $tim = imagecreatetruecolor($dstw,$dsth);
	    imagecopyresampled($tim,$im,0,0,0,0,$dstw,$dsth,$width,$height);
	    $tim = Images::ImageTrueColorToPalette2($tim,false,255);
	    imagepng($tim,$dst,0,PNG_ALL_FILTERS);
	}
	
	//zmorris at zsculpt dot com function, a bit completed
	static function ImageTrueColorToPalette2($image, $dither, $ncolors) 
	{
	    $width = imagesx( $image );
	    $height = imagesy( $image );
	    $colors_handle = ImageCreateTrueColor( $width, $height );
	    ImageCopyMerge( $colors_handle, $image, 0, 0, 0, 0, $width, $height, 100 );
	    ImageTrueColorToPalette( $image, $dither, $ncolors );
	    ImageColorMatch( $colors_handle, $image );
	    ImageDestroy($colors_handle);
	    return $image;
	}
	*/	
	
	static function getData()
	{
		$session = Session::instance('admin');	
		$data = $_POST;
		//Model_Admin_PCPAdmin::clearArgs();
		if (isset($_REQUEST['story_id']))
		{
			$data['story_id'] = $_REQUEST['story_id'];			
		}
		else if ($session->get('story_id'))
		{
			$data['story_id'] = $session->get('story_id');
		}
		if (isset($_REQUEST['scene_id']))
		{
			$data['scene_id'] = $_REQUEST['scene_id'];			
		}
		else if ($session->get('scene_id'))
		{
			$data['scene_id'] = $session->get('scene_id');
		}
		if (isset($_REQUEST['itemstate_id']))
		{
			$data['itemstate_id'] = $_REQUEST['itemstate_id'];			
		}
		else if ($session->get('itemstate_id'))
		{
			$data['itemstate_id'] = $session->get('itemstate_id');
		}
		if (isset($_REQUEST['image_id']))
		{
			$data['id'] = $data['image_id'] = $_REQUEST['image_id'];			
		}
		else if ($session->get('image_id'))
		{
			$data['id'] = $data['image_id'] = $session->get('image_id');
		}
		else
		{
			$data['id'] = $data['image_id'] = 0;
		}
		if (isset($_REQUEST['type_id']))
		{
			$data['type_id'] = $_REQUEST['type_id'];			
		}
		else
		{
			$data['type_id'] = self::getImageType($data);
		}
		$data['url'] = self::getAddUrlArgs($data);
		$data['user_id'] = $data['creator_user_id'] = Auth::instance()->get_user()->id;
		return $data;
	}
	
	static function getImageType($args)
	{
		if (isset($args['itemstate_id']))
		{
			$type_id = 2; 
		}
		else
		{
			$type_id = 1; 	
		}
		return $type_id;
	}
	
	static function getAddUrlArgs($data)
	{
		$AddUrlArgs = '';
		if (isset($data['story_id']))
		{
			$AddUrlArgs .= '&story_id='.$data['story_id'];
		}
		if (isset($data['scene_id']))
		{
			$AddUrlArgs .= '&scene_id='.$data['scene_id'];
		}
		if (isset($data['itemstate_id']))
		{
			$AddUrlArgs .= '&itemstate_id='.$data['itemstate_id']; 
		}
		return $AddUrlArgs;
	}
}
