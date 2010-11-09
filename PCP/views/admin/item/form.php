<?php 

	if (isset($item))
	{ 
?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
	<legend>Item</legend>
	<form action="<?php print($item_form_action); ?>?keepThis=true&TB_iframe=true" method="post" enctype="multipart/form-data" class="thickbox" >		
		<input type="hidden" name="back_url" value="<?php echo($back_url); ?>" />
		<input type="hidden" name="story_id" value="<?php echo($item->story_id); ?>" />
		<input type="hidden" name="id" value="<?php echo($item->id); ?>" />
		<label>Title:</label>
		<input type="text" name="title" value="<?php echo($item->title); ?>" >		
		slug: <?php echo($item->slug); ?>
		<input id="button_submit" type="submit" name="submit" value="submit" class="ui-widget ui-state-default ui-corner-all button save" />
	</form>
</fieldset>
<?php } ?>
