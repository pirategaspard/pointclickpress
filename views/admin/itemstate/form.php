<?php 

	if (isset($itemstate))
	{ 
?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
	<legend>Item State</legend>
	<form action="<?php print($itemstate_form_action); ?>?keepThis=true&TB_iframe=true" method="post" enctype="multipart/form-data" class="thickbox" >		
		<input type="hidden" name="back_url" value="<?php echo($back_url); ?>" />
		<input type="hidden" name="itemdef_id" value="<?php echo($itemdef_id); ?>" />
		<input type="hidden" name="id" value="<?php echo($itemstate->id); ?>" />
		<?php if(strlen($itemstate->filename) > 0) { ?>
			<img src="<?php print(Kohana::$base_url.MEDIA_PATH.'/'.$story_id.'/'.$itemstate->image_id.'/'.THUMBNAIL_IMAGE_SIZE.'/'.$itemstate->filename); ?>" >
		<?php } ?>
		<label>
			Value:
			<input type="text" name="value" value="<?php echo($itemstate->value); ?>" >
		</label>
		<p>
			<label>Description</label>
			<textarea name="description" cols="50"><?php print($itemstate->description); ?></textarea>
		</p>
		<label>Is Default Item State:</label>
		<select name="isdefaultstate" >
			<option value="0" <?php if(strcmp($itemstate->isdefaultstate,'0')===0) echo('selected="selected"'); ?>>No</option>
			<option value="1" <?php if(strcmp($itemstate->isdefaultstate,'1')===0) echo('selected="selected"'); ?>>Yes</option>
		</select>
		<?php if($itemstate->id > 0) { ?>
		<label>
			Image filename:
			<input type="hidden" name="image_id" value="<?php echo($itemstate->image_id); ?>" >
			<input type="text" name="filename" value="<?php echo($itemstate->filename); ?>" >
			<a href="<?php echo($itemstate_assign_image_link); ?>&KeepThis=true&TB_iframe=true" class="thickbox ui-widget ui-state-default ui-corner-all button" >Assign Image</a>
		</label>
		<?php } ?>
		<input id="button_submit" type="submit" name="submit" value="submit" class="ui-widget ui-state-default ui-corner-all button save" />
	</form>
</fieldset>
<?php } ?>
