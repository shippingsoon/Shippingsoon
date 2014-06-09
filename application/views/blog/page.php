<?php if ($page AND isset($article['article_id'])): ?>
			<article>
				<h1 class="title opensans light-weight">
					<a href="<?= base_url(strtolower((($article['category'] != 'Portfolio') ? "blog/{$article['category']}" : 'portfolio')."/{$article['slug']}/{$article['article_id']}")) ?>" title="<?= $article['title'] ?>">

						<?= $article['title'] ?>
					</a>
				</h1>
				<?= $page ?>
			</article>
<?php endif ?>