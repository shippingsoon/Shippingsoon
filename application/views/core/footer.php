			<div id="push"></div>
		</div> <!-- /#wrap -->
		<footer class="core-footer">
			<div class="core-footer-top">
				<div class="container">
					<div class="row">
						<div class="col-md-3">
							<div class="well">
								<h1 class="opensans light-weight">
									<span class="glyphicon glyphicon-send"></span>
									<a href="<?= base_url() ?>" title="Shippingsoon"><?= COMPANY ?></a>
								</h1>
								<p class="slogan"><?= SLOGAN ?></p>
							</div>
						</div> <!-- /.col-md-3 -->
						<div class="col-md-3">
							<h4>
								<span class="glyphicon glyphicon-fire"></span>
								<a href="<?= base_url('blog') ?>" title="Recent Articles">Recent Articles</a>
							</h4>
<?php if ($articles): ?>
							<ul class="list-unstyled">
<?php foreach ($articles AS $article): ?>
								<li>
									<a class="transition" href="<?= base_url(strtolower("blog/{$article['category']}/{$article['slug']}/{$article['article_id']}")) ?>" title="Read more about <?= $article['title'] ?>">
										<?= $article['title'] ?>
									</a>
								</li>
<?php endforeach ?>
							</ul>
<?php endif ?>
						</div> <!-- /.col-md-3 -->
						<div class="col-md-3">
							<h4>
								<span class="glyphicon glyphicon-user"></span>
								<a href="<?= base_url('what-does-shipping-soon-mean') ?>" title="Information">Information</a>
							</h4>
							<ul class="list-unstyled">
								<li>
									<span class="glyphicon glyphicon-envelope"></span>
									<a href="mailto:info@shippingsoon.com">info@shippingsoon.com</a>
								</li>
<?php /*
								<li>
									<span class="glyphicon glyphicon-earphone"></span>
									<a href="tel:912.000.000">912.000.000</a>
								</li>
*/ ?>
								<li>
									<span class="glyphicon glyphicon-globe"></span>
									Savannah, GA
								</li>
								<li>
									<i class="fa fa-skype fa-1x"></i>
									shipping.soon
								</li>
							</ul>
						</div> <!-- /.col-md-3 -->
						<div class="col-md-3">
							<h4>
								<span class="glyphicon glyphicon-thumbs-up"></span>
								<a href="<?= base_url('contact') ?>" title="Connect With Us">Connect With Us</a>
							</h4>
							<ul class="list-unstyled core-social">
								<li>
									<a href="https://github.com/shippingsoon" target="_blank" title="@github">
										<i class="fa fa-github-square fa-2x"></i>
									</a>
									<a href="https://www.linkedin.com/company/shipping-soon" target="_blank" title="@linkedin">
										<i class="fa fa-linkedin-square fa-2x"></i>
									</a>
								</li>
								<li>
									<a href="https://www.youtube.com/user/shippingsoon" target="_blank" title="@youtube">
										<i class="fa fa-youtube-square fa-2x"></i>
									</a>
									<a href="https://stackoverflow.com/users/3426978/shippingsoon" target="_blank" title="@stackoverflow">
										<i class="fa fa-stack-overflow fa-2x"></i>
									</a>
								</li>
							</ul>
						</div> <!-- /.col-md-3 -->
					</div>
				</div>
			</div> <!-- /.core-footer-top -->
			<div class="core-footer-bottom">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<ul class="list-inline pull-left">
								<li>&copy; <?= date('Y') ?></li>
								<li>
									<span class="glyphicon glyphicon-send"></span>
									<a href="<?= base_url() ?>" title="<?= COMPANY ?>"><?= COMPANY ?></a>
								</li>
								<li>All Rights Reserved</li>
							</ul>
							<ul class="list-inline pull-right">
								<li>
									<a href="https://github.com/shippingsoon/Shippingsoon" target="_blank" title="View <?= COMPANY ?>'s source code">
										We <span class="glyphicon glyphicon-heart"></span>  open source software
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div> <!-- /.core-footer-bottom -->
		</footer>
		<input type="hidden" id="statistic_id" value="<?= $statistic_id ?>"/>
		<noscript>
			<div class="navbar-fixed-top noscript">
				<a href="https://support.google.com/adsense/answer/12654" title="Enable Javascript">Please Enable Javascript</a>
			</div>
		</noscript>
		<?= js_asset('jquery/jquery-1.11.0.min.js') ?>
		<?= js_asset('bootstrap/bootstrap.min.js') ?>
		<?= js_asset('fancybox/jquery.fancybox.js') ?>
		<?= js_asset('prefixfree/prefixfree.min.js') ?>
<?php if ($controller == 'admin' OR $method == 'search'): ?>
		<?= js_asset('jquery/jquery-migrate-1.2.1.js') ?>
		<?= js_asset('jquery-ui/jquery-ui-1.10.4.custom.js') ?>
		<?= js_asset('jquery-ui/jquery-ui-timepicker-addon.js') ?>
		<?= js_asset('tagit/tag-it.min.js') ?>
<?php endif ?>
		<?= js_asset('waypoints/waypoints.js') ?>
		<?= js_asset('waypoints/waypoints-sticky.js') ?>
<?php if ($controller == 'blog' OR $controller == 'portfolio'): ?>
		<?= js_asset('tagcloud/jquery.tagcloud.js') ?>
		<?= js_asset('prettify/prettify.js') ?>
<?php endif ?>
<?php if ($controller == 'user'): ?>
		<?= js_asset('terminal/jquery.terminal.js') ?>
<?php endif ?>
		<?= js_asset('core.js?t='.time()) ?>
<?php if ($logged_in): ?>
		<?= js_asset('admin.js?t='.time()) ?>
<?php endif ?>
<?php foreach ($js_files AS $file): ?>
		<script type="text/javascript" src="<?= $file ?>"></script>
<?php endforeach ?>
<?php if ($controller != 'admin' OR $controller != 'user'): ?>
		<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-51293105-1', 'shippingsoon.com');
		ga('send', 'pageview');
		</script>
<?php endif ?>
    </body>
</html>