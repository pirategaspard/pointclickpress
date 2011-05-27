<h1>PointClickPress</h1>
<?php if(Auth::instance()->logged_in()) {  ?>
<ul class="menu">
	<li><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'story','action'=>'list')))); ?>">Authoring</a></li>
	<?php if(Auth::instance()->logged_in('admin')) {  ?>
		<li><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'list')))); ?>">Plugin Admin</a></li>
		<li><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'user','action'=>'list')))); ?>">User Admin</a></li>
	<?php } ?>
	<li><a href="<?php echo(Url::site(Route::get('user')->uri(array('controller'=>'user','action'=>'profile')))); ?>">My Profile</a></li>
	<li><a href="<?php echo(Url::site(Route::get('user')->uri(array('controller'=>'user','action'=>'logout')))); ?>">Logout</a></li>
</ul>
<?php } ?>
