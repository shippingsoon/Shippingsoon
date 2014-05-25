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
		<?= css_asset('font-awesome/font-awesome.css') ?>
<?php if ($controller == 'admin' OR $method == 'search'): ?>
		<?= css_asset('jquery-ui/jquery-ui.css') ?>
		<?= css_asset('jquery-ui/jquery-ui-timepicker-addon.css') ?>
		<?= css_asset('tagit/jquery.tagit.css') ?>
<?php endif ?>
		<?= css_asset('fancybox/jquery.fancybox.css') ?>
<?php 
/*
		
*/ ?>
<?php if ($controller == 'blog' OR $controller == 'portfolio'): ?>
		<?= css_asset('prettify/sons-of-obsidian.css') ?>
<?php endif ?>
		<?= css_asset('core.css?t='.time()) ?>
<?php if ($controller == 'admin'): ?>
		<?= css_asset('admin.css?t='.time()) ?>
<?php endif ?>
<?php foreach ($css_files AS $file): ?>
		<link href="<?= $file ?>" rel="stylesheet" type="text/css" />
<?php endforeach ?>
		<!--[if lt IE 9]>
			<?= js_asset('html5shiv/html5shiv.js') ?>
		<![endif]-->
	</head>
	<body class="<?= "$controller $method" ?> no-transitions">
		<div id="wrap">
			<div class="navbar-core-top">
				<div class="container">
					<div class="row">
						<a href="<?= base_url('user/' . (($logged_in) ? 'logout' : 'login/admin')) ?>" title="<?= ($logged_in) ? 'Logout': 'Login' ?>">
							<i class="fa fa-user fa-1x"></i>
						</a>
						<a href="https://www.linkedin.com/company/shipping-soon" target="_blank" title="Oh hi!">
							<i class="fa fa-linkedin-square fa-1x"></i>
						</a>
						<a href="https://github.com/shippingsoon" target="_blank" title="You found me!">
							<i class="fa fa-github-alt fa-1x"></i>
						</a>
						<a href="https://stackoverflow.com/users/3426978/shippingsoon" target="_blank" title="@stackoverflow">
							<i class="fa fa-stack-overflow fa-1x"></i>
						</a>
					</div> <!-- /.row -->
				</div> <!-- /.container -->
			</div> <!-- /.navbar-core-top -->
			<nav class="container navbar-core">
				<div class="row opensans">
					<button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target="#navbar-core-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="collapse navbar-collapse pull-right inner" id="navbar-core-collapse">
						<ul class="list-inline">
							<li class="nav-core <?php if ($controller == 'core'): ?>active<?php endif ?>">
								<a href="<?= base_url() ?>" title="Home">
									<span>Home</span>
									<span class="glyphicon glyphicon-home"></span>
								</a>
							</li>
<?php if ($logged_in):?>
							<li class="nav-admin <?php if ($controller == 'admin'): ?>active<?php endif ?>">
								<a href="<?= base_url('admin') ?>" title="Admin">
									<span>Admin</span>
									<span class="glyphicon glyphicon-wrench"></span>
								</a>
							</li>
<?php endif ?>
							<li class="nav-portfolio <?php if ($controller == 'portfolio'): ?>active<?php endif ?>">
								<a href="<?= base_url('portfolio') ?>" title="Portfolio">
									<span>Portfolio</span>
									<span class="glyphicon glyphicon-file"></span>
								</a>
							</li>
							<li class="nav-blog <?php if ($controller == 'blog'): ?>active<?php endif ?>">
								<a href="<?= base_url('blog') ?>" title="Blog">
									<span>Blog</span>
									<span class="glyphicon glyphicon-book"></span>
								</a>
							</li>
							<li class="nav-about <?php if ($controller == 'about'): ?>active<?php endif ?>">
								<a href="<?= base_url('what-does-shipping-soon-mean') ?>" title="About Us">
									<span>About</span>
									<span class="glyphicon glyphicon-user"></span>
								</a>
							</li>
							<li class="nav-contact <?php if ($controller == 'contact'): ?>active<?php endif ?>">
								<a href="<?= base_url('contact') ?>" title="Contact Us">
									<span>Contact</span>
									<span class="glyphicon glyphicon-envelope"></span>
								</a>
							</li>
<?php if (!$is_mobile):?>
							<li class="nav-search">
								<form class="transition core-search" action="<?= base_url('portfolio/search/0/12/') ?>" method="post">
									<input type="text" class="transition" placeholder="Search for projects Ex: C++, PHP, SEO"/>
									<span class="glyphicon glyphicon-search"></span>
								</form>
							</li>
<?php endif ?>
						</ul> <!-- /.list-inline -->
					</div> <!-- /.collapse .navbar-collapse -->
					<h1 class="brand-core opensans">
						<span class="glyphicon glyphicon-send nav-<?= $controller ?> active"></span>
						<a href="<?= base_url('') ?>" title="Shippingsoon" class="opensans light-weight">
							<span>S</span><span>h</span><span>i</span><span>p</span><span>p</span><span>i</span><span>n</span><span>g</span>
							<span>S</span><span>o</span><span>o</span><span>n</span>
						</a>
					</h1> <!-- /.brand-core .opensans -->
				</div> <!-- /.row .opensans -->
			</nav> <!-- /.container .navbar-core -->
