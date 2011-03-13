<?php include('css.php') ?>
<?php include('inventory.css') ?>
<?php include('inventory.js.php') ?>
<script>
	$('#scene_link').attr('href','#'); // if they have javascript they don't need this link
	$('#scene_link').click(function(){ tb_remove(); })
</script>
<div id="inventory" >
	<?php 
		$session = Session::instance();			
		$story = $session->get('story',null);	
		$story_data = $session->get('story_data',array());
		if (isset($story_data['item_locations']['inventory']))
		{
			$inventory_items = $story_data['item_locations']['inventory'];
			
			echo '<ul>';
			foreach ($inventory_items as $item_info)
			{
				$item = Model_PCP_Items::getItemState($item_info['itemstate_id']);
				echo '<li><a href="'.Kohana::$base_url.'plugin?plugin=plugin_inventory&f=setCurrentItem&i='.$item->itemdef_id.'"><img src="'.$story->getMediaPath().$item->getPath($story->screen_size).'" alt="'.$item->title.'" title="'.$item->title.'" /></a></li>';
			}
			if ($story_data['current_item'] > 0)
			{
				echo '<li><a href="'.Kohana::$base_url.'plugin?plugin=plugin_inventory&f=setCurrentItem&i=0">Return Item To Inventory</li>';
			}
			echo '</ul>';
		}
		else
		{
			echo '<p>No items in inventory</p>';
		}
	?>
	<div style="clear:both;">
		<a id="scene_link" href="<?php echo Kohana::$base_url ?>scene" class="ui-widget ui-state-default ui-corner-all button save">Back</a>
	</div>
</div>
