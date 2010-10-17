<?php
/*
 	Interface for PointClickPress Plugins
 */
interface ipcpplugin
{
	public function getClass();	
	public function getLabel();	
	public function getDescription();
	public function getHooks();
public function install();		
	public function execute($hook_name='');
}

?>
