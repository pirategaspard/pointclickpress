<?php
	
	// load install script
	$sql_filename = 'pointclickpress.sql';
	$f = fopen($sql_filename,"r+");
	$sql_content = fread($f,filesize($sql_filename));

	/* 
		Split script on semicolons that are next to line breaks 
		Probably not fool-proof, but works for now. 
	*/	
	$a = preg_split('/([;]\n)|([;]\r)/',$sql_content);
	
	foreach ($a as $q)
	{
		$results = DB::Query(NULL,$q,FALSE)->execute();
	}
?>
