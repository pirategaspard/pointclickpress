<h1>PointClickPress</h1>
<ul class="menu">	
	<?php if(Auth::instance()->logged_in()) {  ?>
		<li><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'story','action'=>'list')))); ?>">Authoring</a></li>
		<li></li>
		<li><a href="<?php echo(Url::site(Route::get('user')->uri(array('controller'=>'user','action'=>'logout')))); ?>">Logout</a></li>
	<?php }else { ?>
	<li><a href="<?php echo(Url::site(Route::get('user')->uri(array('controller'=>'user','action'=>'login')))); ?>">Login</a></li>
	<?php } ?>
</ul>

