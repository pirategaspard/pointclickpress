<?php
/*
 	Interface for PointClickPress actiondefs
 */
interface Interface_iPCPActionDef extends Interface_iPCPAutoListener
{
	public function getAllowedActionTypes();	// returns list of allowed action types 
	public function performAction($args=array(),$hook_name=''); // called when action is executed
}

?>
