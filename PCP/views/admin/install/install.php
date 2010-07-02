<?php 
/* 
	Install Script using Kohana framework
*/
	if (isset($_POST['install']))
	{
		include("sql/install.php");		
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
