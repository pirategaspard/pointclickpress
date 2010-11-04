<a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'users','action'=>'edit'))).'?user_id=0'); ?>">Add User</a>
<?php 
	if (isset($users))
	{
?>
<?php if (isset($user_add)) echo($user_add); ?>
		<fieldset class="ui-helper-reset ui-widget-content ui-corner-all" >
			<legend>Users</legend>
			<table>
				<tr>
					<th>Id</th>
					<th>Title</th>
					<th></th>
					<th></th>
				</tr>
				<?php foreach($users as $user) { ?>
				<tr>
					<td><?php echo($user->id); ?></td>
					<td><?php echo($user->username); ?></td>
					<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'users','action'=>'edit'))).'?user_id='.$user->id); ?>" class="ui-widget ui-state-default ui-corner-all button" >Edit</a></td>
					<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'users','action'=>'delete'))).'?user_id='.$user->id); ?>" class="ui-widget ui-state-default ui-corner-all button delete" >Delete</a></td>
				</tr>
				<?php } ?>
			</table>
		</fieldset>
<?php } ?>
