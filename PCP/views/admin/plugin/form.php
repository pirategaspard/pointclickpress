<?php 
	if ($plugin)
	{ 
?>	
	<form method="post" action="<?php echo($form_action); ?>">
		<input type="text" value="<?php echo $plugin->getLabel(); ?>" readonly="readonly" />
		<br />
		<textarea readonly="readonly"><?php echo $plugin->getDescription(); ?></textarea>
		Active: Y <input type="radio" name="active" value="yes" />
		N <input type="radio" name="active" value="no" />		
		<input type="submit" name="submit" value="submit" class="ui-widget ui-state-default ui-corner-all button save" />
	</form>
<?php } ?>
