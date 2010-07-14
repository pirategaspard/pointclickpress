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
			<input type="text" name="email" value="" >
		</label> 
		<label>
			admin		
			<input type="text" name="admin" value="<?php echo($user->admin); ?>" >
		</label> 
		<label>
			moderator		
			<input type="text" name="moderator" value="<?php echo($user->moderator); ?>" >
		</label> 
		<label>
			active		
			<input type="text" name="moderator" value="<?php echo($user->active); ?>" >
		</label>
		<input type="submit" name="submit" value="Save" />
	</form>
</fieldset>
<?php } ?>
