<?php
/*
 	Interface for PointClickPress Plugins
 */
interface Interface_iPCPPlugin extends Interface_iPCPAutoListener
{
	public function install(); // run when new plugin is detected
	public function uninstall(); // run when 'uninstall' is selected from admin
}

?>
