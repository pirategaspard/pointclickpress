<?php 
/* 
	Install Script using Kohana framework
*/
	if (isset($_POST['install']))
	{
		include("sql/install.php");		
		
		// create first user		
		$_POST['roles'] = 'login,admin';
		try 
		{
			Auth::instance()->register( $_POST, TRUE );
			Auth::instance()->login($_POST['username'], $_POST['password']);
		} 
		catch (ORM_Validation_Exception $e) 
		{
			$errors = $e->errors('register');
			$errors = array_merge($errors, (isset($errors['_external']) ? $errors['_external'] : array()));
			$_POST['password'] = $_POST['password_confirm'] = '';
		}
		
		// Done!
		echo '<h3>Done!</h3>';
		echo '<a href="'.Kohana::$base_url.'admin/" >Go To Admin</a>';
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
			Username: <input type="text" name="username" value="" /><br />
			Email Address: <input type="text" name="email" value="" /><br />
			Password: <input type="password" name="password" value="" /><br />
			Re-type Password: <input type="password" name="password_confirm" value="" /><br />
			<input type="submit" name="install" value="install" class="ui-widget ui-state-default ui-corner-all button login"  />
		</form>
	</fieldset>
<div>

<?php } ?>
