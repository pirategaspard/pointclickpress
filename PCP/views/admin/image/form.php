<?php 
	//var_dump($image);
	if (isset($image))
	{
?>
<fieldset>
	<legend>image <?php print($image->id); ?></legend>
	<form action="<?php print($image_form_action); ?>" method="post" >
		<input type="hidden" name="id" value="<?php print($image->id); ?>" >
		<?php if (strlen($image->filename) > 0) { ?>
			filename:  <input type="text" name="filename" value="<?php print($image->filename); ?>" readonly="readonly" >
		<?php } else { ?>
			filename: <input type="file" name="filename" >
			<input type="submit" name="submit" value="Upload" >
		<?php } ?>				
	</form>
</fieldset>
<?php 
	} 	
?>
