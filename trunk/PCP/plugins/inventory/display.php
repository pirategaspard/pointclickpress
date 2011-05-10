<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php	 
			include(Kohana::find_file('plugins\inventory','css'));
			include(Kohana::find_file('plugins\inventory','inventory','css'));
			include(Kohana::find_file('plugins\inventory','inventory.js'));	
		?>

	</head>
	<body>
		<div id="inventory" >
			<?php 		
				$inventory_items = plugins_inventory::getInventory();
				if (count($inventory_items)>0)
				{
					$session = Session::Instance();
					$story = $session->get('story');
				
					echo '<ul>';
					foreach ($inventory_items as $item_info)
					{
						$item = current($item_info);
						if (plugins_inventory::getCurrentItem() == $item['id']) {echo '<li class="active">';}
						else {echo '<li class="nonactive">';}				
						$itemstate = Model_PCP_Items::getItemState(array('id'=>$item['itemstate_id']));
						echo '<a id="setcurrentitem" href="'.Kohana::$base_url.'announceEvent?event='.INVENTORY_SET_SELECTED_ITEM.'&i='.$item['id'].'"><img src="'.$story->getMediaPath().$itemstate->getPath(THUMBNAIL_IMAGE_SIZE).'" alt="'.$itemstate->title.'" title="'.$itemstate->title.'" /></a></li>';
					}
					/*
					if ($story_data['current_item'] > 0)
					{
						echo '<li><a href="'.Kohana::$base_url.'plugin?plugin=plugins_inventory&f=setCurrentItem&i=0">Return Item To Inventory</li>';
					}*/
					echo '</ul>';
					if (plugins_inventory::getCurrentItem() > 0)
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
		<script >
		
			// get objs
			var backlink = $('#back_link');
			var setcurritem = $('#setcurrentitem');
			var dropcurritem = $('#dropcurrentitem');
										
			// get urls
			var setlink = setcurritem.attr('href');
			var droplink = dropcurritem.attr('href');
			
			// remove links - if they have javascript they don't need these
			if (backlink) { backlink.attr('href','#'); } 
			setcurritem.attr('href','#');
			dropcurritem.attr('href','#');
			
			// change functionality to be all 'ajaxy'
			if (backlink) {  backlink.click(function(){  }) }
			setcurritem.click(function(){$.post(setlink, function(){ var p  = $('#setcurrentitem').parent()
																		p.toggleClass('active');
																		p.toggleClass('notactive');  }); 
												});  
			dropcurritem.click(function(){$.getJSON(droplink, function(events){ $().REFRESH_ITEMS(events[0].data);   }); });
			
		</script>
	</body>
</html>
