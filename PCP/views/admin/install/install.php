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
		$results = Model_Admin_UsersAdmin::create($user_data);
		
		// Done!
		echo '<h3>Done!</h3>';
		echo '<a href="'.Kohana::$base_url.'admin/" >Log in</a>';
	}
	else
	{
?>
<style>
	#install {width-max: 600px;}
	#welcome {text-align: center}
</style>
<div id="install">
	<h1 id="welcome">Welcome To The PointClickPress Installer!</h1>
	
	<fieldset class="ui-helper-reset ui-widget-content ui-corner-all login" >
		<h3>Please Create An Admin User:</h3>	
		<form method="post">		
			Username: <input type="text" name="username" value="" />
			Passsword: <input type="password" name="password" value="" />
			<input type="submit" name="install" value="install" class="ui-widget ui-state-default ui-corner-all button login"  />
		</form>
	</fieldset>
<div>

<?php } ?>
