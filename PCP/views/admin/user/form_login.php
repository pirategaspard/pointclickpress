<?php 
	//var_dump($_SESSION);
?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all login" >	
	<h3>Please Login</h3>
	<form method="post" action="<?php echo($login_form_action); ?>" >
		<div class="form_block" >
			Username: <input type="text" id="username" name="username" value="" >
		</div>
		<div class="form_block" >
			Password: <input type="password" id="password" name="password" value="" >
		</div>
		<input type="submit" name="submit" value="Log in" class="ui-widget ui-state-default ui-corner-all button login" />
	</form>
</fieldset>