			<div id="search" class="portfolio-search">
				<div class="container">
					<div class="row">
						<div class="col-md-7">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle language" data-toggle="dropdown">
									Language <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu" data-type="language">
									<li><a href="<?= base_url('portfolio/search/0/12/javascript') ?>" data-value="javascript">Javascript</a></li>
									<li><a href="<?= base_url('portfolio/search/0/12/python') ?>" data-value="python">Python</a></li>
									<li><a href="<?= base_url('portfolio/search/0/12/php') ?>" data-value="php">PHP</a></li>
									<li><a href="<?= base_url('portfolio/search/0/12/sql') ?>" data-value="mysql">MySQL</a></li>
									<li><a href="<?= base_url('portfolio/search/0/12/c') ?>" data-value="c">C</a></li>
									<li><a href="<?= base_url('portfolio/search/0/12/c'.urldecode('++')) ?>" data-value="c++">C++</a></li>
									<li><a href="<?= base_url('portfolio/search/0/12/nodejs') ?>" data-value="nodejs">Nodejs</a></li>
									<li><a href="<?= base_url('portfolio/search/0/12/html5') ?>" data-value="html5">HTML5</a></li>
									<li><a href="<?= base_url('portfolio/search/0/12/') ?>" data-value="all">Language</a></li>
								</ul>
							</div>
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle company" data-toggle="dropdown">
									Company <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu" data-type="company">
									<li><a href="<?= base_url('portfolio/search/0/12/shippingsoon') ?>" data-value="shippingsoon">Shippingsoon</a></li>
									<li><a href="<?= base_url('portfolio/search/0/12/vaden') ?>" data-value="vaden">Vaden</a></li>
									<li><a href="<?= base_url('portfolio/search/0/12/carcarepeople') ?>" data-value="carcarepeople">Carcarepeople</a></li>
									<li><a href="<?= base_url('portfolio/search/0/12/') ?>" data-value="all">Company</a></li>
								</ul>
							</div>
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle year" data-toggle="dropdown">
									Year <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu" data-type="year">
									<?php for ($i = 0; $i < 8; $i++): ?>
									<li>
										<a href="<?= base_url('portfolio/search/0/12/'.date('Y', strtotime("-$i year"))) ?>" data-value="<?= date('Y', strtotime("-$i year")) ?>"><?= date('Y', strtotime("-$i year")) ?></a>
									</li>
									<?php endfor ?>
									<li><a href="<?= base_url('portfolio/search/0/12/') ?>" data-value="all">Year</a></li>
								</ul>
							</div>
						</div> <!-- /.col-md-7  -->
						<div class="col-md-4 col-md-offset-1">
							<form class="pull-right" action="<?= base_url("project/search/$offset") ?>" method="post">
								<input type="hidden" id="offset" value="<?= $offset ?>"/>
								<input type="hidden" id="limit" value="<?= $limit ?>"/>
								<input type="hidden" id="auto_complete" value="<?= $auto_complete ?>"/>
								<div class="search-box">
									<input type="text" class="search-query form-control transition" value="<?= $search_tags ?>" data-onpopstate="0" data-enabled="1">
									<span class="glyphicon glyphicon-search"></span>
								</div>
							</form>
						</div> <!-- /.col-md-5  -->
					</div> <!-- /.row -->
				</div> <!-- container -->
			</div> <!-- /.portfolio-search -->
