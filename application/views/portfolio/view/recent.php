			<section class="recent-work">
				<h3 class="opensans light-weight">
					<span class="glyphicon glyphicon-picture"></span>
					Recent <?php if ($controller == 'portfolio'): ?>Projects<?php else: ?>Articles<?php endif ?>
				</h3>
<?php foreach ($recent_articles AS $recent): ?>
				<a class="pull-left photo-frame" href="<?= base_url("portfolio/{$recent['slug']}/{$recent['article_id']}") ?>" title="<?= "{$recent['title']} {$recent['version']}" ?>">
					<img src="<?= base_url("uploads/articles/img/{$recent['article_id']}/0.jpg") ?>" class="img-responsive" alt="<?= $title ?>"/>
				</a>
				<div class="pull-left">
					
					<a href="<?= base_url(strtolower((($article['category'] != 'Portfolio') ? "blog/{$article['category']}" : 'portfolio')."/{$recent['slug']}/{$recent['article_id']}")) ?>" title="<?= "{$recent['title']} {$recent['version']}" ?>" class="title">
						<?= "{$recent['title']} {$recent['version']}" ?>
					</a>
					<a href="<?= base_url(strtolower((($article['category'] != 'Portfolio') ? "blog/{$article['category']}" : 'portfolio')."/{$recent['slug']}/{$recent['article_id']}")) ?>" title="<?= "{$recent['title']} {$recent['version']}" ?>" class="subtitle">
						<?= $recent['description'] ?>
					</a>
				</div>
				<div class="clear"></div><br/>
<?php endforeach ?>
			</section>
