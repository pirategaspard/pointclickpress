<?php
	 
	// load install script
	$sql_filename = APPPATH.'views/admin/install/sql/pointclickpress.sql';
	$f = fopen($sql_filename,"r");
	$sql_content = fread($f,filesize($sql_filename));

	/* 
		Split script on semicolons that are next to line breaks 
		Probably not fool-proof, but works for now. 
	*/	
	$a = preg_split('/([;]\n)|([;]\r)/',$sql_content);
	
	foreach ($a as $q)
	{
		if (strlen(trim($q)) > 0)
		{
			$results = DB::Query(NULL,$q,FALSE)->execute();
		}
	}
?>
