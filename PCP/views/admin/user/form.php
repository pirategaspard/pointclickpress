<a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'users','action'=>'list')))); ?>">Back to user list</a>
<?php if(isset($user)) { ?>
<fieldset>
	<legend>Interactive user Information</legend>
	<form action="<?php echo($user_form_action); ?>" method="post" >
		<input type="hidden" name="id" value="<?php echo($user->id); ?>" >
		<label>
			username
			<input type="text" name="username" value="<?php echo($user->username); ?>" >
		</label>
		<label>
			email		
			<input type="text" name="email" value="<?php echo($user->email); ?>" >
		</label>      
		<label>
			password		
			<input type="password" name="password" value="" >
		</label>  
		<label>
			password2
			<input type="password" name="password2" value="" >
		</label>
		<label>
			active		
			<input type="text" name="active" value="<?php echo($user->active); ?>" >
		</label>
		<input type="submit" name="submit" value="Save" />
	</form>
</fieldset>
<?php } ?>
