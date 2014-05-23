						<div class="col-md-<?php if ($controller == 'portfolio' AND $method == 'index'): ?>9<?php else: ?>12<?php endif ?> featured-content">
<?php if ($articles): ?>
<?php foreach ($articles AS $article): ?>
							<div class="col-md-<?php if ($controller == 'portfolio' AND $method == 'index'): ?>4<?php else: ?>3<?php endif ?>" data-filters="<?= $article['tags'] ?>">
								<div class="featured photo-frame">
									<img src="<?= base_url("uploads/articles/img/{$article['article_id']}/0.jpg") ?>" class="img-responsive"  alt="<?= $article['title'] ?>"/>
									<section class="overlay">
										<h3 class="title transition">
											<a class="transition" href="<?= base_url((($article['category'] != 'Portfolio') ? strtolower("blog/{$article['category']}") : "portfolio") . "/{$article['slug']}/{$article['article_id']}") ?>" title="Read more about <?= $article['title'] ?>">
												<?= $article['title'] ?>
											</a>
										</h3>
										<p class="subtitle transition">
											<?= $article['description'] ?>
										</p>
										<a href="<?= base_url((($article['category'] != 'Portfolio') ? strtolower("blog/{$article['category']}") : "portfolio") . "/{$article['slug']}/{$article['article_id']}") ?>" title="Read more about <?= $article['title'] ?>">
											<i class="fa fa-search fa-3x transition"></i>
										</a>
<?php if ($article['source_link']): ?>
										<a href="<?= $article['source_link'] ?>" title="View <?= $article['title'] ?>'s source code" target="_blank">
											<i class="fa fa-github fa-3x transition"></i>
										</a>
<?php elseif ($article['live_link']): ?>
										<a href="<?= $article['live_link'] ?>" title="View <?= $article['title'] ?>" target="_blank">
											<i class="fa fa-anchor fa-3x transition"></i>
										</a>
<?php endif ?>
<?php if ($logged_in): ?>
										<a href="<?= base_url("admin/article/{$article['article_id']}/{$article['slug']}") ?>" title="Edit <?= $article['title'] ?>">
											<i class="fa fa-wrench transition"></i>
										</a>
<?php endif ?>
									</section>
								</div> <!-- /.featured .photo-frame -->
							</div> <!-- /.col-md-x -->
<?php endforeach ?>
<?php else: ?>
							<h2 class="centered opensans light-weight">
								No results found for: <b><?= implode(', ', $tags) ?></b>
							</h2>
<?php endif ?>
						</div> <!-- /.col-md-x .featured-content -->
						<div class="col-md-<?php if ($controller == 'portfolio' AND $method == 'index'): ?>4<?php else: ?>3<?php endif ?> template hide">
							<div class="featured photo-frame">
								<img class="img-responsive" alt=""/>
								<section class="overlay">
									<h3 class="title transition"><a class="transition"></a></h3>
									<p class="subtitle transition"></p>
									<a href="" title="Read more about"><i class="fa fa-search fa-3x transition"></i></a>
									<a class="hide" target="_blank"><i class="fa fa-github fa-3x transition"></i></a>
									<a class="hide" target="_blank"><i class="fa fa-anchor fa-3x transition"></i></a>
								</section>
							</div> <!-- /.featured .photo-frame -->
						</div> <!-- /.col-md-x .template .hide -->
					</div> <!-- /.row -->
				</div> <!-- /.container -->
			</div> <!-- /.featured-projects .wrapper -->
