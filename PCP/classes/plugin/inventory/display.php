<?php include('css.php') ?>
<?php include('inventory.css') ?>
<?php include('inventory.js.php') ?>
<script>
	// get objs
	var backlink = $('#back_link');
	var setcurritem = $('#setcurrentitem');
	var dropcurritem = $('#dropcurrentitem');	
	
	// get urls
	var setlink = setcurritem.attr('href');
	var droplink = dropcurritem.attr('href');
	
	// remove links - if they have javascript they don't need these
	backlink.attr('href','#');
	setcurritem.attr('href','#');
	dropcurritem.attr('href','#');
	
	// change functionality to be all 'ajaxy'
	backlink.click(function(){ tb_remove(); })
	setcurritem.click(function(){$.post(setlink, function(){ tb_remove(); }); });
	dropcurritem.click(function(){$.getJSON(droplink, function(events){ $().REFRESH_ITEMS(events[0].data);  tb_remove(); }); });
	
</script>
<div id="inventory" >
	<?php 		
		$inventory_items = plugin_inventory::getInventory();
		if (count($inventory_items)>0)
		{
			$session = Session::Instance();
			$story = $session->get('story');
		
			echo '<ul>';
			foreach ($inventory_items as $item_info)
			{
				$item = current($item_info);
				if (plugin_inventory::getCurrentItem() == $item['id']) {echo '<li class="active">';}
				else {echo '<li class="nonactive">';}
				$itemstate = Model_PCP_Items::getItemState($item['itemstate_id']);
				echo '<a id="setcurrentitem" href="'.Kohana::$base_url.'announceEvent?event='.INVENTORY_SET_SELECTED_ITEM.'&i='.$item['id'].'"><img src="'.$story->getMediaPath().$itemstate->getPath(THUMBNAIL_IMAGE_SIZE).'" alt="'.$itemstate->title.'" title="'.$itemstate->title.'" /></a></li>';
			}
			/*
			if ($story_data['current_item'] > 0)
			{
				echo '<li><a href="'.Kohana::$base_url.'plugin?plugin=plugin_inventory&f=setCurrentItem&i=0">Return Item To Inventory</li>';
			}*/
			echo '</ul>';
			if (plugin_inventory::getCurrentItem() > 0)
			{
				echo '<a id="dropcurrentitem" href="'.Kohana::$base_url.'announceEvent?event='.INVENTORY_DROP_SELECTED_ITEM.'" class="ui-widget ui-state-default ui-corner-all button delete">Drop Selected Item</a>';
			}
		}
		else
		{
			echo '<p>No items in inventory</p>';
		}
	?>
	<div style="clear:both;">
		<a id="back_link" href="<?php echo Kohana::$base_url ?>scene" class="ui-widget ui-state-default ui-corner-all button save">Back</a>
	</div>
</div>
