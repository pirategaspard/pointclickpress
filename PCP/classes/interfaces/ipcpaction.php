<?php
/*
 	Interface for PointClickPress actions
 */
interface interfaces_iPCPAction
{
	public function getClass();	
	public function getLabel();	
	public function getDescription();	
	public function execute($args=array(),&$story_data=array());
}

?>
