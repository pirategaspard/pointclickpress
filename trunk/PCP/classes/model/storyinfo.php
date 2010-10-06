<?php defined('SYSPATH') or die('No direct script access.');

class Model_StoryInfo extends Model_Story 
{
	protected $scene_width = DEFAULT_STORY_WIDTH;
	protected $scene_height = DEFAULT_STORY_HEIGHT;
	protected $cell_width = 0;	
	protected $cell_height = 0;
	
	public function __construct($args=array())
	{
		parent::__construct($args);			
	}
	
	// set the story screen size
	function setDimensions($orig_width=DEFAULT_STORY_WIDTH,$orig_height=DEFAULT_STORY_HEIGHT)
	{
		$screens = Model_Screens::getScreens();
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
		
		$this->cell_width = intval($this->scene_width / $this->grid_x);
		$this->cell_height = intval($this->scene_height / $this->grid_y);
	}
	
	function grid_total()
	{
		return $this->grid_x * $this->grid_y;
	}

}

?>
