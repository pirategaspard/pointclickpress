<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" dir="ltr" lang="en-US">
<head>
   <title><?php echo $title ?></title>
   <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
   <?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), "\n" ?>
   <?php foreach ($scripts as $file) echo HTML::script($file), "\n" ?>
   <link rel="shortcut icon" href="<?php echo Kohana::$base_url ?>/favicon.ico" type="image/x-icon" />
</head>
<body>
   <div id="container">
      <div id="header">				
		<?php echo $header; ?>
	</div>
      <div id="navigation">
         <ul class="menu">

             <?php
             /*$session = Session::instance('admin');

             if (Auth::instance()->logged_in()){
				 if(Auth::instance()->logged_in('admin')) { 
					echo '<li>'.Html::anchor('admin/user', 'User admin').'</li>';
				}
                echo '<li>'.Html::anchor('user/profile', 'My profile').'</li>';
                echo '<li>'.Html::anchor('user/logout', 'Log out').'</li>';
             } else {
                echo '<li>'.Html::anchor('user/register', 'Register').'</li>';
                echo '<li>'.Html::anchor('user/login', 'Log in').'</li>';
             }*/
             echo '<li>'.Html::anchor('/', 'Story List').'</li>';
           ?>
         </ul>
      </div>
   <div id="content">
    <?php
     // output messages
     if(Message::count() > 0) {
       echo '<div class="ui-helper-reset ui-widget-content ui-corner-all">';
       echo '<div class="content" style="padding: 10px 15px;">';
       echo Message::output();
       echo '</div></div>';
     }
     echo $content ?>
   </div>
</div>
   <div id="footer"><?php echo $footer; ?></div>
<?php 
// echo '<div id="kohana-profiler">'.View::factory('profiler/stats').'</div>';
?>
</body>
</html>
