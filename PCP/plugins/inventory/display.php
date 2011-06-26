<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php	 
			include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'inventory','css'));
			include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'inventory','inventory','css'));
		//	include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'inventory','inventory.js'));
		
		echo '<style>';
		if (plugins_inventory::getCurrentItem() > 0)
		{
			echo '#inventory #dropcurrentitem {display: block;}';		
		}
		else
		{
			echo '#inventory #dropcurrentitem {display: none;}';
		}
		echo '</style>';
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
					foreach ($inventory_items['griditems'] as $item)
					{						
						if (plugins_inventory::getCurrentItem() == $item['id']) {echo '<li class="active inventory_item">';}
						else {echo '<li class="inventory_item">';}				
						$itemstate = Model_Inventory::getInventoryItemStateByItemId(array('id'=>$item['itemstate_id']));
						echo '<a id="setcurrentitem" href="'.Kohana::$base_url.'announceEvent?event='.INVENTORY_SET_SELECTED_ITEM.'&i='.$item['id'].'"><img src="'.$story->getMediaPath().$itemstate->getPath(THUMBNAIL_IMAGE_SIZE).'" alt="'.$itemstate->description.'" title="'.$itemstate->description.'" /></a>';
						echo '</li>';
					}
					echo '</ul>';
					echo '<div style="clear:both;" >';
					echo '<br /><a id="dropcurrentitem" href="'.Kohana::$base_url.'announceEvent?event='.INVENTORY_DROP_SELECTED_ITEM.'" class="ui-widget ui-state-default ui-corner-all button delete">Drop Selected Item</a><br /><br />';
					echo '</div >';
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
			//var dropcurritem = $('#dropcurrentitem');
										
			// get urls			
			//var droplink = dropcurritem.attr('href');
			
			// remove links - if they have javascript they don't need these
			if (backlink) { backlink.attr('href','#'); } 			
			//dropcurritem.removeAttr('href');
			
			// change functionality to be all 'ajaxy'
			if (backlink) {  backlink.click(function(){ tb_remove(); }) }			  
			//dropcurritem.click(function(){$.getJSON(droplink, function(events){ $().REFRESH_ITEMS(events[0].data);   }); });
			
			// remove links on inv items
			var inv_items = $('.inventory_item>a');	
			inv_items.each(function(){
					var item = $(this);						
					var setlink = item.attr('href');
					item.attr('h',setlink);
					item.removeAttr('href');					
				});
			
			
			$('.inventory_item').click(function()
			{
				var item = $(this);
				if (item.hasClass('active'))
				{					
					item.removeClass('active');
					$('#dropcurrentitem').hide();	
					$.post("<?php echo Kohana::$base_url.'announceEvent?event='.INVENTORY_SET_SELECTED_ITEM.'&i=0'; ?>")			
				}
				else
				{
					var link = item.children('a').attr('h');
					$('.active').removeClass('active');
					item.addClass('active');
					$.post(link);
					$('#dropcurrentitem').show();
				}
			});
			
						
		</script>
	</body>
</html>

<?php /* 

<script src="/PCP/js/jquery-1.4.2.min.js" ></script>
		<script src="/PCP/js/jquery-ui-1.8.6.custom.min.js" ></script>

*/?>
