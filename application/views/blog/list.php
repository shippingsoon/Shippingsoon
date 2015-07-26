			<?php foreach ($articles AS $key => $article): ?>
				<article class="list clear">
					<div class="pull-left">
						<time class="pull-left" datetime="<?= $article['date_created'] ?>">
							<?= date('<\b>M</\b> <\b\r/>d/y', strtotime($article['date_created'])) ?>
						</time>
					</div> <!-- /.pull-left -->
					<div class="pull-right">
						<h3 class="opensans light-weight">
							<a href="<?= base_url(strtolower("blog/{$article['category']}/{$article['slug']}/{$article['article_id']}")) ?>" title="<?= $article['title'] ?>">
								<?= $article['title'] ?>
							</a>
						</h3>
<?php if ($article['image_url'] AND FALSE): ?>
						<a class="photo-frame" href="<?= base_url(strtolower("blog/{$article['category']}/{$article['slug']}/{$article['article_id']}")) ?>" title="<?= $article['title'] ?>">
							<img src="<?= $article['image_url'] ?>" class="img-responsive" alt="<?= $article['title'] ?>"/>
						</a>
<?php endif ?>
						<?= $article['page'] ?>
						<p>
							<a href="<?= base_url(strtolower("blog/{$article['category']}/{$article['slug']}/{$article['article_id']}")) ?>" title="Read more about <?= $article['title'] ?>">
								Read more
							</a>
						</p>
						<hr>
					</div> <!-- /.pull-right -->
				</article>
			<?php endforeach ?>
