<div class="ui-helper-reset ui-widget-content ui-corner-all">
   <div class="submenu">
      <ul>
         <li><?php echo Html::anchor('user/profile_edit', __('Edit profile')); ?></li>
         <li><?php echo Html::anchor('user/unregister', __('Delete account')); ?></li>
      </ul>
      <br style="clear:both;">
   </div>
   <h1><?php echo __('User profile') ?></h1>
   <div class="content">
      <h2>Username</h2>
      <p><?php echo $user->username ?></p>
      <h2>Info:</h2>
      <p><?php echo $user->info ?></p>
      <br />
      <p>Last login was <?php echo date('F jS, Y', $user->last_login) ?>, at <?php echo date('h:i:s a', $user->last_login) ?>.</p>
   </div>
</div>

