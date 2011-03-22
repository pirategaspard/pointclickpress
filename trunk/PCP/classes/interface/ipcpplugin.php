<?php
/*
 	Interface for PointClickPress Plugins
 */
interface Interface_iPCPPlugin
{
	public function getClass();	
	public function getLabel();	
	public function getDescription();
	public function getEvents();
	public function install();		
	public function execute($event_name='');
}

?>
