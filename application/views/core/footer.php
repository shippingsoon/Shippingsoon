			<div id="push"></div>
		</div> <!-- /#wrap -->
		<footer class="core-footer">
			<div class="core-footer-top">
				<div class="container">
					<div class="row">
						<div class="col-md-3">
							<div class="well">
								<h1 class="opensans">
									<span class="glyphicon glyphicon-send"></span>
									<a href="<?= base_url() ?>" title="Shippingsoon">Shipping Soon</a>
								</h1>
								<p class="slogan"><?= SLOGAN ?></p>
							</div>
						</div> <!-- /.col-md-3 -->
						<div class="col-md-3">
							<h4>
								<span class="glyphicon glyphicon-fire"></span>
								<a href="<?= base_url('blog') ?>" title="Recent Articles">Recent Articles</a>
							</h4>
							<ul class="list-unstyled">
								<li><a href="<?= base_url('blog/development/how-to-seek-and-destroy-targets/1') ?>">How to seek and destroy targets</a></li>
								<li><a href="<?= base_url('blog/development/how-to-seek-and-destroy-targets/1') ?>">Lorem Ipsum semper</a></li>
								<li><a href="<?= base_url('blog/development/how-to-seek-and-destroy-targets/1') ?>">Gravida at eget metus</a></li>
								<li><a href="<?= base_url('blog/development/how-to-seek-and-destroy-targets/1') ?>">Nonumy eirmod tempor invidunt</a></li>
							</ul>
						</div> <!-- /.col-md-3 -->
						<div class="col-md-3">
							<h4>
								<span class="glyphicon glyphicon-user"></span>
								<a href="<?= base_url('about') ?>" title="Information">Information</a>
							</h4>
							<ul class="list-unstyled">
								<li>
									<span class="glyphicon glyphicon-envelope"></span>
									<a href="mailto:info@shippingsoon.com">info@shippingsoon.com</a>
								</li>
								<li>
									<span class="glyphicon glyphicon-earphone"></span>
									<a href="tel:912.000.000">912.000.000</a>
								</li>
								<li>
									<span class="glyphicon glyphicon-globe"></span>
									Savannah, GA
								</li>
								<li>
									<i class="fa fa-skype fa-1x"></i>
									Loremipsum
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
									<a href="https://github.com" target="_blank" title="@github">
										<i class="fa fa-github-square fa-2x"></i>
									</a>
									<a href="https://linkedin.com" target="_blank" title="@linkedin">
										<i class="fa fa-linkedin-square fa-2x"></i>
									</a>
								</li>
								<li>
									<a href="https://www.youtube.com" target="_blank" title="@youtube">
										<i class="fa fa-youtube-square fa-2x"></i>
									</a>
									<a href="https://plus.google.com" target="_blank" title="@google+">
										<i class="fa fa-google-plus-square fa-2x"></i>
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
									<a href="<?= base_url() ?>" title="Shipping Soon">Shipping Soon</a>
								</li>
								<li>All Rights Reserved</li>
							</ul>
							<ul class="list-inline pull-right">
								<li><a href="<?= base_url('blog/development/shippingsoon/1') ?>" title="Lorem Ipsum">We <span class="glyphicon glyphicon-heart"></span>  open source software</a></li>
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
<?php if ($controller == 'admin'): ?>
		<?= js_asset('jquery/jquery-migrate-1.2.1.js') ?>
		<?= js_asset('jquery-ui/jquery-ui.min.js') ?>
		<?= js_asset('jquery-ui/jquery.timepicker.min.js') ?>
<?php endif ?>
<?php /*
		<?= js_asset('tagcloud/jquery.tagcloud.js') ?>
		<?= js_asset('fancybox/jquery.fancybox.js') ?>
		<?= js_asset('easing/jquery.easing.1.3.js') ?>
		<?= js_asset('isotope/jquery.isotope.js') ?>
		<?= js_asset('holder/holder.js') ?>
*/ ?>
<?php if ($controller == 'admin'): ?>
		<?= js_asset('tagit/tag-it.js') ?>
<?php endif ?>
		<?= js_asset('waypoints/waypoints.js') ?>
		<?= js_asset('waypoints/waypoints-sticky.js') ?>
<?php if ($controller == 'blog' OR $controller == 'portfolio'): ?>
		<?= js_asset('syntaxhighlighter/shCore.js', NULL, TRUE) ?>
		<?= js_asset('syntaxhighlighter/shAutoloader.js', NULL, TRUE) ?>
<?php endif ?>
<?php if ($controller == 'blog' AND $method == 'development'): ?>
		<?= js_asset('path.js') ?>
<?php endif ?>
<?php if ($controller == 'user'): ?>
		<?= js_asset('terminal/jquery.terminal.js') ?>
<?php endif ?>
		<?= js_asset('core.js') ?>
<?php if ($logged_in): ?>
		<?= js_asset('admin.js') ?>
<?php endif ?>
    </body>
</html>