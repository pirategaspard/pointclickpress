<?php 
/* 
	Install Script using Kohana framework
*/
	if (isset($_POST['install']))
	{
		$files = scandir(dirname(__FILE__).'/sql');
		foreach($files as $file)
		{
			if ((pathinfo(dirname(__FILE__).'/sql/'.$file, PATHINFO_EXTENSION) == 'sql'))
			{
				$f = file_get_contents(dirname(__FILE__).'/sql/'.$file); // get the SQL to run
				$results = DB::Query(NULL,$f,FALSE)->execute();
				/*
				var_dump($results);
				echo("<br /><br />");
				*/
			}
		}
		
		// Done!
		echo '<h3>Done!</h3>';
		echo '<a href="'.Kohana::$base_url.'" >Log in</a>';
	}
	else
	{
?>


<h1>Welcome To The PointClickPress Installer!</h1>

<form method="post">
	<input type="submit" name="install" value="install" />
</form>

<?php } ?>
