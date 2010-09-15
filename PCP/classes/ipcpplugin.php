<?php
/*
 	Interface for PointClickPress Plugins
 */
interface ipcpplugin
{
	public function getClass();	
	public function getLabel();	
	public function getDescription();
	public function getHook();	
	public function execute(&$args=array());
}

?>
