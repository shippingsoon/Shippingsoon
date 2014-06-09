			<div class="recent-articles wrapper">
				<div class="container">
					<h2>Recent Articles</h2><br/>
					<div class="row">
						<?php foreach ($articles AS $index => $article): ?>
						<div class="col-md-3">
							<article class="<?= $colors[$index] ?>">
								<header>
									<img src="<?= base_url("uploads/articles/img/{$article['article_id']}/0.jpg") ?>" class="img-responsive2"  alt=""/>
								</header>
								<a href="<?= base_url(strtolower("blog/{$article['category']}/{$article['slug']}/{$article['article_id']}")) ?>" class="read-more transition" title="Read more about <?= $article['title'] ?>">
									<i class="fa transition fa-mail-forward fa-1x"></i>
								</a>
								<time class="opensans transition" datetime="<?= $article['date_created'] ?>"><?= date('M<\b\r/>d/y', strtotime($article['date_created'])) ?></time>
								<h4 class="opensans title">
									<a class="transition" href="<?= base_url(strtolower("blog/{$article['category']}/{$article['slug']}/{$article['article_id']}")) ?>" title="Read more about <?= $article['title'] ?>">
										<?= $article['title'] ?>
									</a>
								</h4>
								<p class="opensans">
									<?= $article['description'] ?>
								</p>
							</article>
						</div> <!-- /.col-md-3 -->
						<?php endforeach ?>
					</div> <!-- /.row -->
				</div> <!-- /.container -->
			</div> <!-- /.recent-articles .wrapper -->
