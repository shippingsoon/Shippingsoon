<?php if ($page AND isset($article['article_id'])): ?>
			<article>
				<h1 class="title opensans light-weight">
					<a href="<?= base_url("blog/development/{$article['slug']}/{$article['article_id']}") ?>"><?= $article['title'] ?></a>
				</h1>
				<?= $page ?>
			</article>
<?php endif ?>