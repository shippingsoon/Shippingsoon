			<section class="tagcloud">
				<h3 class="opensans light-weight">
					<span class="glyphicon glyphicon-cloud"></span> Tag Cloud
				</h3>
<?php foreach (explode(',', $tags) AS $tag): ?>
				<a href="<?= base_url('portfolio/search/0/12/'.urlencode($tag)) ?>" title="<?= str_replace('_', ' ', $tag) ?>" data-rel="<?= rand(1, 40) ?>">
					<?= str_replace('_', ' ', $tag) ?>
				</a>
<?php endforeach ?>
			</section>
