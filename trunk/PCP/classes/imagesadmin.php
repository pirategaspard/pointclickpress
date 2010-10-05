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
					
					//create directory for default image
					$dest = $media_path.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR;
					dir::prep_directory($dest);
					//create default image and save it			
					$success = Image::factory($temp_file)
												->resize(DEFAULT_STORY_WIDTH, DEFAULT_STORY_HEIGHT, Image::WIDTH)
												->save($dest.$filename);		
															
					// did we resize & save the file to the upload dir ok?
					if ($success)
					{
						$orig_image = $dest.$filename;
																					
						//get array of Supported screens and add in the thumbnail size 
						$SCREENS = Model_Screens::getScreens();
						$temp = explode('x',THUMBNAIL_IMAGE_SIZE);
						$SCREENS[] = array('w'=>$temp[0],'h'=>$temp[1]); 						
								
						// for each supported screen create image and save 	
						foreach($SCREENS as $screen)
						{
							$dest = $media_path.DIRECTORY_SEPARATOR.$screen['w'].'x'.$screen['h'].DIRECTORY_SEPARATOR;
							//create directory to put image
							dir::prep_directory($dest);
							
							$success = Image::factory($temp_file)
							->resize($screen['w'], $screen['h'],Image::NONE)
							->save($dest.$filename,IMAGE_QUALITY);
							
							//Images::resize_png($orig_image,$dest.$filename,$screen['w'],$screen['h']);
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
