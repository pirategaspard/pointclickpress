<?php defined('SYSPATH') or die('No direct script access.');

class Model_StoryInfo extends Model_Story 
{
	protected $scene_width = 800;
	protected $scene_height = 600;
	protected $cell_width = 0;	
	protected $cell_height = "";
	
	public function __construct($args=array())
	{
		parent::__construct($args);			
	}
	
	function setDimensions($orig_width=800,$orig_height=600)
	{
		$screens = Screens::getScreens();
		$width = 800;
		$height = 600;
		foreach($screens as $screen)
		{
			if (($orig_width >= $screen['w']))
			{				
				$width = $screen['w'];
			}
			if (($orig_width >= $screen['h']))
			{
				$height = $screen['h'];
			}
		}
				
		$this->scene_width = $width;
		$this->scene_height = $height;
		$this->cell_width = round($this->scene_width / $this->grid_x);
		$this->cell_height = round($this->scene_height / $this->grid_y);
	}
	
	function grid_total()
	{
		return $this->grid_x * $this->grid_y;
	}

}

?>
