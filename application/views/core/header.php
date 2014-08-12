<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
		<meta name="description" content="<?= $meta_description ?>"/>
		<meta name="keywords" content="<?= $meta_keywords ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="robots" content="index, follow"/>
		<base href="<?= base_url() ?>"/>
		<title><?= $title ?></title>
		<link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>"/>
		<?= css_asset('bootstrap/bootstrap.min.css') ?>
		<?= css_asset('font-awesome/font-awesome.min.css') ?>
<?php if ($controller === 'admin' OR $method === 'search'): ?>
		<?= css_asset('jquery-ui/jquery-ui.min.css') ?>
		<?= css_asset('jquery-ui/jquery-ui-timepicker-addon.min.css') ?>
		<?= css_asset('tagit/jquery.tagit.min.css') ?>
<?php endif ?>
		<?= css_asset('fancybox/jquery.fancybox.min.css') ?>
<?php 
/*
		
*/ ?>
<?php if ($controller === 'blog' OR $controller === 'portfolio'): ?>
		<?= css_asset('prettify/sons-of-obsidian.min.css') ?>
<?php endif ?>
		<?= css_asset('core.css?t='.time()) ?>
<?php if ($controller === 'admin'): ?>
		<?= css_asset('admin.css?t='.time()) ?>
<?php endif ?>
<?php if ($controller === 'about' AND $method === 'credits'): ?>
		<?= css_asset('about/about.min.css?t='.time()) ?>
<?php endif ?>
<?php foreach ($css_files AS $file): ?>
		<link href="<?= $file ?>" rel="stylesheet" type="text/css" />
<?php endforeach ?>
		<?= js_asset('jquery/jquery-1.11.0.min.js') ?>
		<?= js_asset('placeholder/jquery.placeholder.min.js') ?>
		<?= js_asset('bootstrap/bootstrap.min.js') ?>
		<?= js_asset('fancybox/jquery.fancybox.min.js') ?>
		<?= js_asset('prefixfree/prefixfree.min.js') ?>
<?php if ($controller === 'admin' OR $method === 'search'): ?>
		<?= js_asset('jquery/jquery-migrate-1.2.1.min.js') ?>
		<?= js_asset('jquery-ui/jquery-ui-1.10.4.custom.min.js') ?>
		<?= js_asset('jquery-ui/jquery-ui-timepicker-addon.min.js') ?>
		<?= js_asset('tagit/tag-it.min.js') ?>
<?php endif ?>
		<?= js_asset('waypoints/waypoints.min.js') ?>
		<?= js_asset('waypoints/waypoints-sticky.min.js') ?>
<?php if ($controller === 'blog' OR $controller === 'portfolio'): ?>
		<?= js_asset('tagcloud/jquery.tagcloud.min.js') ?>
		<?= js_asset('prettify/prettify.js') ?>
<?php endif ?>
<?php if ($controller === 'user'): ?>
		<?= js_asset('terminal/jquery.terminal.min.js') ?>
<?php endif ?>
		<?= js_asset('core.js?t='.time()) ?>
<?php if ($logged_in): ?>
		<?= js_asset('admin.js?t='.time()) ?>
<?php endif ?>
<?php foreach ($js_files AS $file): ?>
		<script type="text/javascript" src="<?= $file ?>"></script>
<?php endforeach ?>
<?php if ($controller !== 'admin' OR $controller !== 'user'): ?>
		<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-51293105-1', 'shippingsoon.com');
		ga('send', 'pageview');
		</script>
<?php endif ?>
		<!--[if lt IE 9]>
			<?= js_asset('html5shiv/html5shiv.min.js') ?>
			<?= js_asset('respond/respond.min.js') ?>
		<![endif]-->
	</head>
	<body class="<?= "$controller $method" ?> no-transitions">
