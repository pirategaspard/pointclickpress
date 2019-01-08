<?php 
	//var_dump($item);
	if (isset($griditem))
	{ 
?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
	<legend>Grid Item</legend>
	<form action="<?php print($item_form_action); ?>" method="post" enctype="multipart/form-data" class="thickbox" >
			<input type="hidden" name="story_id" value="<?php echo($griditem->story_id); ?>" />
			<input type="hidden" name="scene_id" value="<?php echo($scene_id); ?>" />
			<input type="hidden" name="itemdef_id" value="<?php if($griditem->itemdef_id == 0 ) {echo($itemdef->id);} else {echo($griditem->itemdef_id);} ?>" />
			<input type="hidden" name="id" value="<?php echo($griditem->id); ?>" />
		<?php if($griditem->itemdef_id == 0 ) { ?>	
			<label>
				Item Type:
				<input type="text" name="itemdef_title" value="<?php if (strlen($griditem->itemdef_title) == 0) { echo($itemdef->title); } else {echo($griditem->itemdef_title);} ?>" readonly="readonly" />
				<a href="<?php echo($assign_itemdef_link); ?>&KeepThis=true&TB_iframe=true" class="thickbox ui-widget ui-state-default ui-corner-all button" >Select ItemType</a>
			</label>
		<?php } else { ?>
			<input type="hidden" name="itemdef_title" value="<?php if (strlen($griditem->itemdef_title) == 0) { echo($itemdef->title); } else {echo($griditem->itemdef_title);} ?>" readonly="readonly" />
			<label>
				Instance Title:
				<input type="text" name="title" value="<?php if (strlen($griditem->slug) == 0) { echo($itemdef->title); } else {echo($griditem->slug); }  ?>" />
			</label>
			<label id="cell_id" for="cell_id">Cell Id:
				<input type="text" name="cell_id" value="<?php echo($griditem->cell_id); ?>" />
			</label>
			<input id="button_submit" type="submit" name="submit" value="save" class="ui-widget ui-state-default ui-corner-all button save" />
		<?php } ?>
		<?php if($griditem->id > 0 ) { ?>
			<input type="button" name="cancel" value="cancel" scene_id="<?php echo($scene_id); ?>" class="ui-widget ui-state-default ui-corner-all button cancel button_cancel" />
		<?php } ?>
	</form>
</fieldset>
<?php } ?>
