
<?php 
	if (isset($users))
	{
?>
	<fieldset class="ui-helper-reset ui-widget-content ui-corner-all" >		
		<legend>Users</legend>
		<?php if (isset($user_add)) echo('<span class="add">'.$user_add.'</span>'); ?>
		<table>
			<tr>
				<th>Title</th>
				<th></th>
				<th></th>
			</tr>
			<?php foreach($users as $user) { ?>
			<tr>
				<td><h4><?php echo($user->username); ?></h4></td>
				<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'users','action'=>'edit'))).'?user_id='.$user->id); ?>" class="ui-widget ui-state-default ui-corner-all button" >Edit</a></td>
				<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'users','action'=>'delete'))).'?user_id='.$user->id); ?>" class="ui-widget ui-state-default ui-corner-all button delete" >Delete</a></td>
			</tr>
			<?php } ?>
		</table>
	</fieldset>
<?php } ?>
