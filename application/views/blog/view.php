<div class="container portfolio-container">
	<div class="row">
		<div class="col-md-8">
			<article class="blog-entry">
				<h1 class="title opensans light-weight">
					<a href="<?= base_url("blog/development/{$article['slug']}/{$article['article_id']}") ?>"><?= $article['title'] ?></a>
				</h1>
				<?php if (isset($article['content'])): ?>
					<?= str_replace('\t', "\t", $article['content']) ?>
				<?php endif ?>
			</article> <!-- /.blog-entry -->
