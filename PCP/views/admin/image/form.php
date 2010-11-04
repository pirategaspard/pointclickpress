<?php 
	//var_dump($_REQUEST);
	//var_dump($image);
	if (isset($image))
	{
?>
<script language="JavaScript" type="text/javascript">
<!--
	$().ready(function() 
	{
		$("form.thickbox").submit(function() 
		{
			var t = this.title || this.name || null;
			var g = null;
			// show the ThickBox
			tb_show(t, this.action, null);
			return true;
		});
	});
// -->
</script>
<a href="<?php echo($back_url); ?>" >Back</a>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all" >
	<legend>image <?php echo($image->id); ?></legend>
	<form action="<?php echo($image_form_action); ?>?keepThis=true&TB_iframe=true" method="post" enctype="multipart/form-data" class="thickbox" >
		<input type="hidden" name="story_id" value="<?php echo($image->story_id); ?>" >
		<input type="hidden" name="type_id" value="<?php echo($image->type_id); ?>" >
		<?php if(isset($scene_id) && strlen($scene_id) > 0) { ?><input type="hidden" name="scene_id" value="<?php echo($scene_id); ?>"> <?php } ?>
		<?php if(isset($itemstate_id) && strlen($itemstate_id) > 0) { ?><input type="hidden" name="itemstate_id" value="<?php echo($itemstate_id); ?>"><?php } ?>
		<input type="hidden" name="id" value="<?php echo($image->id); ?>" >
		<?php if (strlen($image->filename) > 0) { ?>
			filename:  <input type="text" name="filename" value="<?php echo($image->filename); ?>" readonly="readonly" >
			<img src="<?php echo(Kohana::$base_url.MEDIA_PATH.'/'.$image->story_id.'/'.$image->id.'/'.THUMBNAIL_IMAGE_SIZE.'/'.$image->filename); ?>" >
			<input type="submit" name="submit" value="Delete" class="ui-widget ui-state-default ui-corner-all button delete" >
		<?php } else { ?>
			filename: <input type="file" name="filename" >
			<input type="submit" name="submit" value="Upload" class="ui-widget ui-state-default ui-corner-all button save" >
		<?php } ?>				
	</form>
</fieldset>
<?php 
	} 	
?>
