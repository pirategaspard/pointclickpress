<ul class="menu">
	<li><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'story','action'=>'list')))); ?>">Story Admin</a></li>
	<li><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'list')))); ?>">Plugin Admin</a></li>
	<li><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'users','action'=>'list')))); ?>">User Admin</a></li>
	<li><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'users','action'=>'logout')))); ?>">Logout</a></li>
</ul>