<?php 
	$session = Session::Instance('admin');
	$items = Items::getStoryGridItems(array('story_id'=>$session->get('story_id')));
?>
<label id="item_Select" for="location_select">Item:
<select name="item_Select" >
	<option >Select an action item</option>
	<?php foreach($items as $i=>$item)
	{
		$selected = '';
		//if ($item->id == $location->id) $selected = ' selected="selected" ';
		echo ('<option value="'.$i.'"'.$selected.' >'.$item.'</option>');
	} ?>
</select>
</label>
