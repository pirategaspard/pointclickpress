<?php 
	//var_dump($_SESSION);
?>

<h3>Please Login</h3>
<form method="post" action="<?php echo($login_form_action); ?>" >
	Username: <input type="text" id="username" name="username" value="" >
	Password: <input type="password" id="password" name="password" value="" >
	<input type="submit" name="submit" value="Log in" />
</form>
