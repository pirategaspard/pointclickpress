<?php defined('SYSPATH') or die('No direct script access.');
class items extends model
{
	static function getCurrentGridItemState($griditem_id=0)
	{
		// get grid item obj from session
			// $griditem = getGridItem($griditem_id);
		// return current state
			// return $griditem->currentState(); 
	}
	
	static function setCurrentGridItemState($griditem_id=0,$value='')
	{
		// get grid item obj from session
			// $griditem = getGridItem($griditem_id);
		// set new state
			// $griditem->setValue($value);
	}
}
?>
