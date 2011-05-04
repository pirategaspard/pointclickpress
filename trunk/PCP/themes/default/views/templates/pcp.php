<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="en-us" />
		<?php foreach ($styles as $style)	{ ?><link href="<?php echo(Kohana::$base_url.'css/'.$style); ?>" rel="stylesheet" type="text/css" ><?php } ?>
		<?php foreach ($theme_styles as $style)	{ ?><link href="<?php echo(Kohana::$base_url.$style); ?>" rel="stylesheet" type="text/css" ><?php } ?>
		<?php Events::announceEvent(CSS); ?>
		<?php foreach ($head as $h)	{ echo("\n".$h); } ?>
		<title><?php echo $title; ?></title>
		<?php Events::announceEvent(HEAD); ?>
	</head>
	<body>
		<div id="container">
			<div id="header"><?php echo $header; ?></div>
			<div id="topmenu"><?php echo $top_menu; ?></div>
			<div id="content"><?php echo $content; ?></div>
			<div id="bottommenu"><?php echo $bottom_menu; ?></div>
			<div id="footer"><?php echo $footer; ?></div>
		</div>		
		<?php foreach ($scripts as $script){ ?><script src="<?php echo(Kohana::$base_url.'js/'.$script); ?>" ></script><?php print("\n"); } ?>
		<?php foreach ($theme_scripts as $script){ ?><script src="<?php echo(Kohana::$base_url.$script); ?>" ></script><?php print("\n"); } ?>
		<?php Events::announceEvent(JS); ?>
</html>
