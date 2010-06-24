<?php 
/* 
	This whole file is temporary. 
	We should move this inside Kohana and use the DB class as it is meant to be used
*/


	if (isset($_POST['install']))
	{
		define('SYSPATH',''); // trick Kohana so that we can load the database config directly
		$db_config = require '../config/database.php';
		$db = $db_config['default']['connection'];
						
		// connect to db and set up db
		$link = mysql_connect($db['hostname'], $db['username'], $db['password']);
		mysql_select_db($db['database'], $link);
		
		$files = scandir('sql');
		foreach($files as $file)
		{
			if ((pathinfo('sql/'.$file, PATHINFO_EXTENSION) == 'sql'))
			{
				$f = file_get_contents('sql/'.$file); // get the SQL to run
				$results = mysql_query($f,$link);
			}
		}
		$code = mysql_error();
		$code2 = mysql_affected_rows();
		print("<p >$text <br /> Error: $code and $code2</p>");
		
		// Done!
		echo '<h3>Done!</h3>';
		echo '<a href="../">Log in</a>';
	}
	else
	{
?>


<h1>Welcome To The PointClickPress Installer</h1>

<form method="post">
	<input type="submit" name="install" value="install" />
</form>

<?php } ?>
