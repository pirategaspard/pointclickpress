<?php defined('SYSPATH') or die('No direct script access.');

class Model_PCP_StoryInfo extends Model_Story 
{
	protected $scene_width = DEFAULT_SCREEN_WIDTH;
	protected $scene_height = DEFAULT_SCREEN_HEIGHT;
	protected $real_scene_width = DEFAULT_SCREEN_WIDTH;
	protected $real_scene_height = DEFAULT_SCREEN_HEIGHT;
	protected $screen_size = '0x0';
	protected $cell_width = 0;	
	protected $cell_height = 0;
	
	public function __construct($args=array())
	{
		
		parent::__construct($args);	
		$this->screen_size = DEFAULT_SCREEN_SIZE;		
	}
	
	// set the story screen size
	function setDimensions($orig_width=DEFAULT_SCREEN_WIDTH,$orig_height=DEFAULT_SCREEN_HEIGHT)
	{
		$screens = Model_PCP_Screens::getScreens();
		$width = $orig_width;
		$height = $orig_height;
		foreach($screens as $screen)
		{
			if (($orig_width >= $screen['w'])&&($orig_width >= $screen['h']))
			{				
				$width = $screen['w'];
				$height = $screen['h'];
			}
		}
		$this->scene_width = $width;
		$this->scene_height = $height;	
		$this->real_scene_width = $width - ($width * (SCENE_IMAGE_REDUCTION_PERCENT * 0.01));
		$this->real_scene_height = $height - ($height * (SCENE_IMAGE_REDUCTION_PERCENT * 0.01));
		$this->screen_size = $width.'x'.$height;
		
		$this->cell_width = intval($this->real_scene_width / $this->grid_x);
		$this->cell_height = intval($this->real_scene_height / $this->grid_y);
	}
	
	function grid_total()
	{
		return $this->grid_x * $this->grid_y;
	}

	function getMediaPath()
	{
		return Kohana::$base_url.MEDIA_PATH.'/'.trim($this->id).'/';
	}
	
	function initItems()
	{
		/* get all items used in this story, 
		   determine their starting state and location, 
		   and place that info into session */
		return Model_PCP_Items::getStoryItemInfo(array('story_id'=>$this->id));
	}
}

?>
