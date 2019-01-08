<?php 
	$session = Session::Instance('admin');
	$locations = Model_Admin_LocationsAdmin::getLocations(array('story_id'=>$session->get('story_id')));
?>
<label id="location_select" for="location_select">Scene location:
<select name="location_select" >
	<option >Select a Scene location</option>
	<?php foreach($locations as $location)
	{
		$selected = '';
		/*if ($action->action_value == $location->id) $selected = ' selected="selected" ';*/
		echo ('<option value="'.$location->id.'"'.$selected.' >'.$location->title.'</option>');
	} ?>
</select>
</label>

