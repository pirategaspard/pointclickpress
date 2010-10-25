<?php defined('SYSPATH') or die('No direct script access.');
class ImagesAdmin
{	
	static function getImage($args=array())
	{
		// get a single story object and populate it based on the arguments
		$story = new Model_Image($args);
		$story->load($args);
		return $story;		
	}
	
	static function getItemImage($args=array())
	{
		// get a single story object and populate it based on the arguments
		$story = new Model_ItemImage($args);
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
			$Images[$a['id']] = ImagesAdmin::getImage()->init($a);
		}
		return $Images;		
	}
	
	static function getItemImages($args=array())
	{				
		// get all the Images in the db
		$q = '	SELECT 	i.id AS image_id
						,i.filename
						,ii.id
						,ii.value
				FROM images i
				INNER JOIN stories s
				ON i.story_id = s.id
				INNER JOIN items_images ii
				ON i.id = ii.image_id
				WHERE 1 = 1 ';
				
		if (isset($args['image'])) $q .= 'AND i.id = :image_id'; 
		if (isset($args['item'])) $q .= 'AND ii.item_id = :item_id'; 
		
		$q .= ' ORDER BY i.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);						
		
		if (isset($args['image']))	 $q->param(':image_id',$args['image']->id);
		if (isset($args['item']))	 $q->param(':item_id',$args['item']->id);
						
		$tempArray = $q->execute()->as_array();		
		
		$Images = array();
		foreach($tempArray as $a)
		{
			$Images[$a['id']] = ImagesAdmin::getItemImage()->init($a);
		}
		return $Images;		
	}
	
	static function upload($args=array())
	{
		// increase timeout so we can resize images
		set_time_limit(120);
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
														'upload::size'=>array('3M')));
			//is our image file valid?
			if ($valid->Check())
			{
				// get original file name 
				$filename = $_FILES['filename']['name'];
					 
				// remove original extension and create alternate file type. JPG always seems to be smallest 
				//$filename = substr($filename,0,strpos($filename,'.')).'.png'; 
					
				//save filename to db & get image_id
				$results = ImagesAdmin::getImage(array('story_id'=>$_POST['story_id'],'filename'=>$filename))->save();
				
				//did we save to the db ok?
				if ($results->success)
				{
					//get image Id from results
					$image_id = $results->data['id'];
					
					// make a folders named story_id with a folder image_id inside it
					// final path will be: /media/story_id/image_id/WxH/filename
					$media_path = APPPATH.MEDIA_PATH.DIRECTORY_SEPARATOR.$_POST['story_id'].DIRECTORY_SEPARATOR;
					dir::prep_directory($media_path);
					$media_path = $media_path.$image_id.DIRECTORY_SEPARATOR;
					dir::prep_directory($media_path);
					
					// upload original file from form 
					$temp_file = upload::save($_FILES['filename'],$_FILES['filename']['name'],APPPATH.UPLOAD_PATH.DIRECTORY_SEPARATOR);																				
					
					// save default image 
					$dest = $media_path.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR;
					$success = self::saveImage($temp_file,DEFAULT_STORY_WIDTH,DEFAULT_STORY_HEIGHT,$media_path,$filename,0,$dest);
					// save thumbnail
					$success = self::saveImage($temp_file,THUMBNAIL_IMAGE_WIDTH,THUMBNAIL_IMAGE_HEIGHT,$media_path,$filename);
					  
																										
					// did we resize & save the file to the upload dir ok?
					if ($success)
					{
						// determine reduction percentage
						if (isset($args['itemimage']) && ($args['itemimage'] == true))
						{
							// if this is a item image
							// reduce image by a percentage determined by the default image size
							// so that it maintains the same relative size
							$ThisImage = Image::factory($temp_file);
							$width_reduction_percentage = ($ThisImage->width / DEFAULT_STORY_WIDTH);
							$height_reduction_percentage = ($ThisImage->height / DEFAULT_STORY_HEIGHT);							
						}
						else
						{
							$reduction_percentage = SCENE_IMAGE_REDUCTION_PERCENT * 0.01; 
						}
																							
						//get array of Supported screens and add in the thumbnail size 
						$SCREENS = Model_Screens::getScreens();													
						// for each supported screen create image and save 	
						foreach($SCREENS as $screen)
						{
							if (isset($args['itemimage']) && ($args['itemimage'] == true))
							{
								$success = self::saveItemImage($temp_file,$screen['w'],$screen['h'],$media_path,$filename,$width_reduction_percentage,$height_reduction_percentage);
							}
							else
							{
								$success = self::saveImage($temp_file,$screen['w'],$screen['h'],$media_path,$filename,$reduction_percentage);
							}
						}
					}
					
					$results = new pcpresult($success,'',array('filename'=>$filename,'path'=>UPLOAD_PATH.DIRECTORY_SEPARATOR,'image_id'=>$image_id));
				}
				else
				{			
					$results = new pcpresult(0,'File was not saved to db');
				}
			}
			else
			{			
				$results = new pcpresult(0,'',array('errors'=>$valid->errors()));
			}
		}
		else
		{			
			$results = new pcpresult(0,'No files and/or no story ID');
		}
		return $results;
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
		dir::prep_directory($dest);
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
	static function saveItemImage($temp_file,$screen_width,$screen_height,$media_path,$filename,$width_reduction_percentage=1,$height_reduction_percentage=1,$dest=NULL)
	{		
		if (!$dest)
		{	
			// create directory name from screen w and h
			$dest = $media_path.DIRECTORY_SEPARATOR.$screen_width.'x'.$screen_height.DIRECTORY_SEPARATOR;
		}
		//create directory to put image		
		dir::prep_directory($dest);
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
}
