<?php 
/* 
	Install Script using Kohana framework
*/
	if (isset($_POST['install']))
	{
		// create first user
		$user_data = new Model_Auth_Users();		
		$user_data->username = 'admin';
		$user_data->password = 'admin';
		$user_data->email = 'abcd@localhost';
		$results = simpleauth::instance()->create_user($user_data);
		
		
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
