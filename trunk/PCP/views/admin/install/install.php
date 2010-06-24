<?php 

	$q = file_get_contents('PCP.sql'); 
	DB::query(NULL,$q,FALSE)

?>
