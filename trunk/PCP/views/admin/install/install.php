<?php 
/* 
	Install Script using Kohana framework
*/
	if (isset($_POST['install']))
	{
		include("sql/install.php");		
		
		// create first user		
		$user_data['username'] = $_POST['username'];
		$user_data['password'] = $_POST['password'];
		$user_data['password2'] = $_POST['password'];
		$user_data['email'] = 'admin@localhost';
		$user_data['active'] = '1';
		$results = UsersAdmin::create($user_data);
		
		//var_dump($results); die();
		
		// Done!
		echo '<h3>Done!</h3>';
		echo '<a href="'.Kohana::$base_url.'" >Log in</a>';
	}
	else
	{
?>


<h1>Welcome To The PointClickPress Installer!</h1>

<form method="post">
	<h3>Create Admin User</h3>
	Username: <input type="text" name="username" value="" />
	Passsword: <input type="password" name="password" value="" />
	<input type="submit" name="install" value="install" />
</form>

<?php } ?>
