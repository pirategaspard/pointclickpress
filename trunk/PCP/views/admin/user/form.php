<a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'users','action'=>'list')))); ?>">Back to user list</a>
<?php if(isset($user)) { ?>
<fieldset>
	<legend>Admin User Information</legend>
	<form action="<?php echo($user_form_action); ?>" method="post" >
		<input type="hidden" name="id" value="<?php echo($user->id); ?>" >
		<label>
			Username
			<input type="text" name="username" value="<?php echo($user->username); ?>" >
		</label>
		<label>
			Email		
			<input type="text" name="email" value="<?php echo($user->email); ?>" >
		</label>      
		<label>
			Password		
			<input type="password" name="password" value="" >
		</label>  
		<label>
			Re-type Password
			<input type="password" name="password2" value="" >
		</label>
		<label>
			active
			<select name="active" >
				<option value="0" <?php if($user->active == 0){ echo('selected="selected"'); }?>>No</option>
				<option value="1" <?php if($user->active == 1){ echo('selected="selected"'); }?>>Yes</option>
			</select>	
		</label>
		<input type="submit" name="submit" value="Save" />
	</form>
</fieldset>
<?php } ?>
