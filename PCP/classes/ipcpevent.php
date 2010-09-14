<?php
/*
 	Interface for PointClickPress Events
 */
interface ipcpevent 
{
	public function getEvent();	
	public function getLabel();	
	public function getDescription();	
	public function execute($args=array(),&$story_data=array());
}

?>
