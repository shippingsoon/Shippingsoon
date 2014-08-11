<div class="container breadcrumb-container">
	<div class="row">
		<div class="col-md-8">
			<ol class="breadcrumb pull-left">
<?php foreach ($breadcrumbs AS $title => $link): ?>
<?php if ($link): ?>
				<li><a href="<?= $link ?>" title="<?= $title ?>"><?= $title ?></a></li>
<?php else: ?>
				<li class="active"><?= $title ?></li>
<?php endif ?>
<?php endforeach ?>
<?php if (isset($article['article_id']) /*AND $logged_in*/):  ?>
				<li>
					<a href="<?= base_url("admin/article/{$article['article_id']}/{$article['slug']}") ?>" class="btn btn-danger btn-xs" title="Edit <?= $article['title'] ?>">
						<span class="glyphicon glyphicon-wrench"></span>
					</a>
				</li>
<?php endif ?>
			</ol>
<?php  if (isset($article['article_id']) /*AND $logged_in*/): ?>
			<time datetime="<?= $article['date_created'] ?>" class="breadcrumb pull-right">
				<i class="fa fa-clock-o"></i> Published: <?= $article['date_created_formatted'] ?>
			</time>
<?php endif ?>
		</div>  <!-- /.col-md-8 -->
	</div> <!-- /.row -->
</div> <!-- /.container .breadcrumb-container -->
