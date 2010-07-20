<?php 
/* 
	Install Script using Kohana framework
*/
	if (isset($_POST['install']))
	{
		include("sql/install.php");		
		
		// create first user		
		$user_data['username'] = 'admin';
		$user_data['password'] = 'admin';
		$user_data['password2'] = 'admin';
		$user_data['email'] = 'admin@localhost';
		$user_data['active'] = '1';
		$results = UsersAdmin::create($user_data);
		
		
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
